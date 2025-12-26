@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white pb-24 relative min-h-screen">
    <!-- Top App Bar & Header Info -->
    <div class="sticky top-0 z-20 bg-white dark:bg-[#111418] border-b border-[#dbe0e6] dark:border-gray-800 shadow-sm">
        <div class="flex items-center justify-between p-4 pb-2">
            <a href="{{ route('building-admin.dashboard') }}" class="text-[#111418] dark:text-white flex size-12 shrink-0 items-center cursor-pointer">
                <span class="material-symbols-outlined text-2xl">arrow_back</span>
            </a>
            <div class="flex-1 text-center">
                <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Reports</h2>
            </div>
            <div class="flex w-12 items-center justify-end">
                <button class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 bg-transparent text-[#111418] dark:text-white gap-2 text-base font-bold leading-normal tracking-[0.015em] min-w-0 p-0">
                    <span class="material-symbols-outlined text-2xl">settings</span>
                </button>
            </div>
        </div>
        <p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal pb-3 px-4 text-center -mt-1">
            {{ $buildingName ?? 'Building Name' }} • Admin Dashboard
        </p>
    </div>
    <!-- Quick Stats Section -->
    <div class="pt-5">
        <h3 class="text-[#111418] dark:text-white tracking-light text-xl font-bold leading-tight px-4 text-left pb-4">
            Overview
        </h3>
        <div class="flex gap-4 p-4 pt-0 overflow-x-auto scrollbar-hide">
            <div class="flex min-w-[200px] flex-1 flex-col gap-2 rounded-xl p-5 bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 shadow-sm">
                <div class="flex items-center gap-2 mb-1">
                    <div class="bg-primary/10 p-1.5 rounded-full text-primary">
                        <span class="material-symbols-outlined text-xl">payments</span>
                    </div>
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium leading-normal">Total Expenses</p>
                </div>
                <p class="text-[#111418] dark:text-white tracking-light text-2xl font-bold leading-tight">{{ $stats['expenses'] ?? '$0' }}</p>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[#078838] text-sm">trending_up</span>
                    <p class="text-[#078838] text-sm font-medium leading-normal">{{ $stats['expenses_change'] ?? '+0%' }} <span class="text-[#617589] font-normal">vs last month</span></p>
                </div>
            </div>
            <div class="flex min-w-[200px] flex-1 flex-col gap-2 rounded-xl p-5 bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 shadow-sm">
                <div class="flex items-center gap-2 mb-1">
                    <div class="bg-orange-100 dark:bg-orange-900/30 p-1.5 rounded-full text-orange-600 dark:text-orange-400">
                        <span class="material-symbols-outlined text-xl">report_problem</span>
                    </div>
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium leading-normal">Open Complaints</p>
                </div>
                <p class="text-[#111418] dark:text-white tracking-light text-2xl font-bold leading-tight">{{ $stats['open_complaints'] ?? '0' }}</p>
                <p class="text-[#617589] text-sm font-medium leading-normal">{{ $stats['complaints_change'] ?? '0%' }} <span class="text-[#617589] font-normal">change</span></p>
            </div>
        </div>
    </div>
    <!-- Filter Section -->
    <div class="px-4 mt-2">
        <h3 class="text-[#111418] dark:text-white tracking-light text-xl font-bold leading-tight text-left pb-3">
            Filter Period
        </h3>
        <button class="w-full flex items-center justify-between bg-white dark:bg-[#1a2632] p-4 rounded-xl border border-[#dbe0e6] dark:border-gray-700 shadow-sm active:bg-gray-50 dark:active:bg-[#202e3b] transition-colors">
            <div class="flex items-center gap-3">
                <div class="bg-primary/10 p-2 rounded-lg text-primary">
                    <span class="material-symbols-outlined">calendar_month</span>
                </div>
                <div class="flex flex-col items-start">
                    <span class="text-xs text-[#617589] font-medium uppercase tracking-wide">Selected Period</span>
                    <span class="font-bold text-[#111418] dark:text-white text-base">{{ $selectedPeriod ?? 'March 2024' }}</span>
                </div>
            </div>
            <span class="material-symbols-outlined text-[#617589]">expand_more</span>
        </button>
        <div class="flex gap-2 mt-4 overflow-x-auto pb-2 scrollbar-hide">
            <button class="px-5 py-2.5 rounded-full bg-primary text-white text-sm font-semibold shadow-md whitespace-nowrap">This Month</button>
            <button class="px-5 py-2.5 rounded-full bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#617589] dark:text-gray-300 text-sm font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">Last Month</button>
            <button class="px-5 py-2.5 rounded-full bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#617589] dark:text-gray-300 text-sm font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">Last Quarter</button>
            <button class="px-5 py-2.5 rounded-full bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#617589] dark:text-gray-300 text-sm font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">2023</button>
        </div>
    </div>
    <!-- Financial Reports List -->
    <div class="px-4 mt-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-xs font-bold text-[#617589] uppercase tracking-widest px-1">Financials</h3>
            <button class="text-primary text-xs font-semibold">See All</button>
        </div>
        <div class="flex flex-col gap-3">
            @foreach($financialReports as $report)
                <div class="flex items-center justify-between p-4 bg-white dark:bg-[#1a2632] rounded-xl border border-[#dbe0e6] dark:border-gray-700 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-primary border border-blue-100 dark:border-blue-800">
                            <span class="material-symbols-outlined">description</span>
                        </div>
                        <div>
                            <p class="text-[#111418] dark:text-white font-semibold text-sm leading-tight">{{ $report->title }}</p>
                            <p class="text-xs text-[#617589] mt-1">{{ $report->type }} • {{ $report->size }}</p>
                        </div>
                    </div>
                    <a href="{{ $report->download_url }}" class="h-10 w-10 flex items-center justify-center rounded-full bg-[#f6f7f8] dark:bg-[#253240] text-primary hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
                        <span class="material-symbols-outlined">download</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Operational Reports List -->
    <div class="px-4 mt-8 mb-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-xs font-bold text-[#617589] uppercase tracking-widest px-1">Operations</h3>
            <button class="text-primary text-xs font-semibold">See All</button>
        </div>
        <div class="flex flex-col gap-3">
            @foreach($operationalReports as $report)
                <div class="flex items-center justify-between p-4 bg-white dark:bg-[#1a2632] rounded-xl border border-[#dbe0e6] dark:border-gray-700 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl {{ $report->icon_bg }} flex items-center justify-center {{ $report->icon_color }} border {{ $report->icon_border }}">
                            <span class="material-symbols-outlined">{{ $report->icon }}</span>
                        </div>
                        <div>
                            <p class="text-[#111418] dark:text-white font-semibold text-sm leading-tight">{{ $report->title }}</p>
                            <p class="text-xs text-[#617589] mt-1">{{ $report->type }}</p>
                        </div>
                    </div>
                    @if($report->action === 'download')
                        <a href="{{ $report->download_url }}" class="h-10 w-10 flex items-center justify-center rounded-full bg-[#f6f7f8] dark:bg-[#253240] text-primary hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
                            <span class="material-symbols-outlined">download</span>
                        </a>
                    @elseif($report->action === 'view')
                        <a href="{{ $report->view_url }}" class="px-5 py-2 rounded-lg bg-[#f6f7f8] dark:bg-[#253240] text-sm font-bold text-[#111418] dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            View
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <!-- Floating Action Button -->
    <div class="fixed bottom-24 right-4 z-10">
        <a href="{{ route('building-admin.reports.create') }}" class="flex items-center justify-center w-14 h-14 bg-primary text-white rounded-full shadow-lg hover:bg-blue-600 transition-colors">
            <span class="material-symbols-outlined text-2xl">add</span>
        </a>
    </div>
    <!-- Bottom Navigation Bar -->
    @include('building-admin.partials.bottom-nav', ['active' => 'reports'])
</div>
@endsection
