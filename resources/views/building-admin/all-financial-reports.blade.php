@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white pb-24 min-h-screen">
    <div class="sticky top-0 z-20 bg-white dark:bg-[#111418] border-b border-[#dbe0e6] dark:border-gray-800 shadow-sm">
        <div class="flex items-center justify-between p-4 pb-2">
            <a href="{{ route('building-admin.reports') }}" class="text-[#111418] dark:text-white flex size-12 shrink-0 items-center cursor-pointer">
                <span class="material-symbols-outlined text-2xl">arrow_back</span>
            </a>
            <div class="flex-1 text-center">
                <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">All Financial Reports</h2>
            </div>
            <div class="flex w-12 items-center justify-end"></div>
        </div>
    </div>
    <div class="px-4 mt-6">
        <div class="flex flex-col gap-3">
            @forelse($reports as $report)
                <div class="flex items-center justify-between p-4 bg-white dark:bg-[#1a2632] rounded-xl border border-[#dbe0e6] dark:border-gray-700 shadow-sm mb-2">
                    <div>
                        <p class="text-[#111418] dark:text-white font-semibold text-sm leading-tight mb-1">{{ $report['title'] }}</p>
                        <p class="text-xs text-[#617589] mb-2">
                            Entries: {{ $report['count'] }} • Size: {{ $report['size'] }}
                            @if(!empty($report['date_range']))
                                • {{ $report['date_range'] }}
                            @endif
                        </p>
                    </div>
                    <a href="{{ $report['download_url'] }}" class="h-10 w-10 flex items-center justify-center rounded-full bg-[#f6f7f8] dark:bg-[#253240] text-primary hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors ml-4">
                        <span class="material-symbols-outlined">download</span>
                    </a>
                </div>
            @empty
                <div class="p-6 text-center text-[#617589] dark:text-gray-400">No financial reports with data for this period.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
