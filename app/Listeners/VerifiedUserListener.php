<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Account;
use App\Models\Transaction;
use App\Notifications\WelcomeNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;


class VerifiedUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Verified $event)
    {
        $user = $event->user;

        // Check if default fiat account already exists
        $fiatAccount = Account::where('user_id', $user->id)
            ->where('type', 'fiat')
            ->where('currency', 'USD')
            ->first();

        if (!$fiatAccount) {
            $fiatAccount = Account::create([
                'user_id' => $user->id,
                'type' => 'fiat',
                'currency' => 'USD',
                'address' => null,
                'balance' => 0,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (!$fiatAccount) {
                throw new \Exception('Failed to create default fiat account.');
            }
        }

        // Supported crypto currencies
        $cryptoCurrencies = ['BTC', 'ETH', 'USDT', 'BNB', 'LTC', 'DOGE', 'XRP', 'TRX', 'BCH'];

        foreach ($cryptoCurrencies as $currency) {
            $cryptoAccount = Account::where('user_id', $user->id)
                ->where('type', 'crypto')
                ->where('currency', $currency)
                ->first();

            if (!$cryptoAccount) {
                $cryptoAccount = Account::create([
                    'user_id' => $user->id,
                    'type' => 'crypto',
                    'currency' => $currency,
                    'address' => generate_wallet_address($currency),
                    'balance' => 0,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if (!$cryptoAccount) {
                    throw new \Exception("Failed to create default crypto account for {$currency}.");
                }
            }
        }

        // Apply signup bonus only if not already applied
        $signupBonus = settings('signup_bonus', 10);
        $bonusExists = Transaction::where('user_id', $user->id)
            ->where('method', 'signup_bonus')
            ->exists();

        if ($signupBonus > 0 && !$bonusExists) {
            $bonusTransaction = Transaction::create([
                'user_id' => $user->id,
                'account_id' => $fiatAccount->id,
                'type' => 'credit',
                'method' => null,
                'amount' => $signupBonus,
                'currency' => 'USD',
                'status' => 'completed',
                'tx_hash' => null,
                'reference' => 'TRX-' . Str::upper(Str::random(8)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (!$bonusTransaction) {
                throw new \Exception('Failed to apply signup bonus transaction.');
            }

            // Update fiat account balance
            $fiatAccount->balance += $signupBonus; // Add to existing balance if re-verifying
            $fiatAccount->save();
        }

        // Send welcome notification and log activity only if defaults were created (or always, but here tied to no existing accounts for idempotency)
        if (!$fiatAccount->wasRecentlyCreated && !$cryptoAccount->wasRecentlyCreated) {
            return; // Skip if no new accounts created (already onboarded)
        }

        // Send welcome notification (mail + database)
        try {
            Notification::send($user, new WelcomeNotification());
        } catch (\Exception $e) {
            throw new \Exception('Failed to send welcome notification: ' . $e->getMessage());
        }

        // Log activity
        try {
            log_activity($user->id, 'onboarding_completed', "User completed onboarding with fiat and crypto accounts.", request()->ip(), request()->userAgent());
        } catch (\Exception $e) {
            throw new \Exception('Failed to log onboarding activity: ' . $e->getMessage());
        }
    }
}
