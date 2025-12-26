@extends('layouts.app')
@section('content')
<div class="relative flex flex-col min-h-screen w-full p-4">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-[#111418] dark:text-white">All Recent Activity</h2>
        <a href="{{ route('building-admin.dashboard') }}" class="text-primary text-sm font-semibold hover:opacity-80">Back to Dashboard</a>
    </div>
    <div class="rounded-xl bg-white dark:bg-[#1e2732] border border-[#e5e7eb] dark:border-gray-800 divide-y divide-[#f0f2f4] dark:divide-gray-800 overflow-hidden shadow-sm">
        @forelse($recentActivity as $activity)
        <div class="flex gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors cursor-pointer">
            <div class="flex-none pt-0.5">
                <div class="{{ $activity['iconBg'] }} rounded-full p-2.5 {{ $activity['iconText'] }}">
                    <span class="material-symbols-outlined text-[20px] block">{{ $activity['icon'] }}</span>
                </div>
            </div>
            <div class="flex flex-col flex-1 gap-1">
                <div class="flex justify-between items-start">
                    <p class="text-[#111418] dark:text-white text-sm font-bold">{{ $activity['title'] }}</p>
                    <span class="text-[#617589] dark:text-gray-500 text-[10px] font-medium whitespace-nowrap mt-0.5">{{ $activity['time'] }}</span>
                </div>
                <p class="text-[#617589] dark:text-gray-400 text-xs leading-relaxed">{!! $activity['desc'] !!}</p>
            </div>
        </div>
        @empty
        <div class="p-4 text-center text-gray-400">No recent activity</div>
        @endforelse
    </div>
</div>
@endsection
