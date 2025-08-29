<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Services\DepositService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::where('active', true)->get();
        return view('deposit.index', compact('methods'));
    }

    public function store(Request $request, DepositService $depositService)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|exists:payment_methods,id',
        ]);

        $account = Auth::user()->account; // assuming 1 account per user
        $deposit = $depositService->createDeposit(
            Auth::user(),
            $account,
            $request->payment_method,
            $request->amount,
            $account->currency
        );

        return redirect()->route('deposit.gateway', $deposit->payment_method_id)
            ->with('success', 'Redirecting to payment gateway...');
    }

    public function gateway($paymentMethodId)
    {
        $method = PaymentMethod::findOrFail($paymentMethodId);
        return view('deposit.gateway', compact('method'));
    }
}
