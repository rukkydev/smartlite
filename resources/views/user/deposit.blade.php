{{-- deposit.blade.php --}}
@extends('layouts.app')

@php
    $appHeader = request()->query('appHeader', '1'); // Default to showing app header
@endphp

@section('content')
<main class="content-area mobile-container mt-16">
    {{-- Conditional Header --}}
    @if($appHeader == "1")
        {{-- App Header (default) --}}
        <header class="transparent-header text-white fixed top-0 left-0 right-0 z-40">
            <div class="flex items-center justify-between p-4 mobile-container">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-md">
                        <span class="font-bold text-purple-800">JD</span>
                    </div>
                    <div class="backdrop-blur-md bg-white/30 rounded-full px-3 py-1">
                        <p class="text-xs text-purple-800 font-medium">Welcome, {{ auth()->user()->name }}!</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <button class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors backdrop-blur-md bg-white/30">
                            <i class="far fa-bell text-purple-800"></i>
                            <span class="notification-dot"></span>
                        </button>
                    </div>
                    <button class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors backdrop-blur-md bg-white/30">
                        <i class="fas fa-cog text-purple-800"></i>
                    </button>
                </div>
            </div>
        </header>
    @else
        {{-- Page-specific Header with Back Button --}}
        <header class="bg-white fixed top-0 left-0 right-0 z-40 shadow-sm">
            <div class="flex items-center justify-between p-4 mobile-container">
                <a href="{{ url()->previous() }}" class="flex items-center text-purple-600">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span>Back</span>
                </a>
                <h1 class="text-lg font-semibold text-gray-800">Deposit Funds</h1>
                <div class="w-10"></div> {{-- Spacer for balance --}}
            </div>
        </header>
    @endif

    {{-- Main Content --}}
    <div class="animate-slide-up">
        {{-- Page Title --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Deposit Funds</h2>
            <p class="text-gray-600">Add money to your account securely</p>
        </div>

        {{-- Deposit Card --}}
        <div class="glass-card rounded-xl p-6 mb-6">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Amount to Deposit</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                    <input type="number" placeholder="0.00" class="w-full pl-8 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent" value="100.00">
                </div>
            </div>

            {{-- Payment Methods --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method</label>
                <div class="space-y-3">
                    <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:border-purple-500 transition-colors">
                        <input type="radio" name="paymentMethod" id="card" class="h-4 w-4 text-purple-600 focus:ring-purple-500" checked>
                        <label for="card" class="ml-3 flex items-center">
                            <i class="fas fa-credit-card text-purple-600 mr-2"></i>
                            <span>Credit/Debit Card</span>
                        </label>
                    </div>
                    
                    <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:border-purple-500 transition-colors">
                        <input type="radio" name="paymentMethod" id="bank" class="h-4 w-4 text-purple-600 focus:ring-purple-500">
                        <label for="bank" class="ml-3 flex items-center">
                            <i class="fas fa-university text-purple-600 mr-2"></i>
                            <span>Bank Transfer</span>
                        </label>
                    </div>
                    
                    <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:border-purple-500 transition-colors">
                        <input type="radio" name="paymentMethod" id="crypto" class="h-4 w-4 text-purple-600 focus:ring-purple-500">
                        <label for="crypto" class="ml-3 flex items-center">
                            <i class="fab fa-bitcoin text-purple-600 mr-2"></i>
                            <span>Cryptocurrency</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Card Details (shown by default) --}}
            <div id="cardDetails">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                        <input type="text" placeholder="1234 5678 9012 3456" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                        <input type="text" placeholder="123" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                        <input type="text" placeholder="MM/YY" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name</label>
                        <input type="text" placeholder="John Doe" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            {{-- Bank Details (hidden by default) --}}
            <div id="bankDetails" class="hidden">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Account Number</label>
                    <input type="text" placeholder="Enter account number" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Routing Number</label>
                    <input type="text" placeholder="Enter routing number" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Account Holder Name</label>
                    <input type="text" placeholder="John Doe" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>

            {{-- Crypto Details (hidden by default) --}}
            <div id="cryptoDetails" class="hidden">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Cryptocurrency</label>
                    <select class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option>Bitcoin (BTC)</option>
                        <option>Ethereum (ETH)</option>
                        <option>USDT</option>
                        <option>USDC</option>
                    </select>
                </div>
                
                <div class="mb-6 p-4 bg-purple-50 rounded-lg">
                    <p class="text-sm text-purple-700 mb-2">Send exactly <span class="font-bold">0.0054321 BTC</span> to:</p>
                    <div class="flex items-center justify-between bg-white p-3 rounded border border-purple-200">
                        <span class="text-xs text-gray-600 truncate">bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq</span>
                        <button class="text-purple-600">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Network: Bitcoin Mainnet</p>
                </div>
            </div>

            <button class="w-full py-3 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors ripple-effect">
                Deposit Funds
            </button>
        </div>

        {{-- Recent Deposits --}}
        <div class="card mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Deposits</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-arrow-down text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Bank Transfer</p>
                            <p class="text-sm text-gray-500">Yesterday, 2:30 PM</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-green-600">+$500.00</p>
                        <p class="text-sm text-gray-500">Completed</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fab fa-bitcoin text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Bitcoin</p>
                            <p class="text-sm text-gray-500">Aug 12, 10:24 AM</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-green-600">+$1,245.00</p>
                        <p class="text-sm text-gray-500">Completed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle payment method details
        const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
        const cardDetails = document.getElementById('cardDetails');
        const bankDetails = document.getElementById('bankDetails');
        const cryptoDetails = document.getElementById('cryptoDetails');
        
        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                if (this.id === 'card') {
                    cardDetails.classList.remove('hidden');
                    bankDetails.classList.add('hidden');
                    cryptoDetails.classList.add('hidden');
                } else if (this.id === 'bank') {
                    cardDetails.classList.add('hidden');
                    bankDetails.classList.remove('hidden');
                    cryptoDetails.classList.add('hidden');
                } else if (this.id === 'crypto') {
                    cardDetails.classList.add('hidden');
                    bankDetails.classList.add('hidden');
                    cryptoDetails.classList.remove('hidden');
                }
            });
        });
        
        // Copy crypto address
        document.querySelector('[class*="fa-copy"]').addEventListener('click', function() {
            const address = 'bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq';
            navigator.clipboard.writeText(address).then(() => {
                alert('Address copied to clipboard!');
            });
        });
    });
</script>
@endsection