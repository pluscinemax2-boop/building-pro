@extends('building-admin.layout')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col bg-background-light dark:bg-background-dark pb-24">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-5 py-4 flex items-center justify-between">
        <a href="{{ route('building-admin.admin-profile') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
            <span class="material-symbols-outlined text-2xl">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex-1 ml-4">Change Password</h1>
    </header>

    <div class="max-w-md mx-auto w-full px-5 py-6 flex-1">
        <!-- Warning Section -->
        <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4 border border-amber-100 dark:border-amber-800 mb-6">
            <div class="flex gap-3">
                <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 flex-shrink-0">info</span>
                <p class="text-sm text-amber-900 dark:text-amber-100">Keep your password strong and unique. Change it regularly to maintain security.</p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('building-admin.admin-profile.password.update') }}" class="space-y-6">
            @csrf

            <!-- Current Password -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Current Password</label>
                <input type="password" name="current_password" required class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your current password" />
                @error('current_password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">New Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter a strong password" />
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Minimum 8 characters</p>
                @error('password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Confirm New Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Confirm your new password" />
                @error('password_confirmation')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Requirements -->
            <div class="bg-slate-50 dark:bg-surface-dark rounded-xl p-4 border border-slate-200 dark:border-slate-700">
                <p class="text-xs font-semibold text-slate-900 dark:text-white mb-2">Password Requirements:</p>
                <ul class="text-xs text-slate-600 dark:text-slate-400 space-y-1">
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        At least 8 characters long
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        Contains uppercase letters (A-Z)
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        Contains lowercase letters (a-z)
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        Contains numbers (0-9)
                    </li>
                </ul>
            </div>

            <!-- Button Group -->
            <div class="flex gap-3 pt-6">
                <a href="{{ route('building-admin.profile') }}" class="flex-1 px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 font-semibold transition-colors text-center">
                    Cancel
                </a>
                <button type="submit" class="flex-1 px-4 py-3 rounded-lg bg-primary text-white hover:bg-blue-600 font-semibold transition-colors">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
