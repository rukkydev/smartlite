<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trading Dashboard</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons (React Icons Replacement) -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script>
        // Configure Tailwind with your custom colors
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        border: 'hsl(214.3 31.8% 91.4%)',
                        background: 'hsl(0 0% 100%)',
                        foreground: 'hsl(222.2 84% 4.9%)',
                        primary: {
                            DEFAULT: 'hsl(262.1 83.3% 57.8%)',
                            foreground: 'hsl(210 40% 98%)'
                        },
                        muted: {
                            DEFAULT: 'hsl(210 40% 96.1%)',
                            foreground: 'hsl(215.4 16.3% 46.9%)'
                        },
                        accent: 'hsl(262.1 83.3% 57.8%)',
                        card: 'hsl(0 0% 100%)',
                        purple: {
                            50:  '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                        success: {
                            DEFAULT: '#16a34a',
                            light: '#dcfce7',
                            dark: '#166534',
                        },
                        destructive: {
                            DEFAULT: '#dc2626',
                            light: '#fef2f2',
                            dark: '#991b1b',
                        },
                        warning: {
                            DEFAULT: '#f59e0b',
                            light: '#fffbeb',
                            dark: '#92400e',
                        }
                    },
                    animation: {
                        'slide-up': 'slideUp 0.5s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                        'glow-pulse': 'glowPulse 2s ease-in-out infinite',
                    },
                    keyframes: {
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        glowPulse: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '0.5' },
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap');
        
        * {
            font-family: 'DM Sans', sans-serif;
        }
        
        /* Custom styles */
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(139, 92, 246, 0.1);
            box-shadow: 0 4px 20px rgba(139, 92, 246, 0.1);
        }
        
        .trading-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid hsl(214.3 31.8% 91.4%);
        }
        
        .trading-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .ripple {
            position: relative;
            overflow: hidden;
        }
        
        .ripple:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(139, 92, 246, 0.3);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }
        
        .ripple:focus:not(:active)::after {
            animation: ripple 0.6s ease-out;
        }
        
        .pb-safe {
            padding-bottom: env(safe-area-inset-bottom);
        }
        
        /* Bottom Navigation */
        .nav-item {
            position: relative;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 0;
            flex: 1;
            padding: 0.5rem 0;
        }
        
        .nav-item.active {
            color: hsl(262.1 83.3% 57.8%);
        }
        
        .nav-item:not(.active) {
            color: hsl(215.4 16.3% 46.9%);
        }
        
        .nav-item.active::after {
            content: '';
            position: absolute;
            top: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background: hsl(262.1 83.3% 57.8%);
            border-radius: 50%;
        }
        
        /* Animation classes */
        .animate-slide-up {
            animation: slideUp 0.5s ease-out;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-glow-pulse {
            animation: glowPulse 2s ease-in-out infinite;
        }
        
        /* Gradient backgrounds */
        .gradient-bg {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }
        
        .gradient-bg-success {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        }
        
        .gradient-bg-destructive {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        }
        
        .gradient-bg-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="tradingDashboard()">
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6 pb-20">
        <!-- Balance Overview Card -->
        <div class="glass rounded-xl mb-6 relative overflow-hidden animate-slide-up">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/[0.02] to-purple-700/[0.02]"></div>
            <div class="absolute top-4 right-4 w-32 h-32 bg-gradient-radial from-purple-500/5 to-transparent rounded-full blur-2xl animate-float"></div>
            <div class="absolute bottom-4 left-4 w-24 h-24 bg-gradient-radial from-purple-700/5 to-transparent rounded-full blur-xl animate-float" style="animation-delay: 1s"></div>
            
            <div class="p-6 relative z-10 space-y-6">
                <!-- Main Balance Section -->
                <div class="text-center space-y-2">
                    <p class="text-sm font-medium text-purple-600 tracking-wide uppercase">Total Portfolio Value</p>
                    <div class="relative">
                        <h2 class="text-5xl md:text-6xl font-light text-gray-800 tracking-tight">
                            $62,701,843.00
                        </h2>
                        <div class="absolute -inset-2 bg-gradient-to-r from-purple-500/10 via-transparent to-purple-700/10 rounded-2xl blur-lg opacity-50"></div>
                    </div>
                    <div class="flex items-center justify-center gap-2 mt-4">
                        <div class="h-px w-8 bg-gradient-to-r from-transparent to-purple-500/30"></div>
                        <p class="text-sm text-gray-600">561.07 BTC</p>
                        <div class="h-px w-8 bg-gradient-to-l from-transparent to-purple-500/30"></div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-8">
                    <div class="text-center space-y-1 p-4 rounded-2xl bg-gradient-to-br from-white/[0.02] to-white/[0.01] border border-white/[0.05] backdrop-blur-sm">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Active Wallets</p>
                        <p class="text-2xl font-semibold text-gray-800">8</p>
                    </div>
                    <div class="text-center space-y-1 p-4 rounded-2xl bg-gradient-to-br from-white/[0.02] to-white/[0.01] border border-white/[0.05] backdrop-blur-sm">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Today's Trades</p>
                        <p class="text-2xl font-semibold text-gray-800">1</p>
                    </div>
                </div>

                <!-- Last Activity -->
                <div class="text-center">
                    <p class="text-xs text-gray-500 italic">Last activity: 26 Aug, 2025</p>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="trading-card text-center">
                <div class="w-10 h-10 mx-auto mb-2 bg-purple-100 rounded-full flex items-center justify-center">
                    <i data-lucide="wallet" class="text-purple-600"></i>
                </div>
                <p class="text-2xl font-bold text-gray-800">8</p>
                <p class="text-sm text-gray-600">Wallets</p>
            </div>
            
            <div class="trading-card text-center">
                <div class="w-10 h-10 mx-auto mb-2 bg-green-100 rounded-full flex items-center justify-center">
                    <i data-lucide="trending-up" class="text-green-600"></i>
                </div>
                <p class="text-2xl font-bold text-gray-800">1</p>
                <p class="text-sm text-gray-600">Transactions</p>
            </div>
            
            <div class="trading-card text-center">
                <div class="w-10 h-10 mx-auto mb-2 bg-blue-100 rounded-full flex items-center justify-center">
                    <i data-lucide="bar-chart-3" class="text-blue-600"></i>
                </div>
                <p class="text-2xl font-bold text-gray-800">1</p>
                <p class="text-sm text-gray-600">Investments</p>
            </div>
            
            <div class="trading-card text-center">
                <div class="w-10 h-10 mx-auto mb-2 bg-orange-100 rounded-full flex items-center justify-center">
                    <i data-lucide="bitcoin" class="text-orange-600"></i>
                </div>
                <p class="text-2xl font-bold text-gray-800">561</p>
                <p class="text-sm text-gray-600">BTC</p>
            </div>
        </div>

        <!-- Investment Overview -->
        <div class="trading-card mb-6">
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="bar-chart-3" class="w-5 h-5 text-purple-600"></i>
                <h3 class="text-lg font-semibold text-gray-800">Investment Overview</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4">The investment overview of your platform. All Investment</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Currently Activated Investment -->
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">Currently Activated Investment</p>
                    <div class="space-y-1">
                        <p class="text-2xl font-bold text-gray-800">0</p>
                        <p class="text-xs text-gray-500">AMOUNT</p>
                        <p class="text-2xl font-bold text-gray-800">0</p>
                        <p class="text-xs text-gray-500">PLANS</p>
                    </div>
                </div>

                <!-- Paid Profit -->
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">Paid Profit</p>
                    <div class="space-y-1">
                        <p class="text-2xl font-bold text-gray-800">0</p>
                        <p class="text-xs text-gray-500">PAID PROFIT</p>
                    </div>
                </div>

                <!-- All Time Investment -->
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">All Time Investment</p>
                    <div class="space-y-1">
                        <p class="text-2xl font-bold text-gray-800">800.00</p>
                        <p class="text-xs text-gray-500">AMOUNT</p>
                        <p class="text-2xl font-bold text-gray-800">1</p>
                        <p class="text-xs text-gray-500">PLANS</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t border-gray-200">
                <button class="px-6 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors ripple">
                    Investment
                </button>
                <button class="px-6 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors ripple">
                    My Investment
                </button>
                <button class="px-6 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors ripple">
                    Open Trading
                </button>
            </div>
        </div>

        <!-- Trading Strategy Section -->
        <div class="trading-card mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">AMELIA FX</h3>
                    <p class="text-sm text-gray-600">Expert Strategy with Consistency</p>
                    <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-md font-medium">
                        Recommended
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-8 mb-6">
                <div class="text-center">
                    <p class="text-3xl font-bold text-green-600">90%</p>
                    <p class="text-sm text-gray-600">Win Percentage</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-red-600">10%</p>
                    <p class="text-sm text-gray-600">Loss Percentage</p>
                </div>
            </div>

            <div class="space-y-3 mb-6">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Min Trade Amount</span>
                    <span class="text-sm font-medium">200 USD</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Total Copiers</span>
                    <span class="text-sm font-medium">257</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Total Trades</span>
                    <span class="text-sm font-medium">762</span>
                </div>
            </div>

            <div class="flex gap-3">
                <button class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors ripple">
                    Copy Trader
                </button>
                <button class="flex-1 px-4 py-2 bg-yellow-500 text-white rounded-lg font-medium hover:bg-yellow-600 transition-colors ripple">
                    Copier Trades
                </button>
            </div>
        </div>

        <!-- Recent Transactions Section -->
        <div class="trading-card mb-6">
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="clock" class="w-5 h-5 text-purple-600"></i>
                <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4">Your latest transactions and activities</p>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-purple-300 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                            <i data-lucide="arrow-up" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Buy BTC</p>
                            <p class="text-sm text-gray-500">Today, 10:24 AM</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-red-500">-$1,245</p>
                        <p class="text-sm text-gray-500">0.5 BTC</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-purple-300 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                            <i data-lucide="arrow-down" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Sell ETH</p>
                            <p class="text-sm text-gray-500">15 min ago</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-green-500">+$4,200</p>
                        <p class="text-sm text-gray-500">2.5 ETH</p>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-purple-300 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                            <i data-lucide="arrow-up" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Buy ADA</p>
                            <p class="text-sm text-gray-500">1 hour ago</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-red-500">-$850</p>
                        <p class="text-sm text-gray-500">1000 ADA</p>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-purple-300 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                            <i data-lucide="send" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Transfer USDT</p>
                            <p class="text-sm text-gray-500">3 hours ago</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-red-500">-$5,000</p>
                        <p class="text-sm text-gray-500">5000 USDT</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Market Alerts Section -->
        <div class="trading-card mb-6">
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="bell" class="w-5 h-5 text-purple-600"></i>
                <h3 class="text-lg font-semibold text-gray-800">Market Alerts</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4">Stay updated with market movements</p>
            
            <div class="space-y-4">
                <div class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:border-purple-300 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 mt-1">
                        <i data-lucide="bell" class="w-4 h-4 text-green-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">Bitcoin reaches $50K</h4>
                        <p class="text-sm text-gray-600">BTC has crossed the $50,000 resistance level</p>
                        <p class="text-xs text-gray-500 mt-1">5 min ago</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:border-purple-300 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 mt-1">
                        <i data-lucide="bell" class="w-4 h-4 text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">ETH/USD Alert</h4>
                        <p class="text-sm text-gray-600">Ethereum showing strong upward momentum</p>
                        <p class="text-xs text-gray-500 mt-1">12 min ago</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:border-purple-300 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0 mt-1">
                        <i data-lucide="alert-triangle" class="w-4 h-4 text-yellow-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">Market Volatility</h4>
                        <p class="text-sm text-gray-600">High volatility detected in altcoin markets</p>
                        <p class="text-xs text-gray-500 mt-1">30 min ago</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Portfolio Performance Section -->
        <div class="trading-card mb-6">
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="pie-chart" class="w-5 h-5 text-purple-600"></i>
                <h3 class="text-lg font-semibold text-gray-800">Portfolio Performance</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4">Your investment allocation and performance</p>
            
            <div class="space-y-6">
                <div class="text-center">
                    <h3 class="text-3xl font-bold text-gray-800">$187,432</h3>
                    <div class="flex items-center justify-center gap-2 mt-2">
                        <span class="text-lg font-semibold text-green-600">+5.67%</span>
                        <span class="text-sm text-gray-600">(+$10,047)</span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-800">BTC</span>
                            <span class="text-sm text-gray-600">$84,344</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 45%"></div>
                        </div>
                        <div class="text-xs text-gray-500">45%</div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-800">ETH</span>
                            <span class="text-sm text-gray-600">$56,230</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 30%"></div>
                        </div>
                        <div class="text-xs text-gray-500">30%</div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-800">Others</span>
                            <span class="text-sm text-gray-600">$46,858</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 25%"></div>
                        </div>
                        <div class="text-xs text-gray-500">25%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="trading-card mb-6">
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="zap" class="w-5 h-5 text-purple-600"></i>
                <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4">Fast trading and portfolio management</p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <button class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all ripple">
                    <i data-lucide="arrow-up" class="w-6 h-6 text-green-600"></i>
                    <span class="text-sm font-medium">Buy</span>
                </button>
                
                <button class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all ripple">
                    <i data-lucide="arrow-down" class="w-6 h-6 text-red-600"></i>
                    <span class="text-sm font-medium">Sell</span>
                </button>
                
                <button class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all ripple">
                    <i data-lucide="send" class="w-6 h-6 text-purple-600"></i>
                    <span class="text-sm font-medium">Transfer</span>
                </button>
                
                <button class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all ripple">
                    <i data-lucide="wallet" class="w-6 h-6 text-purple-600"></i>
                    <span class="text-sm font-medium">Deposit</span>
                </button>
            </div>
        </div>

        <!-- Top Gainers/Losers Section -->
        <div class="trading-card mb-6">
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="star" class="w-5 h-5 text-purple-600"></i>
                <h3 class="text-lg font-semibold text-gray-800">Market Movers</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4">Top gainers and losers in the market</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Top Gainers -->
                <div>
                    <h4 class="font-semibold text-green-600 mb-4 flex items-center gap-2">
                        <i data-lucide="arrow-up" class="w-4 h-4"></i>
                        Top Gainers
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-green-50 transition-colors">
                            <div>
                                <p class="font-medium text-gray-800">SOL</p>
                                <p class="text-xs text-gray-500">Solana</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-800">$142.50</p>
                                <p class="text-sm text-green-600">+12.45%</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-green-50 transition-colors">
                            <div>
                                <p class="font-medium text-gray-800">AVAX</p>
                                <p class="text-xs text-gray-500">Avalanche</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-800">$35.67</p>
                                <p class="text-sm text-green-600">+8.23%</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-green-50 transition-colors">
                            <div>
                                <p class="font-medium text-gray-800">MATIC</p>
                                <p class="text-xs text-gray-500">Polygon</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-800">$0.89</p>
                                <p class="text-sm text-green-600">+6.78%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Losers -->
                <div>
                    <h4 class="font-semibold text-red-600 mb-4 flex items-center gap-2">
                        <i data-lucide="arrow-down" class="w-4 h-4"></i>
                        Top Losers
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-red-50 transition-colors">
                            <div>
                                <p class="font-medium text-gray-800">DOGE</p>
                                <p class="text-xs text-gray-500">Dogecoin</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-800">$0.087</p>
                                <p class="text-sm text-red-600">-4.12%</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-red-50 transition-colors">
                            <div>
                                <p class="font-medium text-gray-800">SHIB</p>
                                <p class="text-xs text-gray-500">Shiba Inu</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-800">$0.000012</p>
                                <p class="text-sm text-red-600">-3.45%</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-red-50 transition-colors">
                            <div>
                                <p class="font-medium text-gray-800">LTC</p>
                                <p class="text-xs text-gray-500">Litecoin</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-800">$73.21</p>
                                <p class="text-sm text-red-600">-2.89%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional sections would go here following the same pattern -->
        
    </main>

    <!-- Bottom Navigation -->
    <nav class="glass fixed bottom-0 left-0 right-0 z-50 border-t border-white/10 pb-safe">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-around h-16">
                <!-- Home -->
                <button class="nav-item ripple" :class="{ 'active': activeTab === 'home' }" @click="activeTab = 'home'">
                    <i data-lucide="home" class="w-6 h-6 mb-1 transition-colors" :class="{ 'text-purple-600': activeTab === 'home', 'text-gray-500': activeTab !== 'home' }"></i>
                    <span class="text-xs font-medium transition-colors" :class="{ 'text-purple-600': activeTab === 'home', 'text-gray-500': activeTab !== 'home' }">Home</span>
                </button>
                
                <!-- Trading -->
                <button class="nav-item ripple" :class="{ 'active': activeTab === 'trading' }" @click="activeTab = 'trading'">
                    <i data-lucide="trending-up" class="w-6 h-6 mb-1 transition-colors" :class="{ 'text-purple-600': activeTab === 'trading', 'text-gray-500': activeTab !== 'trading' }"></i>
                    <span class="text-xs font-medium transition-colors" :class="{ 'text-purple-600': activeTab === 'trading', 'text-gray-500': activeTab !== 'trading' }">Trading</span>
                </button>
                
                <!-- Portfolio -->
                <button class="nav-item ripple" :class="{ 'active': activeTab === 'portfolio' }" @click="activeTab = 'portfolio'">
                    <i data-lucide="pie-chart" class="w-6 h-6 mb-1 transition-colors" :class="{ 'text-purple-600': activeTab === 'portfolio', 'text-gray-500': activeTab !== 'portfolio' }"></i>
                    <span class="text-xs font-medium transition-colors" :class="{ 'text-purple-600': activeTab === 'portfolio', 'text-gray-500': activeTab !== 'portfolio' }">Portfolio</span>
                </button>
                
                <!-- Wallet -->
                <button class="nav-item ripple" :class="{ 'active': activeTab === 'wallet' }" @click="activeTab = 'wallet'">
                    <i data-lucide="wallet" class="w-6 h-6 mb-1 transition-colors" :class="{ 'text-purple-600': activeTab === 'wallet', 'text-gray-500': activeTab !== 'wallet' }"></i>
                    <span class="text-xs font-medium transition-colors" :class="{ 'text-purple-600': activeTab === 'wallet', 'text-gray-500': activeTab !== 'wallet' }">Wallet</span>
                </button>
                
                <!-- Settings -->
                <button class="nav-item ripple" :class="{ 'active': activeTab === 'settings' }" @click="activeTab = 'settings'">
                    <i data-lucide="settings" class="w-6 h-6 mb-1 transition-colors" :class="{ 'text-purple-600': activeTab === 'settings', 'text-gray-500': activeTab !== 'settings' }"></i>
                    <span class="text-xs font-medium transition-colors" :class="{ 'text-purple-600': activeTab === 'settings', 'text-gray-500': activeTab !== 'settings' }">Settings</span>
                </button>
            </div>
        </div>
    </nav>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Alpine.js data and functions
        function tradingDashboard() {
            return {
                activeTab: 'home',
                
                // Sample data - in a real app this would come from an API
                balanceData: {
                    totalBalance: '62,701,843.00',
                    btcBalance: '561.07'
                },
                
                overviewStats: {
                    wallets: 8,
                    transactions: 1,
                    lastActivity: '26 Aug, 2025'
                },
                
                investmentData: {
                    currentlyActivated: { amount: 0, plans: 0 },
                    paidProfit: { amount: 0 },
                    allTimeInvestment: { amount: '800.00', plans: 1 }
                },
                
                // Add ripple effect to buttons
                init() {
                    this.$nextTick(() => {
                        const buttons = this.$el.querySelectorAll('.ripple');
                        buttons.forEach(button => {
                            button.addEventListener('click', function(e) {
                                const ripple = document.createElement('div');
                                ripple.classList.add('ripple-effect');
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
                }
            }
        }
    </script>
</body>
</html>