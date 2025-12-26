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
        </div>
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
        <form id="periodFilterForm" method="GET" action="" class="flex gap-2 items-center">
            <select id="monthSelect" name="month" class="rounded-lg border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] px-4 py-2 text-sm text-[#111418] dark:text-white">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ request('month', now()->month) == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
                @endfor
            </select>
            <select id="yearSelect" name="year" class="rounded-lg border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] px-4 py-2 text-sm text-[#111418] dark:text-white">
                @for($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="px-5 py-2.5 rounded-full bg-primary text-white text-sm font-semibold shadow-md whitespace-nowrap">Apply</button>
            <span class="ml-4 text-xs text-[#617589] font-medium uppercase tracking-wide">Selected: {{ $selectedPeriod ?? (date('F Y')) }}</span>
        </form>
        <div class="flex gap-2 mt-4 overflow-x-auto pb-2 scrollbar-hide">
            <button type="button" class="chip-filter px-5 py-2.5 rounded-full bg-primary text-white text-sm font-semibold shadow-md whitespace-nowrap" data-month="{{ now()->month }}" data-year="{{ now()->year }}">This Month</button>
            <button type="button" class="chip-filter px-5 py-2.5 rounded-full bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#617589] dark:text-gray-300 text-sm font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors" data-month="{{ now()->subMonth()->month }}" data-year="{{ now()->subMonth()->year }}">Last Month</button>
            <button type="button" class="chip-filter px-5 py-2.5 rounded-full bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#617589] dark:text-gray-300 text-sm font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors" data-quarter="last">Last Quarter</button>
            <button type="button" class="chip-filter px-5 py-2.5 rounded-full bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#617589] dark:text-gray-300 text-sm font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors" data-month="1" data-year="{{ now()->year }}">{{ now()->year }}</button>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setQuarter(monthSelect, yearSelect, which) {
                const now = new Date();
                let month = now.getMonth() + 1;
                let year = now.getFullYear();
                if (which === 'last') {
                    // Last quarter logic
                    let q = Math.floor((month - 1) / 3);
                    if (q === 0) { q = 4; year--; }
                    else { q = q; }
                    month = (q - 1) * 3 + 1;
                }
                monthSelect.value = month;
                yearSelect.value = year;
            }
            document.querySelectorAll('.chip-filter').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const monthSelect = document.getElementById('monthSelect');
                    const yearSelect = document.getElementById('yearSelect');
                    if (btn.dataset.quarter === 'last') {
                        setQuarter(monthSelect, yearSelect, 'last');
                    } else {
                        if (btn.dataset.month) monthSelect.value = btn.dataset.month;
                        if (btn.dataset.year) yearSelect.value = btn.dataset.year;
                    }
                    document.getElementById('periodFilterForm').submit();
                });
            });
        });
        </script>
    </div>
    <!-- Financial Reports List -->
    <div class="px-4 mt-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-xs font-bold text-[#617589] uppercase tracking-widest px-1">Financials</h3>
            <button class="text-primary text-xs font-semibold"
                onclick="window.location='{{ route('building-admin.reports.all-financial', ['month' => request('month', now()->month), 'year' => request('year', now()->year)]) }}'">
                See All
            </button>
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
                            <p class="text-xs text-[#617589] mt-1">
                                {{ $report->type }} • {{ $report->size }}
                                @if(!empty($report->date_range))
                                    • {{ $report->date_range }}
                                @endif
                            </p>
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
    <!-- Bottom Navigation Bar -->
    @include('building-admin.partials.bottom-nav', ['active' => 'reports'])
</div>
@endsection
