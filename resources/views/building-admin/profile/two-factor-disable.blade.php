@extends('building-admin.layout')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col bg-background-light dark:bg-background-dark pb-24">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-5 py-4 flex items-center justify-between">
        <a href="{{ route('building-admin.admin-profile') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
            <span class="material-symbols-outlined text-2xl">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex-1 ml-4">Disable 2FA</h1>
    </header>

    <div class="max-w-md mx-auto w-full px-5 py-6 flex-1">
        <!-- Warning -->
        <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-4 border border-red-100 dark:border-red-800 mb-6">
            <div class="flex gap-3">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400 flex-shrink-0">warning</span>
                <div>
                    <p class="text-sm font-semibold text-red-900 dark:text-red-100 mb-1">Disable 2FA?</p>
                    <p class="text-xs text-red-900 dark:text-red-100">Disabling Two-Factor Authentication will make your account less secure. You'll only need your password to log in.</p>
                </div>
            </div>
        </div>

        <!-- Disable Form -->
        <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700">
            <form method="POST" action="{{ route('building-admin.admin-profile.two-factor-disable') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Confirm Password</label>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">Enter your password to disable 2FA:</p>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your password" />
                    @error('password')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('building-admin.admin-profile') }}" class="flex-1 px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 font-semibold transition-colors text-center">
                        Cancel
                    </a>
                    <button type="submit" class="flex-1 px-4 py-3 rounded-lg bg-red-600 text-white hover:bg-red-700 font-semibold transition-colors">
                        Disable 2FA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
