@extends('building-admin.layout')

@section('content')
<div class="min-h-screen relative pb-24 bg-background-light dark:bg-background-dark">
    <header class="sticky top-0 z-50 bg-white dark:bg-surface-dark/95 backdrop-blur-sm border-b border-border dark:border-gray-800">
        <div class="flex items-center px-4 py-3 relative">
            <a href="{{ route('building-admin.dashboard') }}" class="flex items-center justify-center h-10 w-10 rounded-full hover:bg-background-light dark:hover:bg-gray-800 transition-colors text-text-main dark:text-white mr-2 z-10">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div class="flex-1 flex justify-center absolute left-0 right-0 pointer-events-none">
                <h1 class="text-text-main dark:text-white text-xl font-bold tracking-tight text-center pointer-events-auto">Activity Log</h1>
            </div>
        </div>
    </header>
    <main class="w-full max-w-md mx-auto flex flex-col gap-4 p-3">
           <!-- Search Bar -->
        <section class="px-4">
            <form method="GET" action="{{ route('building-admin.activity-log.index') }}" class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </span>
                <input name="search" value="{{ request('search') }}" class="w-full py-3 pl-10 pr-4 bg-white dark:bg-slate-800 border-none rounded-xl text-sm font-medium text-slate-900 dark:text-white placeholder-slate-400 shadow-sm focus:ring-2 focus:ring-primary/50 outline-none" placeholder="Search activities..." type="text" />
            </form>
        </section>
        <!-- Filter Chips -->
        <section class="px-4 overflow-x-auto" style="-ms-overflow-style: none; scrollbar-width: none;">
            <div class="flex gap-2 pb-2" style="-ms-overflow-style: none; scrollbar-width: none;">
                <style>
                    .overflow-x-auto::-webkit-scrollbar {
                        display: none;
                    }
                </style>
                <a href="{{ route('building-admin.recent-activities') }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ !request('filter') || request('filter') === 'all' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">All</button>
                </a>
                <a href="{{ route('building-admin.recent-activities', ['filter' => 'expenses']) }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ request('filter') === 'expenses' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Expenses</button>
                </a>
                <a href="{{ route('building-admin.recent-activities', ['filter' => 'complaints']) }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ request('filter') === 'complaints' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Complaints</button>
                </a>
                <a href="{{ route('building-admin.recent-activities', ['filter' => 'documents']) }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ request('filter') === 'documents' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Documents</button>
                </a>
                <a href="{{ route('building-admin.recent-activities', ['filter' => 'notices']) }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ request('filter') === 'notices' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Notices</button>
                </a>
            </div>
        </section>
        <!-- List Header -->
        <div class="px-4 pt-2 pb-0 flex items-center justify-between">
            <h3 class="text-text-main dark:text-white font-semibold text-lg">Recent Activities</h3>
        </div>
        <!-- Activity Log List -->
        <section class="px-4 flex flex-col gap-3">
            @forelse($logs as $log)
                <div class="bg-white dark:bg-surface-dark rounded-xl p-4 shadow-card border border-border dark:border-gray-700">
                    <div class="flex items-start gap-3">
                        <div class="relative w-10 h-10 rounded-lg overflow-hidden shrink-0 flex flex-col items-center justify-center bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 shadow-card">
                            <span class="material-symbols-outlined text-primary text-xl">
                                @switch(true)
                                    @case(str_contains(strtolower($log->action), 'expense'))
                                        payments
                                        @break
                                    @case(str_contains(strtolower($log->action), 'complaint'))
                                        report
                                        @break
                                    @case(str_contains(strtolower($log->action), 'document'))
                                        folder
                                        @break
                                    @case(str_contains(strtolower($log->action), 'notice'))
                                        campaign
                                        @break
                                    @default
                                        history
                                @endswitch
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="text-text-main dark:text-white font-bold text-base">{{ $log->user->name ?? 'System' }}</h4>
                                    <p class="text-text-sub dark:text-gray-400 text-sm mt-0.5">{{ $log->action }}</p>
                                    @if($log->description)
                                        <p class="text-text-sub dark:text-gray-500 text-sm mt-1">{{ $log->description }}</p>
                                    @endif
                                </div>
                                <span class="text-xs text-text-sub dark:text-gray-500 whitespace-nowrap">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-text-sub dark:text-gray-400 text-sm">No activities found.</p>
            @endforelse
        </section>
        
        <!-- Pagination -->
        @if($logs->hasPages())
        <div class="px-4 py-4 flex justify-center">
            <div class="flex items-center gap-2">
                @if($logs->onFirstPage())
                    <span class="px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-400 text-sm font-medium cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-2 rounded-lg bg-primary text-white text-sm font-medium hover:bg-primary/90 transition">Previous</a>
                @endif
                
                <span class="px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-text-main dark:text-white text-sm font-medium">
                    {{ $logs->currentPage() }} of {{ $logs->lastPage() }}
                </span>
                
                @if($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-2 rounded-lg bg-primary text-white text-sm font-medium hover:bg-primary/90 transition">Next</a>
                @else
                    <span class="px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-400 text-sm font-medium cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
        @endif
    </main>
</div>
@endsection