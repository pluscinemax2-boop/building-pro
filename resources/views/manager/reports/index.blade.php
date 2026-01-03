@extends('manager.layout')

@section('title', 'Reports - Manager')

@section('content')
<div class="p-4">
    <h3 class="text-lg font-bold mb-4">Reports</h3>
    
    <div class="grid grid-cols-2 gap-3 mb-4">
        <div class="flex flex-col gap-3 rounded-xl p-4 bg-white dark:bg-gray-800 shadow-[0_2px_8px_rgba(0,0,0,0.04)] dark:shadow-none border border-transparent dark:border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900 text-primary p-2">
                    <span class="material-symbols-outlined">analytics</span>
                </div>
            </div>
            <div>
                <p class="text-[#111418] dark:text-white text-3xl font-bold leading-tight">{{ $reports->count() > 0 ? $reports->count() : count($reports) }}</p>
                <p class="text-[#617589] dark:text-gray-400 text-sm font-medium mt-1">Total Reports</p>
            </div>
        </div>
        <div class="flex flex-col gap-3 rounded-xl p-4 bg-white dark:bg-gray-800 shadow-[0_2px_8px_rgba(0,0,0,0.04)] dark:shadow-none border border-transparent dark:border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-center rounded-lg bg-green-50 dark:bg-green-900 text-green-600 dark:text-green-400 p-2">
                    <span class="material-symbols-outlined">schedule</span>
                </div>
            </div>
            <div>
                <p class="text-[#111418] dark:text-white text-3xl font-bold leading-tight">{{ $reports->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                <p class="text-[#617589] dark:text-gray-400 text-sm font-medium mt-1">This Month</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-3">
        @forelse($reports as $report)
        <div class="flex items-center justify-between gap-4 rounded-xl bg-white dark:bg-gray-800 p-3 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 size-10">
                    <span class="material-symbols-outlined">description</span>
                </div>
                <div class="flex flex-col justify-center">
                    <p class="text-[#111418] dark:text-white text-sm font-semibold leading-normal line-clamp-1">{{ $report['title'] ?? 'Report Title' }}</p>
                    <p class="text-[#617589] dark:text-gray-400 text-xs font-normal leading-normal">{{ $report['date'] ?? 'Dec 2023' }} • {{ $report['type'] ?? 'PDF' }}</p>
                </div>
            </div>
            <div class="shrink-0 flex items-center gap-2">
                <span class="material-symbols-outlined text-gray-400 text-xl">download</span>
                <span class="material-symbols-outlined text-gray-400 text-xl">more_vert</span>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <span class="material-symbols-outlined text-4xl mb-2">inbox</span>
            <p>No reports available</p>
        </div>
        @endforelse
    </div>
</div>
@endsection