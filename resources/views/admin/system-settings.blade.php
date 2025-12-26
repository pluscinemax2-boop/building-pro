@extends('layouts.app')
@section('content')
@php
    // Example dynamic data, replace with real data from controller
    $app_name = $app_name ?? config('app.name', 'SocietyConnect');
    $app_url = $app_url ?? config('app.url', 'https://app.societyconnect.com');
    $support_email = $support_email ?? 'support@societyconnect.com';
    $timezone = $timezone ?? 'Asia/Kolkata';
    $currency = $currency ?? 'INR';
    $date_format = $date_format ?? 'DD/MM/YYYY';
    $billing_cycle = $billing_cycle ?? 'Yearly';
    $grace_period = $grace_period ?? 7;
    $tax_percent = $tax_percent ?? 18;
    $invoice_prefix = $invoice_prefix ?? 'INV-';
    $auto_disable = $auto_disable ?? true;
@endphp
<div class="relative flex h-full min-h-screen w-full flex-col overflow-x-hidden pb-24">
    <form method="POST" action="{{ route('admin.system-settings.save') }}">
        @csrf
        <!-- Top App Bar -->
        <header class="sticky top-0 z-20 flex items-center justify-between bg-white dark:bg-[#1E293B] px-4 py-3 shadow-sm transition-colors">
            <a href="{{ route('dashboard') }}" class="group flex size-10 shrink-0 items-center justify-center rounded-full active:bg-slate-100 dark:active:bg-slate-800">
                <span class="material-symbols-outlined text-slate-900 dark:text-white" style="font-size: 24px;">arrow_back_ios_new</span>
            </a>
            <h1 class="text-lg font-bold leading-tight tracking-tight text-slate-900 dark:text-white text-center">General Settings</h1>
            <div class="size-10"></div>
        </header>
        <main class="flex flex-col gap-6 px-4">
            <!-- Application Settings -->
            <section class="flex flex-col gap-4 rounded-xl bg-white dark:bg-[#1E293B] p-5 shadow-[0_1px_3px_rgba(0,0,0,0.05)]">
                <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="flex size-8 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/20 text-primary">
                        <span class="material-symbols-outlined" style="font-size: 20px;">settings_applications</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Application Settings</h3>
                </div>
                <div class="grid gap-5 pt-1">
                    <!-- App Name -->
                    <label class="flex flex-col gap-1.5">
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Application Name</span>
                        <input name="app_name" class="form-input h-12 w-full rounded-lg border-slate-200 bg-white px-4 text-base text-slate-900 placeholder-slate-400 focus:border-primary focus:ring-1 focus:ring-primary dark:border-slate-700 dark:bg-slate-800 dark:text-white" placeholder="Enter app name" type="text" value="{{ $app_name }}" readonly/>
                    </label>
                    <!-- App URL -->
                    <label class="flex flex-col gap-1.5">
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Application URL</span>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined" style="font-size: 20px;">link</span>
                            <input name="app_url" class="form-input h-12 w-full rounded-lg border-slate-200 bg-white pl-11 pr-4 text-base text-slate-900 placeholder-slate-400 focus:border-primary focus:ring-1 focus:ring-primary dark:border-slate-700 dark:bg-slate-800 dark:text-white" placeholder="https://" type="url" value="{{ $app_url }}" />
                        </div>
                    </label>
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <!-- Support Email -->
                        <label class="flex flex-col gap-1.5">
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Support Email</span>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined" style="font-size: 20px;">mail</span>
                                <input name="support_email" class="form-input h-12 w-full rounded-lg border-slate-200 bg-white pl-11 pr-4 text-base text-slate-900 placeholder-slate-400 focus:border-primary focus:ring-1 focus:ring-primary dark:border-slate-700 dark:bg-slate-800 dark:text-white" placeholder="email@example.com" type="email" value="{{ $support_email }}" />
                            </div>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <!-- Timezone -->
                        <label class="flex flex-col gap-1.5">
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Default Timezone</span>
                            <div class="relative">
                                <select name="timezone" class="form-select h-12 w-full appearance-none rounded-lg border-slate-200 bg-white px-4 pr-10 text-base text-slate-900 focus:border-primary focus:ring-1 focus:ring-primary dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                    <option value="Asia/Kolkata" {{ $timezone == 'Asia/Kolkata' ? 'selected' : '' }}>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                    <option value="Europe/London" {{ $timezone == 'Europe/London' ? 'selected' : '' }}>(GMT+00:00) London</option>
                                    <option value="America/New_York" {{ $timezone == 'America/New_York' ? 'selected' : '' }}>(GMT-05:00) Eastern Time (US & Canada)</option>
                                </select>
                            </div>
                        </label>
                        <!-- Currency -->
                        <label class="flex flex-col gap-1.5">
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Currency</span>
                            <div class="relative">
                                <select name="currency" class="form-select h-12 w-full appearance-none rounded-lg border-slate-200 bg-white px-4 pr-10 text-base text-slate-900 focus:border-primary focus:ring-1 focus:ring-primary dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                    <option value="INR" {{ $currency == 'INR' ? 'selected' : '' }}>INR (₹) - Indian Rupee</option>
                                    <option value="USD" {{ $currency == 'USD' ? 'selected' : '' }}>USD ($) - US Dollar</option>
                                    <option value="EUR" {{ $currency == 'EUR' ? 'selected' : '' }}>EUR (€) - Euro</option>
                                </select>
                            </div>
                        </label>
                    </div>
                    <!-- Date Format -->
                    <label class="flex flex-col gap-1.5">
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Date Format</span>
                        <div class="relative">
                            <select name="date_format" class="form-select h-12 w-full appearance-none rounded-lg border-slate-200 bg-white px-4 pr-10 text-base text-slate-900 focus:border-primary focus:ring-1 focus:ring-primary dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                <option value="DD/MM/YYYY" {{ $date_format == 'DD/MM/YYYY' ? 'selected' : '' }}>DD/MM/YYYY (e.g. 24/10/2023)</option>
                                <option value="MM/DD/YYYY" {{ $date_format == 'MM/DD/YYYY' ? 'selected' : '' }}>MM/DD/YYYY (e.g. 10/24/2023)</option>
                                <option value="YYYY-MM-DD" {{ $date_format == 'YYYY-MM-DD' ? 'selected' : '' }}>YYYY-MM-DD (e.g. 2023-10-24)</option>
                            </select>
                        </div>
                    </label>
                </div>
            </section>
            <!-- Billing Settings -->
            <section class="flex flex-col gap-4 rounded-xl bg-white dark:bg-[#1E293B] p-5 shadow-[0_1px_3px_rgba(0,0,0,0.05)]">
                <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="flex size-8 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/20 text-primary">
                        <span class="material-symbols-outlined" style="font-size: 20px;">payments</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Subscription & Billing</h3>
                </div>
                <div class="grid gap-5 pt-1">
                    <!-- Billing Cycle -->
                    <label class="flex flex-col gap-1.5">
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Default Billing Cycle</span>
                        <select name="billing_cycle" class="form-select h-12 w-full appearance-none rounded-lg border-slate-200 bg-white px-4 pr-10 text-base text-slate-900 focus:border-primary focus:ring-1 focus:ring-primary dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                            <option value="Monthly" {{ $billing_cycle == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="Quarterly" {{ $billing_cycle == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                            <option value="Yearly" {{ $billing_cycle == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Grace Period -->
                        <label class="flex flex-col gap-1.5">
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Grace Period</span>
                            <div class="relative">
                                <input name="grace_period" class="form-input h-12 w-full rounded-lg border-slate-200 bg-white px-4 pr-12 text-base text-slate-900 placeholder-slate-400 focus:border-primary focus:ring-1 focus:ring-primary dark:border-slate-700 dark:bg-slate-800 dark:text-white" type="number" value="{{ $grace_period }}" />
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-400">Days</span>
                            </div>
                        </label>
                        <!-- Tax % -->
                        <label class="flex flex-col gap-1.5">
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tax (GST)</span>
                            <div class="relative">
                                <input name="tax_percent" class="form-input h-12 w-full rounded-lg border-slate-200 bg-white px-4 pr-10 text-base text-slate-900 placeholder-slate-400 focus:border-primary focus:ring-1 focus:ring-primary dark:border-slate-700 dark:bg-slate-800 dark:text-white" type="number" value="{{ $tax_percent }}" />
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-400">%</span>
                            </div>
                        </label>
                    </div>
                    <!-- Invoice Prefix -->
                    <label class="flex flex-col gap-1.5">
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Invoice Prefix</span>
                        <input name="invoice_prefix" class="form-input h-12 w-full rounded-lg border-slate-200 bg-white px-4 text-base text-slate-900 placeholder-slate-400 focus:border-primary focus:ring-1 focus:ring-primary dark:border-slate-700 dark:bg-slate-800 dark:text-white uppercase" type="text" value="{{ $invoice_prefix }}" />
                    </label>
                    <!-- Auto-disable Toggle -->
                    <div class="flex items-center justify-between gap-4 rounded-lg border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/50">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-slate-900 dark:text-white">Auto-disable on Expiry</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">Deactivate building access after grace period.</span>
                        </div>
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input name="auto_disable" class="peer sr-only" type="checkbox" value="1" {{ $auto_disable ? 'checked' : '' }} />
                            <div class="peer h-6 w-11 rounded-full bg-slate-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/20 dark:bg-slate-700 dark:border-gray-600"></div>
                        </label>
                    </div>
                </div>
            </section>
        </main>
        <!-- Fixed Footer -->
        <div class="fixed bottom-0 left-0 z-30 w-full border-t border-slate-200 bg-white px-4 py-4 dark:border-slate-800 dark:bg-[#1E293B]">
            <div class="mx-auto w-full max-w-md">
                <button type="submit" class="flex h-12 w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 text-base font-semibold text-white shadow-md shadow-blue-500/20 transition-all hover:bg-blue-600 active:scale-[0.98]">
                    <span class="material-symbols-outlined" style="font-size: 20px;">check</span>
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
