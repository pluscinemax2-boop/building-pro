@extends('building-admin.layout')

@section('content')
<div class="min-h-screen relative pb-24 bg-background-light dark:bg-background-dark">
    <header class="sticky top-0 z-50 bg-white dark:bg-surface-dark/95 backdrop-blur-sm border-b border-border dark:border-gray-800">
        <div class="flex items-center px-4 py-3 relative">
            <a href="{{ route('building-admin.dashboard') }}" class="flex items-center justify-center h-10 w-10 rounded-full hover:bg-background-light dark:hover:bg-gray-800 transition-colors text-text-main dark:text-white mr-2 z-10">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div class="flex-1 flex justify-center absolute left-0 right-0 pointer-events-none">
                <h1 class="text-text-main dark:text-white text-xl font-bold tracking-tight text-center pointer-events-auto">Managers Directory</h1>
            </div>
        </div>
    </header>
    <main class="w-full max-w-md mx-auto flex flex-col gap-4 p-3">
           <!-- Search Bar -->
        <section class="px-4">
            <form method="GET" action="" class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </span>
                <input name="search" value="{{ request('search') }}" class="w-full py-3 pl-10 pr-4 bg-white dark:bg-slate-800 border-none rounded-xl text-sm font-medium text-slate-900 dark:text-white placeholder-slate-400 shadow-sm focus:ring-2 focus:ring-primary/50 outline-none" placeholder="Search managers..." type="text" />
            </form>
        </section>
        <!-- Filter Chips -->
        <section class="px-4 overflow-x-auto no-scrollbar">
            <div class="flex gap-2 min-w-max pb-2">
                <a href="{{ route('building-admin.manager-management.index', ['filter' => 'all']) }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ ($filter ?? 'all') === 'all' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">All</button>
                </a>
                <a href="{{ route('building-admin.manager-management.index', ['filter' => 'active']) }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ ($filter ?? '') === 'active' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Active</button>
                </a>
                <a href="{{ route('building-admin.manager-management.index', ['filter' => 'inactive']) }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ ($filter ?? '') === 'inactive' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Inactive</button>
                </a>
            </div>
        </section>
        <!-- List Header -->
        <div class="px-4 pt-2 pb-0 flex items-center justify-between">
            <h3 class="text-text-main dark:text-white font-semibold text-lg">All Managers</h3>
        </div>
        <!-- Manager List -->
        <section class="px-4 flex flex-col gap-3">
            @forelse($managers as $manager)
                <div class="bg-white dark:bg-surface-dark rounded-xl p-4 shadow-card border border-border dark:border-gray-700 flex items-center justify-between group cursor-pointer hover:border-primary/50 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="relative w-12 h-12 rounded-lg overflow-hidden shrink-0 flex flex-col items-center justify-center bg-purple-50 dark:bg-purple-900/30 border border-purple-100 dark:border-purple-800 shadow-card">
                            <span class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-2xl">admin_panel_settings</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-text-main dark:text-white font-bold text-base">{{ $manager->name }}</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide
                                    @if($manager->status !== 'inactive')
                                        bg-green-600 text-white border border-green-700
                                    @else
                                        bg-gray-400 text-white border border-gray-500
                                    @endif
                                ">
                                    {{ ucfirst($manager->status ?? 'active') }}
                                </span>
                            </div>
                            <p class="text-text-sub dark:text-gray-400 text-sm mt-0.5 line-clamp-1">
                                {{ $manager->email }} • {{ $manager->phone ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('building-admin.managers.edit', $manager) }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-primary hover:bg-primary/5 transition-colors">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                </div>
            @empty
                <p class="text-text-sub dark:text-gray-400 text-sm">No managers found.</p>
            @endforelse
        </section>
</main>
    <!-- Fixed Action Button (modern UX) -->
    <a href="{{ route('building-admin.managers.create') }}" class="fixed bottom-20 left-1/2 transform -translate-x-1/2 z-50 bg-primary text-white rounded-lg shadow-lg px-6 py-3 flex items-center gap-2 font-bold text-base hover:bg-primary/90 transition">
        <span class="material-symbols-outlined">add_circle</span>
        Create Manager
    </a>
</div>
@endsection