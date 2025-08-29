@extends('layouts.app')
@section('content')

<main class="grid w-full grow grid-cols-1 place-items-center min-h-screen bg-purple-50 py-12 px-4">
    <div class="w-full max-w-2xl p-4 sm:px-5">
        <div class="mb-6 text-center">
            <img src="{{ settings('logo') }}" alt="{{ settings('site_name') }} Logo" class="mx-auto h-16 mb-2">
        </div>
        <div class="bg-white border border-purple-100 rounded-lg shadow-lg px-8 py-10">
            <!-- Welcome Header inside card -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-purple-800 mb-1">Welcome Back</h2>
                <p class="">Access your {{ settings('site_name') }} account using your email and password.</p>
            </div>
            <!-- Alerts -->
            @if(session('status'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity
                class="flex items-center space-x-2 rounded-lg border border-success px-4 py-4 text-success bg-success-light mb-4"
                role="alert">
                <svg class="shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-7V7a1 1 0 112 0v4a1 1 0 01-2 0zm1 4a1 1 0 100-2 1 1 0 000 2z" />
                </svg>
                <span class="sr-only">Success</span>
                <div class="ms-3 text-sm font-medium flex-1">{{ session('status') }}</div>
                <button type="button" @click="show = false" class="ms-2 text-success hover:text-success-dark">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            @endif
            @if($errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition.opacity
                class="flex items-center space-x-2 rounded-lg border border-error px-4 py-4 text-error bg-error-light mb-4"
                role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    {!! implode('', $errors->all('<p>:message</p>')) !!}
                </div>
                <button type="button" @click="show = false" class="text-error hover:text-error-dark">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            @endif
            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" x-data="{ loading: false }" @submit="loading = true"
                class="space-y-6 mt-5">
                @csrf
                <label class="block">
                    <span class="text-purple-800 block">Email Address</span>
                    <span class="relative mt-1.5 flex">
                        <input
                            class="form-input mt-2 w-full rounded-lg border border-purple-200 bg-purple-50 px-3 py-3 pl-9 placeholder:text-purple-400 focus:border-purple-500 @error('email') border-error is-invalid @enderror"
                            placeholder="Enter Email Address" type="email" name="email" id="email" required autofocus
                            autocomplete="email" :value="old('email')" />
                        <span
                            class="pointer-events-none mt-1 absolute flex h-full w-10 items-center justify-center text-purple-400 peer-focus:text-purple-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                    </span>
                    @error('email')
                    <span class="text-xs text-error mt-1 block">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block">
                    <span class="text-purple-800 block">Password</span>
                    <span class="relative mt-1.5 flex">
                        <input
                            class="form-input w-full mt-2 rounded-lg border border-purple-200 bg-purple-50 px-3 pl-9 py-3 placeholder:text-purple-400 focus:border-purple-500 @error('password') border-error is-invalid @enderror"
                            placeholder="Enter Password" type="password" name="password" id="password" required
                            autocomplete="current-password" />
                        <span
                            class="pointer-events-none absolute flex h-full w-10 mt-1 items-center justify-center text-purple-400 peer-focus:text-purple-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        @error('password')
                        <span class="text-xs text-error mt-1 block">{{ $message }}</span>
                        @enderror
                    </span>
                </label>
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center space-x-2">
                        <input class="form-checkbox is-basic size-5 rounded-sm border-slate-400/70 border checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent" type="checkbox">
                        <span class="text-purple-800">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-purple-600 hover:text-purple-700">Forgot Password?</a>
                </div>
                <button type="submit"
                    class="btn mt-3 w-full bg-purple-600 text-white font-medium py-3 rounded-lg hover:bg-purple-700 focus:bg-purple-700"
                    :disabled="loading">
                    <span x-show="!loading" class="text-md">Sign In to {{ settings('site_name') }} Account</span>
                    <span x-show="loading" class="flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-50" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        Signing in...
                    </span>
                </button>
            </form>
            <div class="mt-6 text-center text-sm">
                <p>
                    <span>Don't have an account?</span>
                    <a class="text-purple-600 hover:text-purple-700 font-medium" href="{{ route('register') }}">Create
                        account</a>
                </p>
            </div>
            <div class="my-7 flex items-center space-x-3">
                <div class="h-px flex-1 bg-purple-100"></div>
                <p class="text-purple-400">OR</p>
                <div class="h-px flex-1 bg-purple-100"></div>
            </div>
            <div class="flex space-x-4">
                <button class="btn w-full border border-purple-200 text-purple-700 hover:bg-purple-50 py-3 rounded-lg">
                    <img class="h-5 w-5 mr-2" src="images/logos/google.svg" alt="logo" />
                    Google
                </button>
                <button class="btn w-full border border-purple-200 text-purple-700 hover:bg-purple-50 py-3 rounded-lg">
                    <img class="h-5 w-5 mr-2" src="images/logos/github.svg" alt="logo" />
                    Github
                </button>
            </div>
        </div>
        <div class="mt-8 flex justify-center text-xs text-purple-400">
            <a href="#">Privacy Notice</a>
            <div class="mx-3 my-1 w-px bg-purple-100"></div>
            <a href="#">Term of service</a>
        </div>
    </div>
</main>
@endsection