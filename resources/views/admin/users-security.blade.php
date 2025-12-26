@extends('layouts.app')
@section('content')
@php
    $min_length = $min_length ?? 8;
    $force_change_days = $force_change_days ?? 90;
    $max_login_attempts = $max_login_attempts ?? 5;
    $session_timeout = $session_timeout ?? 30;
    $ip_logging = $ip_logging ?? true;
@endphp
<form method="POST" action="{{ route('admin.users-security.save') }}">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
@csrf
<div class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white overflow-x-hidden min-h-screen pb-24">
    <!-- Top Navigation Bar -->
    <div class="sticky top-0 z-20 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-colors duration-300">
        <div class="flex items-center justify-between p-4 h-16 max-w-lg mx-auto">
            <div class="flex items-center w-10 h-10 justify-center">
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-10 h-10 text-slate-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                    <span class="material-symbols-outlined">arrow_back_ios_new</span>
                </a>
            </div>
            <div class="flex-1 flex items-center justify-center">
                <h1 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight text-center">Users & Security</h1>
            </div>
            <div class="w-10 h-10"></div>
        </div>
    </div>
    <!-- Main Content Container -->
    <div class="max-w-lg mx-auto w-full flex flex-col gap-6 p-4">
        <!-- Section 1: Password Policy -->
        <div class="flex flex-col gap-2">
            <h3 class="px-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Password Policy</h3>
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                <!-- Password Minimum Length (Stepper) -->
                <div class="flex items-center justify-between p-4 min-h-[64px]">
                    <div class="flex flex-col">
                        <span class="text-base font-medium text-slate-900 dark:text-white">Minimum Length</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Characters required</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="number" name="min_length" min="4" max="32" value="{{ $min_length }}" class="w-16 text-center font-semibold text-slate-900 dark:text-white bg-transparent border-none focus:ring-0" />
                    </div>
                </div>
                <!-- Force Password Change (Input) -->
                <div class="flex flex-col p-4 gap-2">
                    <label class="text-base font-medium text-slate-900 dark:text-white">Force Password Change</label>
                    <div class="relative">
                        <input class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg py-3 px-4 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400" placeholder="90" type="number" name="force_change_days" value="{{ $force_change_days }}" />
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-500 dark:text-slate-400 pointer-events-none">Days</span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 pt-1">Users will be prompted to reset their password after this period.</p>
                </div>
            </div>
        </div>
        <!-- Section 2: Access Control -->
        <div class="flex flex-col gap-2">
            <h3 class="px-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Access Control</h3>
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                <!-- Max Login Attempts (Stepper) -->
                <div class="flex items-center justify-between p-4 min-h-[64px]">
                    <div class="flex flex-col">
                        <span class="text-base font-medium text-slate-900 dark:text-white">Max Login Attempts</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Before account lockout</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="number" name="max_login_attempts" min="1" max="20" value="{{ $max_login_attempts }}" class="w-16 text-center font-semibold text-slate-900 dark:text-white bg-transparent border-none focus:ring-0" />
                    </div>
                </div>
                <!-- Session Timeout (Input) -->
                <div class="flex flex-col p-4 gap-2">
                    <label class="text-base font-medium text-slate-900 dark:text-white">Session Timeout</label>
                    <div class="relative">
                        <input class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg py-3 px-4 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400" placeholder="30" type="number" name="session_timeout" value="{{ $session_timeout }}" />
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-500 dark:text-slate-400 pointer-events-none">Minutes</span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 pt-1">Automatic logout after inactivity.</p>
                </div>
            </div>
        </div>
        <!-- Section 3: Audit & Logs -->
        <div class="flex flex-col gap-2">
            <h3 class="px-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Audit & Logs</h3>
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <!-- IP Logging (Toggle) -->
                <div class="flex items-center justify-between p-4 min-h-[64px]">
                    <div class="flex flex-col flex-1 pr-4">
                        <span class="text-base font-medium text-slate-900 dark:text-white">IP Address Logging</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400 mt-1">Record user IP addresses for security audits and login history.</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input class="sr-only peer" type="checkbox" name="ip_logging" value="1" {{ $ip_logging ? 'checked' : '' }} />
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Sticky Action Button -->
    <div class="fixed bottom-0 left-0 right-0 p-4 bg-white/90 dark:bg-background-dark/90 backdrop-blur border-t border-slate-200 dark:border-slate-800 z-20 flex justify-center">
        <div class="max-w-lg w-full">
                <button type="submit" class="w-full bg-primary hover:bg-blue-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-primary/30 transition-all active:scale-[0.98]">
                    Save Changes
                </button>
        </div>
    </div>
</div>
</form>
@endsection
