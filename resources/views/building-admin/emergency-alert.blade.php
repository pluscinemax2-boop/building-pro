@extends('building-admin.layout')

@section('content')
<div class="flex flex-col h-full bg-background-light dark:bg-[#111418]">
    <!-- Header -->
    <div class="flex items-center justify-between px-4 pt-4 pb-2">
        <h1 class="text-xl font-bold text-[#111418] dark:text-white">Emergency Alerts</h1>
        <a href="#" class="rounded-full bg-primary px-4 py-2 text-white text-xs font-bold shadow hover:bg-primary-dark transition-colors">+ New Alert</a>
    </div>
    <!-- Filter Chips -->
    <div class="flex gap-2 p-4 overflow-x-auto no-scrollbar pb-2">
        @foreach(['All', 'Sent', 'Scheduled', 'Drafts'] as $status)
            <div class="flex h-8 shrink-0 cursor-pointer items-center justify-center gap-x-2 rounded-full {{ $loop->first ? 'bg-[#111418] dark:bg-white' : 'bg-background-light dark:bg-[#1a2632] border border-gray-200 dark:border-gray-700' }} pl-4 pr-4 transition-colors">
                <p class="{{ $loop->first ? 'text-white dark:text-[#111418] font-bold' : 'text-[#111418] dark:text-white font-medium' }} text-xs leading-normal">{{ $status }}</p>
            </div>
        @endforeach
    </div>
    <!-- Past Broadcasts Section -->
    <div class="flex flex-col flex-1">
        <h2 class="text-[#111418] dark:text-white tracking-tight text-lg font-bold leading-tight px-4 text-left pb-2 pt-2">Past Broadcasts</h2>
        <div class="flex flex-col gap-3 p-4 pt-2">
            @foreach($alerts as $alert)
                <div class="group flex flex-col gap-2 rounded-xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-[#1a2632] p-4 shadow-sm hover:shadow-md transition-shadow {{ $alert['status'] === 'Draft' ? 'opacity-80' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full {{ $alert['icon_bg'] }} {{ $alert['icon_text'] }}">
                                <span class="material-symbols-outlined text-[20px]">{{ $alert['icon'] }}</span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-sm font-bold text-[#111418] dark:text-white">{{ $alert['title'] }}</p>
                                <p class="text-xs text-[#617589] dark:text-gray-400">{{ $alert['date'] }}</p>
                            </div>
                        </div>
                        <div class="rounded-full {{ $alert['badge_bg'] }} {{ $alert['badge_text'] }} px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide">
                            {{ $alert['status'] }}
                        </div>
                    </div>
                    @if(!empty($alert['description']))
                        <p class="text-sm text-[#3b4a59] dark:text-gray-300 line-clamp-2 pl-[52px]">
                            {{ $alert['description'] }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="h-10"></div>
</div>
@include('building-admin.partials.bottom-nav', ['active' => 'emergency-alert'])
@endsection
