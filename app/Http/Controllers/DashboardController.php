<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class DashboardController extends Controller
{
    //

    public function index() {

        $user = Auth::user();

        $cryptoAccounts = $user->cryptoAccounts()
            ->orderBy('balance', 'desc')
            ->get();


        // Get user's fiat accounts
        $fiatAccounts = $user->fiatAccounts()
            ->orderBy('balance', 'desc')
            ->get();

        // Calculate total portfolio value (placeholder - you'd need real prices)
        // $totalValue = $user->calculatePortfolioValue($cryptoAccounts);
        return view('user.home', compact('cryptoAccounts','fiatAccounts'));
    }


     public function getCryptoAssets(Request $request)
    {
        $user = Auth::user();
        $limit = $request->get('limit', 10);
        $offset = $request->get('offset', 0);

        $accounts = $user->cryptoAccounts()
            ->orderBy('balance', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();

        return response()->json([
            'accounts' => $accounts,
            'hasMore' => $user->cryptoAccounts()->count() > ($offset + $limit)
        ]);
    }

    private function calculatePortfolioValue($accounts)
    {
        // Placeholder calculation
        // In a real app, you'd fetch current prices from an API like CoinGecko
        $mockPrices = [
            'BTC' => 64087.07,
            'ETH' => 3422.51,
            'USDT' => 1.00,
            'BNB' => 584.32,
            'LTC' => 91.45,
            'DOGE' => 0.37,
            'XRP' => 0.53,
            'TRX' => 0.16,
            'BCH' => 462.38
        ];

        $totalValue = 0;
        foreach ($accounts as $account) {
            $price = $mockPrices[$account->currency] ?? 0;
            $totalValue += $account->balance * $price;
        }

        return $totalValue;
    }

    public function demo() {
        return view('user.demo');
    }
}
