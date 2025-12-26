@extends('layouts.app')
@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col max-w-md mx-auto bg-background-light dark:bg-background-dark pb-24">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-5 py-3 flex items-center justify-between">
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Voting & Polls</h1>
        <button class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-full hover:bg-blue-600 active:scale-95 transition-all shadow-md shadow-primary/20">
            <span class="material-symbols-outlined text-[20px] font-bold">add</span>
            <span class="text-sm font-bold">New Poll</span>
        </button>
    </header>
    <!-- Segmented Control Tabs -->
    <nav class="px-5 py-4">
        <div class="flex p-1 bg-slate-200/60 dark:bg-surface-dark border border-slate-200 dark:border-slate-700 rounded-xl">
            <button class="flex-1 py-2 px-3 rounded-lg bg-surface-light dark:bg-slate-700 text-primary dark:text-white shadow-sm text-sm font-bold transition-all text-center">Active ({{ $activeCount ?? 0 }})</button>
            <button class="flex-1 py-2 px-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 text-sm font-medium transition-all text-center">Scheduled</button>
            <button class="flex-1 py-2 px-3 rounded-lg text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 text-sm font-medium transition-all text-center">Past</button>
        </div>
    </nav>
    <!-- Quick Stats Summary -->
    <section class="px-5 mb-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-slate-800 flex flex-col gap-2">
                <span class="text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider">Avg. Turnout</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">{{ $avgTurnout ?? '0%' }}</span>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-100 dark:bg-emerald-900/40 dark:text-emerald-400 px-1.5 py-0.5 rounded-md flex items-center">
                        <span class="material-symbols-outlined text-[12px] mr-0.5">trending_up</span> {{ $turnoutChange ?? '0%' }}
                    </span>
                </div>
            </div>
            <!-- Add more stat cards as needed -->
        </div>
    </section>
    <!-- Polls List (Dynamic) -->
    <section class="px-5">
        @foreach($polls as $poll)
        <div class="bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 p-4 mb-4">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">{{ $poll->title }}</h2>
                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-primary/10 text-primary">{{ ucfirst($poll->status) }}</span>
            </div>
            <p class="text-slate-700 dark:text-gray-300 text-sm mb-2">{{ $poll->description }}</p>
            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-gray-400">
                <span>Start: {{ $poll->start_date->format('d M Y') }}</span>
                <span>End: {{ $poll->end_date->format('d M Y') }}</span>
            </div>
        </div>
        @endforeach
        @if($polls->isEmpty())
        <div class="text-center text-gray-400 py-8">No polls found.</div>
        @endif
    </section>
</div>
@endsection
