@extends('layouts.base')

@section('content')
<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Ticker tape by TradingView</span></a></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
  {
  "symbols": [
    {
      "proName": "FOREXCOM:SPXUSD",
      "title": "S&P 500 Index"
    },
    {
      "proName": "FOREXCOM:NSXUSD",
      "title": "US 100 Cash CFD"
    },
    {
      "proName": "FX_IDC:EURUSD",
      "title": "EUR to USD"
    },
    {
      "proName": "BITSTAMP:BTCUSD",
      "title": "Bitcoin"
    },
    {
      "proName": "BITSTAMP:ETHUSD",
      "title": "Ethereum"
    },
    {
      "proName": "BINANCE:BTCUSDT",
      "title": "Binance"
    }
  ],
  "colorTheme": "dark",
  "locale": "en",
  "largeChartUrl": "",
  "isTransparent": false,
  "showSymbolLogo": true,
  "displayMode": "adaptive"
}
  </script>
</div>
<!-- TradingView Widget END -->


           <!-- Finance Card -->
        <div class="relative overflow-hidden from-primary/20 via-primary/10 to-transparent rounded-2xl p-6 glass-card animate-slide-up w-full mt-4 mb-6">
            <!-- Animated background elements -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-200 rounded-full blur-3xl animate-float opacity-50"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-purple-200 rounded-full blur-2xl animate-float opacity-50" style="animation-delay: 1s"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-medium text-purple-600">Total Balance</h3>
                        <button id="toggleBalance" class="p-1 hover:bg-purple-100 rounded-md transition-colors ripple-effect">
                            <svg id="eyeIcon" class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeOffIcon" class="w-4 h-4 text-purple-600 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex items-center gap-1 text-green-500">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        <span class="text-sm font-medium">+12.5%</span>
                    </div>
                </div>

                <div class="mb-6">
                    <div id="balanceVisible" class="space-y-1">
                        <h1 class="text-3xl font-bold text-gray-800">$64,087,070</h1>
                        <p class="text-sm text-gray-600">≈ 501.64 BTC</p>
                    </div>
                    <div id="balanceHidden" class="space-y-1 hidden">
                        <div class="h-8 w-48 bg-gray-200 rounded-lg animate-pulse"></div>
                        <div class="h-4 w-24 bg-gray-200 rounded-md animate-pulse"></div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mb-6">
                    <button class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl py-3 shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                        <svg class="w-3 h-3 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Fund Account
                    </button>
                    <button class="flex-1 border border-purple-300 text-purple-600 hover:bg-purple-50 rounded-xl py-3 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-3 h-3 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Withdraw
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white backdrop-blur-sm rounded-lg p-4 border border-gray-200 shadow-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 bg-purple-500 rounded-full animate-glow-pulse"></div>
                            <span class="text-xs text-gray-600">Active Investments</span>
                        </div>
                        <p class="text-lg font-semibold text-gray-800">8</p>
                    </div>
                    
                    <div class="bg-white backdrop-blur-sm rounded-lg p-4 border border-gray-200 shadow-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 bg-purple-500 rounded-full animate-glow-pulse"></div>
                            <span class="text-xs text-gray-600">Transactions</span>
                        </div>
                        <p class="text-lg font-semibold text-gray-800">1,234</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Quick Actions</h2>
            <div class="grid grid-cols-4 gap-3">
                <button class="flex flex-col items-center p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-exchange-alt text-purple-600"></i>
                    </div>
                    <span class="text-xs font-medium">Transfer</span>
                </button>
                <button class="flex flex-col items-center p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-chart-line text-blue-600"></i>
                    </div>
                    <span class="text-xs font-medium">Invest</span>
                </button>
                <button class="flex flex-col items-center p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-money-bill-wave text-green-600"></i>
                    </div>
                    <span class="text-xs font-medium">Pay</span>
                </button>
                <button class="flex flex-col items-center p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-history text-orange-600"></i>
                    </div>
                    <span class="text-xs font-medium">History</span>
                </button>
            </div>
        </div>


        <!-- Assets List -->
        <div class="p-5">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Digital Assets</h2>
            
            <!-- Bitcoin -->
            <div class="asset-item p-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="asset-logo bg-orange-100 text-orange-600">
                        <i class="fab fa-bitcoin"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Bitcoin</h3>
                        <p class="text-sm text-gray-500">BTC</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-medium text-gray-800">2.456789</p>
                    <p class="text-sm text-gray-500">$64,087.07</p>
                </div>
            </div>
            
            <!-- Ethereum -->
            <div class="asset-item p-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="asset-logo bg-blue-100 text-blue-600">
                        <i class="fab fa-ethereum"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Ethereum</h3>
                        <p class="text-sm text-gray-500">ETH</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-medium text-gray-800">15.678543</p>
                    <p class="text-sm text-gray-500">$3,422.51</p>
                </div>
            </div>
            
            <!-- Cardano -->
            <div class="asset-item p-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="asset-logo bg-teal-100 text-teal-600">
                        ADA
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Cardano</h3>
                        <p class="text-sm text-gray-500">ADA</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-medium text-gray-800">1,250.45</p>
                    <p class="text-sm text-gray-500">$462.38</p>
                </div>
            </div>
            
            <!-- Solana -->
            <div class="asset-item p-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="asset-logo bg-purple-100 text-purple-600">
                        SOL
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Solana</h3>
                        <p class="text-sm text-gray-500">SOL</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-medium text-gray-800">12.345678</p>
                    <p class="text-sm text-gray-500">$1,422.64</p>
                </div>
            </div>
            
            <!-- See More Button -->
            <div class="mt-6">
                <button class="see-more-btn w-full py-3 bg-purple-50 text-purple-600 rounded-lg font-medium flex items-center justify-center space-x-2">
                    <span>See More Assets</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
       
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBalance = document.getElementById('toggleBalance');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');
            const balanceVisible = document.getElementById('balanceVisible');
            const balanceHidden = document.getElementById('balanceHidden');
            
            let balanceVisibleState = true;
            
            toggleBalance.addEventListener('click', function() {
                balanceVisibleState = !balanceVisibleState;
                
                if (balanceVisibleState) {
                    eyeIcon.classList.remove('hidden');
                    eyeOffIcon.classList.add('hidden');
                    balanceVisible.classList.remove('hidden');
                    balanceHidden.classList.add('hidden');
                } else {
                    eyeIcon.classList.add('hidden');
                    eyeOffIcon.classList.remove('hidden');
                    balanceVisible.classList.add('hidden');
                    balanceHidden.classList.remove('hidden');
                }
            });
            
            // Add ripple effect to buttons
            const buttons = document.querySelectorAll('.ripple-effect');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('div');
                    ripple.classList.add('ripple');
                    this.appendChild(ripple);
                    
                    const x = e.clientX - this.getBoundingClientRect().left;
                    const y = e.clientY - this.getBoundingClientRect().top;
                    
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

@endsection