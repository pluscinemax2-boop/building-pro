
@extends('building-admin.layout')

@section('content')
<div class="min-h-screen relative pb-24 bg-background-light dark:bg-background-dark">
    <header class="sticky top-0 z-50 bg-white dark:bg-surface-dark/95 backdrop-blur-sm border-b border-border dark:border-gray-800">
        <div class="flex items-center px-4 py-3 relative">
            <a href="{{ route('building-admin.dashboard') }}" class="flex items-center justify-center h-10 w-10 rounded-full hover:bg-background-light dark:hover:bg-gray-800 transition-colors text-text-main dark:text-white mr-2 z-10">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div class="flex-1 flex justify-center absolute left-0 right-0 pointer-events-none">
                <h1 class="text-text-main dark:text-white text-xl font-bold tracking-tight text-center pointer-events-auto">Residents Directory</h1>
            </div>
            <div class="flex items-center gap-3 flex-1 justify-end z-10">
                <a href="{{ route('building-admin.residents.create') }}" class="flex items-center justify-center h-10 w-10 rounded-full bg-primary/10 hover:bg-primary/20 text-primary transition-colors">
                    <span class="material-symbols-outlined">add</span>
                </a>
            </div>
        </div>
    </header>
    <main class="w-full max-w-md mx-auto flex flex-col gap-4">
        <!-- Stats Section -->
        <section class="px-4 py-4">
            <div class="grid grid-cols-3 gap-3">
                <div class="flex flex-col items-start justify-center p-3 bg-white dark:bg-surface-dark rounded-xl shadow-card border border-border dark:border-gray-700">
                    <p class="text-text-sub dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Total</p>
                    <p class="text-text-main dark:text-white text-2xl font-bold mt-1">{{ $residents->count() }}</p>
                </div>
                <div class="flex flex-col items-start justify-center p-3 bg-white dark:bg-surface-dark rounded-xl shadow-card border border-border dark:border-gray-700">
                    <div class="flex items-center gap-1.5 mb-1">
                        <span class="w-2 h-2 rounded-full bg-success"></span>
                        <p class="text-text-sub dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Occupied</p>
                    </div>
                    <p class="text-text-main dark:text-white text-2xl font-bold">{{ $residents->where('status', 'occupied')->count() }}</p>
                </div>
                <div class="flex flex-col items-start justify-center p-3 bg-white dark:bg-surface-dark rounded-xl shadow-card border border-border dark:border-gray-700">
                    <div class="flex items-center gap-1.5 mb-1">
                        <span class="w-2 h-2 rounded-full bg-warning"></span>
                        <p class="text-text-sub dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Vacant</p>
                    </div>
                    <p class="text-text-main dark:text-white text-2xl font-bold">{{ $residents->where('status', 'vacant')->count() }}</p>
                </div>
            </div>
        </section>
        <!-- Search & Filter Section -->
        <section class="px-4 pt-2 pb-0">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <form action="" method="GET" class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search residents..." class="w-full rounded-full border border-border dark:border-gray-700 bg-white dark:bg-surface-dark px-4 py-2 text-sm text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/20 transition" />
                    </form>
                    <a href="{{ route('building-admin.residents.create') }}" class="flex items-center justify-center h-10 w-10 rounded-full bg-primary/10 hover:bg-primary/20 text-primary transition-colors">
                        <span class="material-symbols-outlined">add</span>
                    </a>
                </div>
                <div class="flex gap-2 min-w-max overflow-x-auto no-scrollbar pb-2">
                    <a href="?" class="flex items-center px-4 py-2 rounded-full bg-text-main dark:bg-white text-white dark:text-text-main text-sm font-medium transition-colors shadow-sm {{ !request('status') ? 'ring-2 ring-primary/30' : '' }}">All</a>
                    <a href="?status=occupied" class="flex items-center px-4 py-2 rounded-full bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors shadow-sm {{ request('status') == 'occupied' ? 'ring-2 ring-primary/30' : '' }}">Occupied</a>
                    <a href="?status=vacant" class="flex items-center px-4 py-2 rounded-full bg-white dark:bg-surface-dark border border-border dark:border-gray-700 text-text-sub dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors shadow-sm {{ request('status') == 'vacant' ? 'ring-2 ring-primary/30' : '' }}">Vacant</a>
                </div>
            </div>
        </section>
        <!-- List Header -->
        <div class="px-4 pt-2 pb-0 flex items-center justify-between">
            <h3 class="text-text-main dark:text-white font-semibold text-lg">All Residents</h3>
        </div>
        <!-- Resident List -->
        <section class="px-4 flex flex-col gap-3">
            @forelse($residents as $resident)
                <div class="bg-white dark:bg-surface-dark rounded-xl p-4 shadow-card border border-border dark:border-gray-700 flex items-center justify-between group cursor-pointer hover:border-primary/50 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="relative w-12 h-12 rounded-lg overflow-hidden shrink-0 flex flex-col items-center justify-center bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 shadow-card">
                            <span class="material-symbols-outlined text-primary text-2xl">person</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-text-main dark:text-white font-bold text-base">{{ $resident->name }}</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide
                                    @if($resident->status === 'occupied')
                                        bg-green-600 text-white border border-green-700
                                    @elseif($resident->status === 'vacant')
                                        bg-gray-400 text-white border border-gray-500
                                    @else
                                        bg-gray-200 text-gray-700 border border-gray-300
                                    @endif
                                ">
                                    {{ ucfirst($resident->status ?? 'active') }}
                                </span>
                            </div>
                            <p class="text-text-sub dark:text-gray-400 text-sm mt-0.5 line-clamp-1">
                                Flat {{ $resident->flat->block ?? '-' }}-{{ $resident->flat->flat_number ?? '-' }} • {{ $resident->phone }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('building-admin.residents.edit', $resident) }}" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-primary hover:bg-primary/5 transition-colors">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                </div>
            @empty
                <p class="text-text-sub dark:text-gray-400 text-sm">No residents found.</p>
            @endforelse
        </section>
    </main>
</div>
@endsection
