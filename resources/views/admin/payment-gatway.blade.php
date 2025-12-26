@extends('layouts.app')
@section('content')
@php
    $razorpay_status = $razorpay_status ?? false;
    $razorpay_key_id = $razorpay_key_id ?? '';
    $razorpay_key_secret = $razorpay_key_secret ?? '';
    $razorpay_mode = $razorpay_mode ?? 'test';
@endphp
<div class="relative flex h-full min-h-screen w-full flex-col max-w-md mx-auto bg-white dark:bg-[#111a22] shadow-sm">
    <form method="POST" action="{{ route('admin.payment.gateway.save') }}">
        @csrf
        <!-- Top App Bar -->
        <div class="flex items-center bg-white dark:bg-[#111a22] px-4 py-3 justify-between sticky top-0 z-10 border-b border-gray-100 dark:border-gray-800">
            <a href="{{ route('dashboard') }}" class="text-[#111418] dark:text-white flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <span class="material-symbols-outlined">arrow_back_ios_new</span>
            </a>
            <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center pr-10">Payment Gateway</h2>
        </div>
        <!-- Main Content Scrollable Area -->
        <div class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark p-4">
            <!-- Section Header -->
            <div class="mb-2">
                <h3 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] pb-1">Payment Gateway</h3>
                <p class="text-sm text-[#617589] dark:text-gray-400">Configure your payment provider settings.</p>
            </div>
            <!-- Card Container -->
            <div class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700 p-5 mt-4 space-y-6">
                <!-- Gateway Header -->
                <div class="flex items-center gap-3 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-primary">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#111418] dark:text-white text-base">Razorpay Integration</h4>
                        <p class="text-xs text-green-600 font-medium flex items-center gap-1 mt-0.5">
                            <span class="block w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            {{ $razorpay_status ? 'Active' : 'Inactive' }}
                        </p>
                    </div>
                </div>
                <!-- Field: Razorpay Key ID -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-[#111418] dark:text-gray-200 text-sm font-medium leading-normal">Razorpay Key ID</label>
                    <div class="relative flex w-full items-center rounded-lg shadow-sm">
                        <input class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#22303c] focus:border-primary h-12 placeholder:text-[#9ca3af] px-4 pr-12 text-sm font-normal leading-normal transition-all" placeholder="Enter Key ID" type="text" name="razorpay_key_id" value="{{ $razorpay_key_id ?? '' }}" />
                        <button type="button" class="absolute right-0 top-0 bottom-0 px-3 text-[#617589] dark:text-gray-400 hover:text-primary transition-colors flex items-center justify-center rounded-r-lg">
                            <span class="material-symbols-outlined text-[20px]">content_copy</span>
                        </button>
                    </div>
                    <p class="text-xs text-[#617589] dark:text-gray-500 mt-1">Found in your Razorpay Dashboard under API Keys.</p>
                </div>
                <!-- Field: Razorpay Key Secret -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-[#111418] dark:text-gray-200 text-sm font-medium leading-normal">Razorpay Key Secret</label>
                    <div class="relative flex w-full items-center rounded-lg shadow-sm">
                        <input class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#22303c] focus:border-primary h-12 placeholder:text-[#9ca3af] px-4 pr-12 text-sm font-normal leading-normal transition-all" placeholder="Enter Key Secret" type="password" name="razorpay_key_secret" value="{{ $razorpay_key_secret ?? '' }}" />
                        <button type="button" class="absolute right-0 top-0 bottom-0 px-3 text-[#617589] dark:text-gray-400 hover:text-primary transition-colors flex items-center justify-center rounded-r-lg">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                </div>
                <!-- Divider -->
                <div class="h-px bg-gray-100 dark:bg-gray-700 my-2"></div>
                <!-- Environment Mode -->
                <div class="flex flex-col gap-3">
                    <label class="text-[#111418] dark:text-gray-200 text-sm font-medium leading-normal">Environment Mode</label>
                    <div class="flex bg-gray-100 dark:bg-[#22303c] p-1 rounded-lg">
                        <label class="flex-1">
                            <input type="radio" name="razorpay_mode" value="test" class="hidden" {{ $razorpay_mode == 'test' ? 'checked' : '' }} />
                            <span class="flex py-2 px-4 rounded-md text-sm font-medium shadow-sm bg-white dark:bg-[#2c3b4a] text-primary dark:text-white transition-all border border-gray-200 dark:border-gray-600 {{ $razorpay_mode == 'test' ? 'font-bold' : '' }} cursor-pointer">Test</span>
                        </label>
                        <label class="flex-1">
                            <input type="radio" name="razorpay_mode" value="live" class="hidden" {{ $razorpay_mode == 'live' ? 'checked' : '' }} />
                            <span class="flex py-2 px-4 rounded-md text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all {{ $razorpay_mode == 'live' ? 'font-bold' : '' }} cursor-pointer">Live</span>
                        </label>
                    </div>
                    <div class="flex items-start gap-2 mt-1">
                        <span class="material-symbols-outlined text-orange-500 text-[18px] mt-0.5">warning</span>
                        <p class="text-xs text-orange-600 dark:text-orange-400 leading-tight">
                            {{ $razorpay_mode == 'test' ? 'Test mode is active. Payments will not be processed securely.' : 'Live mode is active. Payments are processed securely.' }}
                        </p>
                    </div>
                </div>
                <!-- Gateway Status Toggle -->
                <div class="flex items-center justify-between pt-2">
                    <div class="flex flex-col">
                        <span class="text-[#111418] dark:text-white text-base font-medium">Gateway Status</span>
                        <span class="text-xs text-[#617589] dark:text-gray-400">Enable or disable payments</span>
                    </div>
                    <label class="flex items-center cursor-pointer relative" for="gateway-toggle">
                        <input class="sr-only peer" id="gateway-toggle" type="checkbox" name="razorpay_status" {{ $razorpay_status ? 'checked' : '' }} />
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-600 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/20 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                    </label>
                </div>
                <!-- Additional Help/Info -->
                <div class="mt-6 flex gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-900/40">
                    <span class="material-symbols-outlined text-primary shrink-0">info</span>
                    <p class="text-sm text-[#111418] dark:text-gray-300 leading-relaxed">
                        Changes to billing configuration may take up to 5 minutes to reflect in the tenant applications. Ensure credentials are valid before switching to Live mode.
                    </p>
                </div>
                <div class="h-24"></div> <!-- Spacer for fixed button -->
            </div>
            <!-- Sticky Footer Button -->
            <div class="fixed bottom-0 left-0 right-0 max-w-md mx-auto p-4 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-t border-[#e5e7eb] dark:border-gray-800 z-20">
                <button type="submit" class="flex w-full items-center justify-center rounded-xl h-12 px-5 bg-primary hover:bg-primary/90 text-white text-base font-bold tracking-[0.015em] transition-colors shadow-lg shadow-primary/20">
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
