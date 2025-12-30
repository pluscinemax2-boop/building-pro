@extends('layouts.app')

@section('title', '2FA Verification')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 bg-background-light dark:bg-background-dark">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                        <span class="material-symbols-outlined text-white text-3xl">shield</span>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-text-main dark:text-white">Two-Factor Authentication</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Enter your 6-digit code</p>
            </div>

            <!-- Welcome Text -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900">Verify Your Identity</h2>
                <p class="text-gray-600 text-sm mt-1">Please enter the 6-digit code from your authenticator app</p>
            </div>

            <!-- Error Message -->
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400 mr-3">error</span>
                    <p class="text-red-700 dark:text-red-300 text-sm">{{ $errors->first() }}</p>
                </div>
            </div>
            @endif

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 mr-3">check_circle</span>
                    <p class="text-green-700 dark:text-green-300 text-sm">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('verify-2fa-code') }}" class="space-y-4">
                @csrf
                <!-- 2FA Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-text-main dark:text-white mb-2">Authentication Code</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">password</span>
                        <input
                            type="text"
                            id="code"
                            name="code"
                            required
                            maxlength="6"
                            inputmode="numeric"
                            pattern="[0-9]{6}"
                            class="w-full pl-10 pr-4 py-3 border border-border dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition bg-white dark:bg-surface-dark text-text-main dark:text-white text-center text-xl tracking-widest"
                            placeholder="000000"
                            autocomplete="off"
                        >
                    </div>
                    @error('code')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Info Message -->
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
                    <div class="flex items-start space-x-2">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mt-0.5 text-sm">info</span>
                        <p class="text-xs text-blue-700 dark:text-blue-300">Open your authenticator app to get your 6-digit code</p>
                    </div>
                </div>
                
                <!-- Resend Code Link (if needed) -->
                <div class="text-center pt-2">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Having trouble? 
                        <a href="/login" class="text-primary hover:text-primary/80 font-medium">Back to Login</a>
                    </p>
                </div>
                
                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-primary text-white font-bold py-3 rounded-lg hover:bg-primary/90 transition duration-200 flex items-center justify-center space-x-2 mt-4"
                >
                    <span>Verify Code</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-border dark:border-gray-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white dark:bg-surface-dark text-gray-500 dark:text-gray-400">Or</span>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center pt-6 border-t border-border dark:border-gray-700">
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Need help?
                    <a href="#" class="text-primary hover:text-primary/80 font-bold">Contact Support</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection