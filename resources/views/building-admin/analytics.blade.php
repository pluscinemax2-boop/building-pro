@extends('layouts.app')
@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col overflow-x-hidden max-w-md mx-auto bg-background-light dark:bg-background-dark shadow-xl">
    <!-- Header -->
    <header class="flex items-center bg-surface-light dark:bg-surface-dark p-4 sticky top-0 z-10 border-b border-border-light dark:border-gray-800">
        <button class="flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 transition-colors">
            <span class="material-symbols-outlined text-text-primary-light dark:text-white" style="font-size: 24px;">arrow_back_ios_new</span>
        </button>
        <h1 class="text-text-primary-light dark:text-white text-lg font-bold leading-tight flex-1 text-center pr-10">Analytics</h1>
        <div class="absolute right-4 flex items-center">
            <button class="flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 transition-colors">
                <span class="material-symbols-outlined text-text-primary-light dark:text-white" style="font-size: 24px;">more_vert</span>
            </button>
        </div>
    </header>
    <!-- Date Filter -->
    <div class="bg-surface-light dark:bg-surface-dark px-4 py-3 border-b border-border-light dark:border-gray-800 flex justify-between items-center">
        <div class="flex gap-2 items-center">
            <button class="flex h-9 items-center justify-center gap-x-2 rounded-full bg-primary-light dark:bg-primary/20 px-4 text-primary dark:text-primary-300 hover:bg-primary/10 transition-colors border border-transparent active:scale-95">
                <span class="text-sm font-semibold">{{ $selectedMonth ?? 'September 2023' }}</span>
                <span class="material-symbols-outlined" style="font-size: 20px;">calendar_month</span>
            </button>
        </div>
        <!-- Add more filter controls as needed -->
    </div>
    <!-- Analytics Content Placeholder -->
    <div class="flex-1 p-4">
        <!-- Dynamic analytics charts, stats, and tables will go here -->
        <div class="text-center text-gray-400 py-8">Analytics data coming soon...</div>
    </div>
</div>
@endsection
