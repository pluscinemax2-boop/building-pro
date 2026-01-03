@extends('manager.layout')

@section('title', 'Emergency Alerts - Manager')

@section('content')
<div class="p-4">
    <h3 class="text-lg font-bold mb-4">Emergency Alerts</h3>
    
    <div class="flex flex-col gap-3">
        @forelse($alerts as $a)
        <div class="flex items-center justify-between gap-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/50 p-3 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center rounded-lg bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400 size-10">
                    <span class="material-symbols-outlined">warning</span>
                </div>
                <div class="flex flex-col justify-center">
                    <p class="text-[#111418] dark:text-white text-sm font-semibold leading-normal line-clamp-1">{{ $a->title }}</p>
                    <p class="text-[#617589] dark:text-gray-400 text-xs font-normal leading-normal">{{ $a->type }} • {{ $a->created_at->format('d M Y') }}</p>
                </div>
            </div>
            <div class="shrink-0 flex items-center gap-2">
                <span class="px-2 py-1 rounded text-[10px] font-bold bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">{{ $a->priority ?? 'HIGH' }}</span>
                <span class="material-symbols-outlined text-gray-400 text-xl">chevron_right</span>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <span class="material-symbols-outlined text-4xl mb-2">notifications_off</span>
            <p>No emergency alerts</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
