@extends('layouts.app')
@section('content')
<main class="grid w-full grow grid-cols-1 place-items-center min-h-screen bg-purple-50 py-12 px-4">
    <div class="w-full max-w-xl p-4 sm:px-5">
        <div class="mb-6 text-center">
            <img src="{{ settings('logo') }}" alt="{{ settings('site_name') }} Logo" class="mx-auto h-16 mb-2">
        </div>
        <div class="bg-white border border-purple-100 rounded-lg shadow-lg px-8 py-10">
            <h2 class="text-2xl font-semibold text-purple-800 mb-2">Two-Factor Authentication</h2>
            <p class="text-purple-400 mb-6">Please enter the code from your authenticator app or a recovery code.</p>
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
            <form method="POST" action="{{ route('two-factor.login') }}" x-data="{ loading: false }" @submit="loading = true" class="space-y-6 mt-5">
                @csrf
                <label class="block">
                    <span class="text-purple-800 block">Code</span>
                    <span class="relative mt-1.5 flex">
                        <input
                            class="form-input mt-2 w-full rounded-lg border border-purple-200 bg-purple-50 px-3 py-3 pl-9 placeholder:text-purple-400 focus:border-purple-500 @error('code') border-error is-invalid @enderror"
                            type="text" name="code" id="code" required autocomplete="one-time-code" placeholder="Enter code" />
                        <span
                            class="pointer-events-none mt-1 absolute flex h-full w-10 items-center justify-center text-purple-400 peer-focus:text-purple-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                    </span>
                    @error('code')
                    <span class="text-xs text-error mt-1 block">{{ $message }}</span>
                    @enderror
                </label>
                <button type="submit"
                    class="btn mt-3 w-full bg-purple-600 text-white font-medium py-3 rounded-lg hover:bg-purple-700 focus:bg-purple-700"
                    :disabled="loading">
                    <span x-show="!loading" class="text-md">Verify</span>
                    <span x-show="loading" class="flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-50" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        Verifying...
                    </span>
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