<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Account;
use Dotenv\Util\Str;
use Illuminate\Support\Facades\DB;

class DepositService
{
    public function createDeposit($user, $account, $paymentMethodId, $amount, $currency)
    {
        return DB::transaction(function () use ($user, $account, $paymentMethodId, $amount, $currency) {
            return Transaction::create([
                'user_id' => $user->id,
                'account_id' => $account->id,
                'type' => 'deposit',
                'payment_method_id' => $paymentMethodId,
                'amount' => $amount,
                'currency' => $currency,
                'status' => 'pending',
                'reference' => 'TRX-' . Str::upper(Str::random(8)),
            ]);
        });
    }
}
