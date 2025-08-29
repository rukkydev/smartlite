<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>


   
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#8b5cf6">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Finance App">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap');
        
        * {
            font-family: 'DM Sans', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(139, 92, 246, 0.15);
            box-shadow: 0 4px 20px rgba(139, 92, 246, 0.1);
        }
        
        .ripple-effect {
            position: relative;
            overflow: hidden;
        }
        
        .ripple-effect:after {
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
        
        .ripple-effect:focus:not(:active)::after {
            animation: ripple 0.6s ease-out;
        }
        
        .animate-slide-up {
            animation: slideUp 0.5s ease-out;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-glow-pulse {
            animation: glowPulse 2s ease-in-out infinite;
        }
        
        /* Mobile-specific styling */
        .mobile-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid rgba(139, 92, 246, 0.1);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
            z-index: 50;
        }
        
        .notification-dot {
            position: absolute;
            top: 0;
            right: 0;
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
        }
        
        /* Transparent header */
        .transparent-header {
            background: transparent;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: none;
            box-shadow: none;
        }
        
        .content-area {
            padding-bottom: 80px;
            padding-top: 1rem;
        }
        
        /* Safe area for notch phones */
        @supports(padding: max(0px)) {
            .content-area, .pwa-header {
                padding-left: max(1rem, env(safe-area-inset-left));
                padding-right: max(1rem, env(safe-area-inset-right));
            }
            
            .bottom-nav {
                padding-bottom: env(safe-area-inset-bottom);
            }
        }
        
        /* Reusable components */
        .card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background: #8b5cf6;
            color: white;
            font-weight: 500;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-primary:hover {
            background: #7c3aed;
        }
        
        .btn-secondary {
            border: 1px solid #ddd6fe;
            color: #8b5cf6;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-secondary:hover {
            background: #f5f3ff;
        }
        
        /* Keyframes for animations */
        @keyframes slideUp {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes glowPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
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
                        }
                    },
                    animation: {
                        'slide-up': 'slideUp 0.5s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                        'glow-pulse': 'glowPulse 2s ease-in-out infinite',
                    }
                }
            }
        }
    </script>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="{{ asset('app/css/app.css') }}">

    <script src="{{ asset('app/js/app.js') }}" defer></script>

{{-- 
    <script>
        localStorage.getItem("_x_darkMode_on") === "true" &&
        document.documentElement.classList.add("dark");
    </script> --}}
</head>


<body x-data class="is-header-blur min-h-screen flex flex-col px-3" x-bind="$store.global.documentBody">
    <!-- App preloader-->
    <div class="app-preloader fixed z-50 grid h-full w-full place-content-center bg-slate-50 dark:bg-navy-900">
        <div class="app-preloader-inner relative inline-block size-48"></div>
    </div>

      <!-- Transparent Header -->
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


    <!-- Page Wrapper -->
    <div id="root" x-cloak>

        @yield('content')






        
  


         <div id="x-teleport-target"></div>
        <script>
            window.addEventListener("DOMContentLoaded", () => Alpine.start());
        </script>


    </div>

    
    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <div class="flex justify-around py-3">
            <a href="{{ url('/home') }}" class="flex flex-col items-center space-y-1 p-2 {{ Request::is('home') ? 'text-purple-600' : 'text-gray-500' }}">
                <i class="fas fa-home text-lg"></i>
                <span class="text-xs font-medium">Home</span>
            </a>
            <a href="{{ url('/portfolio') }}" class="flex flex-col items-center space-y-1 p-2 {{ Request::is('portfolio') ? 'text-purple-600' : 'text-gray-500' }}">
                <i class="fas fa-chart-pie text-lg"></i>
                <span class="text-xs font-medium">Portfolio</span>
            </a>
            <a href="{{ url('/trade') }}" class="flex flex-col items-center space-y-1 p-2 {{ Request::is('trade') ? 'text-purple-600' : 'text-gray-500' }}">
                <i class="fas fa-exchange-alt text-lg"></i>
                <span class="text-xs font-medium">Trade</span>
            </a>
            <a href="{{ url('/markets') }}" class="flex flex-col items-center space-y-1 p-2 {{ Request::is('markets') ? 'text-purple-600' : 'text-gray-500' }}">
                <i class="fas fa-chart-line text-lg"></i>
                <span class="text-xs font-medium">Markets</span>
            </a>
            <a href="{{ url('/profile') }}" class="flex flex-col items-center space-y-1 p-2 {{ Request::is('profile') ? 'text-purple-600' : 'text-gray-500' }}">
                <i class="fas fa-user text-lg"></i>
                <span class="text-xs font-medium">Profile</span>
            </a>
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Balance visibility toggle
            const toggleBalance = document.getElementById('toggleBalance');
            if (toggleBalance) {
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
            }
            
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
            
            // Active nav link highlighting
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.bottom-nav a');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('text-purple-600');
                    link.classList.remove('text-gray-500');
                }
            });
        });
    </script>

    
</body>

</html>