<?php 

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\User;    


if (!function_exists('generate_transaction_id')) {
    function generate_transaction_id($prefix = 'TXN')
    {
        return $prefix . '-' . strtoupper(Str::random(10)) . '-' . time();
    }
}

if (!function_exists('format_money')) {
    function format_money($amount, $currency = 'USD')
    {
        return number_format($amount, 2) . ' ' . strtoupper($currency);
    }
}

if (!function_exists('get_exchange_rate')) {
    function get_exchange_rate($from, $to = 'USD')
    {
        // Example: Call a live API (e.g. CoinGecko)
        try {
            $response = Http::get("https://api.coingecko.com/api/v3/simple/price", [
                'ids' => strtolower($from),
                'vs_currencies' => strtolower($to)
            ]);

            return $response->json()[strtolower($from)][strtolower($to)] ?? null;
        } catch (\Exception $e) {
            Log::error("Exchange rate fetch failed: " . $e->getMessage());
            return null;
        }
    }
}

if (!function_exists('convert_currency')) {
    function convert_currency($amount, $from, $to = 'USD')
    {
        $rate = get_exchange_rate($from, $to);
        return $rate ? $amount * $rate : null;
    }
}

if (!function_exists('log_activity')) {
    function log_activity($userId, $action, $description, $ipAddress, $userAgent)
    {
        \App\Models\ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

if (!function_exists('generate_wallet_address')) {
    function generate_wallet_address($currency)
    {
        switch (strtoupper($currency)) {
            case 'BTC': // Bitcoin
                // Addresses usually start with 1, 3, or bc1
                $prefixes = ['1', '3', 'bc1q'];
                $prefix = $prefixes[array_rand($prefixes)];
                return $prefix . bin2hex(random_bytes(25));

            case 'ETH': // Ethereum
                return '0x' . bin2hex(random_bytes(25));

            case 'USDT': // Tether (ERC25)
                return '0x' . bin2hex(random_bytes(25));

            case 'BNB': // Binance Smart Chain
                return '0x' . bin2hex(random_bytes(25));

            case 'LTC': // Litecoin
                $prefix = (rand(0, 1) ? 'L' : 'M');
                return $prefix . bin2hex(random_bytes(25));

            case 'DOGE': // Dogecoin
                // Doge addresses often start with D
                return 'D' . bin2hex(random_bytes(25));

            case 'XRP': // Ripple
                // Ripple addresses usually start with 'r'
                return 'r' . bin2hex(random_bytes(25));

            case 'ADA': // Cardano
                // Cardano Shelley-era address usually starts with "addr1"
                return 'addr1' . bin2hex(random_bytes(25));

            case 'BCH': // Polkadot
                // Polkadot addresses typically start with "1"
                return 'bc' . bin2hex(random_bytes(25));

            case 'TRX': // TRON
                // TRON addresses typically start with "T"
                return 'T' . bin2hex(random_bytes(25));

            case 'SOL': // Solana
                // Solana addresses are base58, we simulate with hex for now
                return 'SoL' . bin2hex(random_bytes(25));

            default: // Fallback for unsupported currency
                return strtoupper($currency) . '-' . bin2hex(random_bytes(16));
        }
    }
}



if (!function_exists('settings')) {
    function settings($key, $default = null)
    {
        static $cache = [];

        if (isset($cache[$key])) {
            return $cache[$key];
        }

        $value = Setting::where('key', $key)->value('value');

        return $cache[$key] = $value ?? $default;
    }
}


/**
 * Generate unique reference codes (for deposits, withdrawals, etc.)
 */
if (!function_exists('generate_reference')) {
    function generate_reference($prefix = 'REF')
    {
        return $prefix . '-' . strtoupper(Str::random(8)) . '-' . Carbon::now()->timestamp;
    }
}

/**
 * Mask wallet addresses or account numbers for UI
 * Example: BTC-1234...ABCD
 */
if (!function_exists('mask_string')) {
    function mask_string($value, $start = 6, $end = 4)
    {
        return substr($value, 0, $start) . '...' . substr($value, -$end);
    }
}

/**
 * Send system notification via email
 */
if (!function_exists('send_system_email')) {
    function send_system_email($to, $subject, $view, $data = [])
    {
        try {
            Mail::send($view, $data, function ($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            });
        } catch (\Exception $e) {
            Log::error("Email sending failed: " . $e->getMessage());
        }
    }
}

/**
 * Cache helper (default 5 minutes)
 */
if (!function_exists('cache_remember')) {
    function cache_remember($key, $ttl = 300, $callback)
    {
        return Cache::remember($key, $ttl, $callback);
    }
}

/**
 * Format date nicely for UI
 */
if (!function_exists('format_date')) {
    function format_date($date, $format = 'M d, Y h:i A')
    {
        return Carbon::parse($date)->format($format);
    }
}