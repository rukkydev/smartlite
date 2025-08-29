@extends('layouts.app')
@section('content')
<main class="grid w-full grow grid-cols-1 place-items-center min-h-screen bg-purple-50 py-12 px-4">
    <div class="w-full max-w-2xl p-4 sm:px-5">
        <div class="mb-6 text-center">
            <img src="{{ settings('logo') }}" alt="{{ settings('site_name') }} Logo" class="mx-auto h-16 mb-2">
        </div>
        <div class="bg-white border border-purple-100 rounded-lg shadow-xl px-8 py-10">
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-purple-800 mb-2">Forgot Password</h2>
                <p class="text-purple-400 text-xs sm:text-sm md:text-base">Enter your email to receive a password reset link</p>
            </div>
            @if(session('status'))
                <div x-data="{ show: true }" x-show="show" x-transition.opacity
                    class="flex items-center space-x-2 rounded-lg border border-success px-4 py-4 text-success bg-success-light mb-4"
                    role="alert">
                    <svg class="shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-7V7a1 1 0 112 0v4a1 1 0 01-2 0zm1 4a1 1 0 100-2 1 1 0 000 2z" />
                    </svg>
                    <span class="sr-only">Success</span>
                    <div class="ms-3 text-xs sm:text-sm md:text-base font-medium flex-1">
                        {{ session('status') }}
                    </div>
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
            <form method="POST" action="{{ route('password.email') }}" x-data="{ loading: false }" @submit="loading = true" class="space-y-6 mt-5">
                @csrf
                <label class="block">
                    <span class="text-purple-800 block">Email Address</span>
                    <span class="relative mt-1.5 flex">
                        <input
                            class="form-input mt-2 w-full rounded-lg border border-purple-200 bg-purple-50 px-3 py-3 pl-9 placeholder:text-purple-400 focus:border-purple-500 @error('email') border-error is-invalid @enderror"
                            placeholder="Enter your email address" type="email" name="email" id="email" required autofocus
                            autocomplete="email" value="{{ old('email') }}" />
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
                <button type="submit"
                    class="btn mt-3 w-full bg-purple-600 text-white font-medium py-3 rounded-lg hover:bg-purple-700 focus:bg-purple-700"
                    :disabled="loading">
                    <span x-show="!loading" class="text-md">Send Password Reset Link</span>
                    <span x-show="loading" class="flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-50" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        Sending...
                    </span>
                </button>
            </form>
        </div>
        <div class="mt-8 text-center text-xs text-purple-400">
            <p>
                © {{ date('Y') }} {{ settings('site_name') }} Gold. All Rights Reserved.
            </p>
            <div class="flex flex-wrap justify-center gap-4 text-xs mt-2">
                <a href="#" class="text-purple-600 hover:text-purple-500">Terms & Condition</a>
                <a href="#" class="text-purple-600 hover:text-purple-500">Privacy Policy</a>
                <a href="#" class="text-purple-600 hover:text-purple-500">Help Center</a>
            </div>
        </div>
    </div>
</main>
@endsection