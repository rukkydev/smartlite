<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- *312*561# --}}


    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap');

        * {
            font-family: 'DM Sans', sans-serif;
        }
    </style>
    <script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
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
          slate: {
            400: '#94a3b8',
            // ...add other slate colors if needed
          },
          info: {
            DEFAULT: '#2563eb',    // blue-600
            light: '#dbeafe',      // blue-100
            dark: '#1e40af',       // blue-800
          },
          success: {
            DEFAULT: '#16a34a',    // green-600
            light: '#dcfce7',      // green-100
            dark: '#166534',       // green-800
          },
          error: {
            DEFAULT: '#e3342f',    // red-600
            light: '#fee2e2',      // red-100
            dark: '#991b1b',       // red-800
          },
          danger: {
            DEFAULT: '#b91c1c',    // red-700
            light: '#fee2e2',      // red-100
            dark: '#7f1d1d',       // red-900
          },
          warning: {
            DEFAULT: '#f59e42',    // amber-500
            light: '#fef3c7',      // amber-100
            dark: '#b45309',       // amber-800
          }
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


<body x-data class="is-header-blur" x-bind="$store.global.documentBody">
    <!-- App preloader-->
    <div class="app-preloader fixed z-50 grid h-full w-full place-content-center bg-slate-50 dark:bg-navy-900">
        <div class="app-preloader-inner relative inline-block size-48"></div>
    </div>

    <!-- Page Wrapper -->
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900" x-cloak>
        @yield('content')




        <div id="x-teleport-target"></div>
        <script>
            window.addEventListener("DOMContentLoaded", () => Alpine.start());
        </script>
    </div>
</body>

</html>