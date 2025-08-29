@extends('layouts.app')
@section('content')
<main class="grid w-full grow grid-cols-1 place-items-center min-h-screen bg-purple-50 py-12 px-4">
    <div class="w-full max-w-xl p-4 sm:px-5">
        <div class="mb-6 text-center">
            <img src="{{ settings('logo') }}" alt="{{ settings('site_name') }} Logo" class="mx-auto h-16 mb-2">
        </div>
        <div class="bg-white border border-purple-100 rounded-lg shadow-lg px-8 py-10">
            <h2 class="text-2xl font-semibold text-purple-800 mb-2">Email Verification</h2>
            <p class="text-purple-400 mb-6">Before proceeding, please check your email for a verification link.</p>
            @if(session('status') == 'verification-link-sent')
                <div x-data="{ show: true }" x-show="show" x-transition.opacity
                    class="flex items-center space-x-2 rounded-lg border border-success px-4 py-4 text-success bg-success-light mb-4"
                    role="alert">
                    <svg class="shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-7V7a1 1 0 112 0v4a1 1 0 01-2 0zm1 4a1 1 0 100-2 1 1 0 000 2z" />
                    </svg>
                    <span class="sr-only">Success</span>
                    <div class="ms-3 text-sm font-medium flex-1">
                        A new verification link has been sent to your email address.
                    </div>
                    <button type="button" @click="show = false" class="ms-2 text-success hover:text-success-dark">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition.opacity
                    class="flex items-center space-x-2 rounded-lg border border-error px-4 py-4 text-error bg-error-light mb-4"
                    role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="flex-1">{{ session('error') }}</div>
                    <button type="button" @click="show = false" class="text-error hover:text-error-dark">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif
            <form method="POST" action="{{ route('verification.send') }}" x-data="{ loading: false }" @submit="loading = true" class="mb-4">
                @csrf
                <button type="submit"
                    class="btn mt-3 w-full bg-purple-600 text-white font-medium py-3 rounded-lg hover:bg-purple-700 focus:bg-purple-700"
                    :disabled="loading">
                    <span x-show="!loading" class="text-md">Resend Verification Email</span>
                    <span x-show="loading" class="flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-50" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        Sending...
                    </span>
                </button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn w-full text-purple-600 hover:text-purple-700 font-medium py-2 rounded-lg bg-purple-50 mt-2">
                    Log Out
                </button>
            </form>
        </div>
        <div class="mt-8 flex justify-center text-xs text-purple-400">
            <a href="#">Privacy Notice</a>
            <div class="mx-3 my-1 w-px bg-purple-100"></div>
            <a href="#">Term of service</a>
        </div>
    </div>
</main>
@endsection