@extends('building-admin.layout')

@section('content')
    <!-- Top App Bar -->
    <header class="sticky top-0 z-50 bg-white dark:bg-surface-dark/95 backdrop-blur-sm border-b border-border dark:border-gray-800">
        <div class="flex items-center px-4 py-3 relative">
            <!-- Back Button -->
            <a href="{{ route('building-admin.dashboard') }}" class="flex items-center justify-center h-10 w-10 rounded-full hover:bg-background-light dark:hover:bg-gray-800 transition-colors text-text-main dark:text-white mr-2 z-10">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div class="flex-1 flex justify-center absolute left-0 right-0 pointer-events-none">
                <h1 class="text-text-main dark:text-white text-xl font-bold tracking-tight text-center pointer-events-auto">Flats Management</h1>
            </div>

        </div>
    </header>
    <!-- Main Content -->
    </main>

    <main class="w-full max-w-md mx-auto flex flex-col gap-4">
        <!-- Stats Section -->
        <section class="px-4 py-4">
            <div class="grid grid-cols-3 gap-3">
                <div class="flex flex-col items-start justify-center p-3 bg-white dark:bg-surface-dark rounded-xl shadow-card border border-border dark:border-gray-700">
                    <p class="text-text-sub dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Total</p>
                    <p class="text-text-main dark:text-white text-2xl font-bold mt-1">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="flex flex-col items-start justify-center p-3 bg-white dark:bg-surface-dark rounded-xl shadow-card border border-border dark:border-gray-700">
                    <div class="flex items-center gap-1.5 mb-1">
                        <span class="w-2 h-2 rounded-full bg-success"></span>
                        <p class="text-text-sub dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Occupied</p>
                    </div>
                    <p class="text-text-main dark:text-white text-2xl font-bold">{{ $stats['occupied'] ?? 0 }}</p>
                </div>
                <div class="flex flex-col items-start justify-center p-3 bg-white dark:bg-surface-dark rounded-xl shadow-card border border-border dark:border-gray-700">
                    <div class="flex items-center gap-1.5 mb-1">
                        <span class="w-2 h-2 rounded-full bg-warning"></span>
                        <p class="text-text-sub dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Vacant</p>
                    </div>
                    <p class="text-text-main dark:text-white text-2xl font-bold">{{ $stats['vacant'] ?? 0 }}</p>
                </div>
            </div>
        </section>
            <!-- Search Bar -->
        <section class="px-4">
            <form method="GET" action="" class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </span>
                <input name="search" value="{{ request('search') }}" class="w-full py-3 pl-10 pr-4 bg-white dark:bg-slate-800 border-none rounded-xl text-sm font-medium text-slate-900 dark:text-white placeholder-slate-400 shadow-sm focus:ring-2 focus:ring-primary/50 outline-none" placeholder="Search files..." type="text" />
            </form>
        </section>
        <!-- Filter Chips -->
        <section class="px-4 overflow-x-auto no-scrollbar">
            <div class="flex gap-2 min-w-max pb-2">
                <a href="{{ route('building-admin.flat-management.index', ['filter' => 'all']) }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ ($filter ?? 'all') === 'all' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">All</button>
                </a>
                <a href="{{ route('building-admin.flat-management.index', ['filter' => 'occupied']) }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ ($filter ?? '') === 'occupied' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Occupied</button>
                </a>
                <a href="{{ route('building-admin.flat-management.index', ['filter' => 'vacant']) }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ ($filter ?? '') === 'vacant' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Vacant</button>
                </a>
                <a href="{{ route('building-admin.flat-management.index', ['filter' => 'maintenance']) }}">
                    <button class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ ($filter ?? '') === 'maintenance' ? 'bg-black text-white' : 'bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Maintenance</button>
                </a>
            </div>
        </section>
        <!-- List Header -->
        <div class="px-4 pt-2 pb-0 flex items-center justify-between">
            <h3 class="text-text-main dark:text-white font-semibold text-lg">All Units</h3>
        </div>
        <!-- Flat List -->
        <section class="px-4 flex flex-col gap-3">
            @forelse($flats as $flat)
                <div class="bg-white dark:bg-surface-dark rounded-xl p-4 shadow-card border border-border dark:border-gray-700 flex items-center justify-between group cursor-pointer hover:border-primary/50 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="relative w-12 h-12 rounded-lg overflow-hidden shrink-0 flex flex-col items-center justify-center bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 shadow-card">
                            <!-- Home Icon -->
                            <span class="material-symbols-outlined text-primary text-2xl">home</span>
                            <!-- Status Dot -->
                            <span class="absolute top-1 right-1 w-2 h-2 rounded-full border-2 border-white dark:border-surface-dark"
                                style="background-color:
                                    @if($flat->status === 'occupied') #22c55e
                                    @elseif($flat->status === 'vacant') #64748b
                                    @elseif($flat->status === 'maintenance') #eab308
                                    @else #d1d5db
                                    @endif;"></span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-text-main dark:text-white font-bold text-base">Flat {{ $flat->block }}-{{ $flat->flat_number ?? $flat->number }}</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide
                                    @if($flat->status === 'occupied')
                                        bg-green-600 text-white border border-green-700
                                    @elseif($flat->status === 'vacant')
                                        bg-gray-400 text-white border border-gray-500
                                    @elseif($flat->status === 'maintenance')
                                        bg-yellow-500 text-white border border-yellow-600
                                    @else
                                        bg-gray-200 text-gray-700 border border-gray-300
                                    @endif
                                ">
                                    {{ ucfirst($flat->status) }}
                                </span>
                            </div>
                            <p class="text-text-sub dark:text-gray-400 text-sm mt-0.5 line-clamp-1">
                                {{ $flat->floor }} Floor •
                                @if($flat->resident && $flat->resident->name)
                                    {{ $flat->resident->name }}
                                @else
                                    No Resident
                                @endif
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('building-admin.flat-management.show', $flat) }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-primary hover:bg-primary/5 transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                </div>
            @empty
                <p class="text-text-sub dark:text-gray-400 text-sm">No flats found.</p>
            @endforelse
        </section>
    </main>
    <!-- Fixed Action Button (modern UX) -->
    <a href="http://127.0.0.1:8000/building-admin/flats/create" class="fixed bottom-20 left-1/2 transform -translate-x-1/2 z-50 bg-primary text-white rounded-lg shadow-lg px-6 py-3 flex items-center gap-2 font-bold text-base hover:bg-primary/90 transition">
        <span class="material-symbols-outlined">add_circle</span>
        Create Flat
    </a>
    <!-- Bottom Navigation removed -->
</div>
@endsection
