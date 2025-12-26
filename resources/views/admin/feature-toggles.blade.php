@extends('layouts.app')
@section('content')
@php
    // Example dynamic data, replace with real data from controller
    // $features is now passed from controller/route and contains key, icon, title, desc, enabled
@endphp
<div class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white min-h-screen flex flex-col overflow-x-hidden">
    <form method="POST" action="{{ route('admin.feature.toggles.save') }}">
        @csrf
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <!-- Top App Bar -->
        <div class="sticky top-0 z-10 bg-white dark:bg-[#1a2632] border-b border-[#e5e7eb] dark:border-[#2a3a4a]">
            <div class="flex items-center p-4 pb-3">
                <div class="w-10 h-10 flex items-center justify-center">
                    <a href="{{ route('dashboard') }}" class="flex size-10 items-center justify-center cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full text-[#111418] dark:text-white">
                        <span class="material-symbols-outlined">arrow_back_ios_new</span>
                    </a>
                </div>
                <div class="flex-1 flex items-center justify-center">
                    <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] text-center">Feature Toggles</h2>
                </div>
                <div class="w-10 h-10"></div>
            </div>
        </div>
    <!-- Main Content Area -->
    <div class="flex flex-col gap-4 pb-8 max-w-2xl mx-auto w-full">
        <!-- Global Configuration Banner -->
        <div class="px-4">
            <div class="flex flex-col items-start justify-between gap-4 rounded-xl border border-[#dbe0e6] dark:border-[#2a3a4a] bg-white dark:bg-[#1a2632] p-5 shadow-sm">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2 text-[#111418] dark:text-white mb-1">
                        <span class="material-symbols-outlined text-primary" style="font-size: 20px;">info</span>
                        <p class="text-base font-bold leading-tight">Global Configuration</p>
                    </div>
                    <p class="text-[#617589] dark:text-[#9aaab9] text-sm font-normal leading-normal">
                        Disabling a module here hides it for all society residents. Changes apply immediately to the tenant app.
                    </p>
                </div>
            </div>
        </div>
        <!-- Section: Features -->
        <div>
            <h3 class="text-[#617589] dark:text-[#9aaab9] text-sm font-bold uppercase tracking-wider px-6 pb-2 pt-2">Features</h3>
            <div class="bg-white dark:bg-[#1a2632] rounded-xl overflow-hidden shadow-sm mx-4 border border-[#e5e7eb] dark:border-[#2a3a4a]">
                @foreach($features as $feature)
                <div class="flex items-center gap-4 px-4 py-3 justify-between border-b border-[#f0f2f4] dark:border-[#2a3a4a] last:border-0">
                    <div class="flex items-center gap-4">
                        <div class="text-[#111418] dark:text-white flex items-center justify-center rounded-lg bg-[#eff6ff] dark:bg-blue-900/30 shrink-0 size-10">
                            <span class="material-symbols-outlined text-primary">{{ $feature['icon'] }}</span>
                        </div>
                        <div class="flex flex-col justify-center">
                            <p class="text-[#111418] dark:text-white text-base font-medium leading-normal line-clamp-1">{{ $feature['title'] }}</p>
                            <p class="text-[#617589] dark:text-[#9aaab9] text-xs font-normal leading-normal line-clamp-2">{{ $feature['desc'] }}</p>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <label class="relative flex h-[31px] w-[51px] cursor-pointer items-center rounded-full border-none bg-[#e5e7eb] dark:bg-[#374151] p-0.5 has-[:checked]:bg-primary transition-colors duration-200">
                            <input class="peer absolute opacity-0 w-full h-full cursor-pointer" type="checkbox" name="{{ $feature['key'] }}" value="1" {{ $feature['enabled'] ? 'checked' : '' }} />
                            <div class="h-[27px] w-[27px] rounded-full bg-white shadow-sm transition-transform duration-200 peer-checked:translate-x-[20px]"></div>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Fixed Footer -->
        <div class="fixed bottom-0 left-0 z-30 w-full border-t border-[#e5e7eb] bg-white px-4 py-4 dark:border-[#2a3a4a] dark:bg-[#1a2632]">
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
