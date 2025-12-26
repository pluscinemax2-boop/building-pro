@extends('building-admin.layout')
@section('content')
<div class="min-h-screen relative pb-24 bg-background-light dark:bg-background-dark">
    <header class="sticky top-0 z-50 bg-white dark:bg-surface-dark/95 backdrop-blur-sm border-b border-border dark:border-gray-800">
        <div class="flex items-center px-4 py-3 relative">
            <a href="{{ route('building-admin.dashboard') }}" class="flex items-center justify-center h-10 w-10 rounded-full hover:bg-background-light dark:hover:bg-gray-800 transition-colors text-text-main dark:text-white mr-2 z-10">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div class="flex-1 flex justify-center absolute left-0 right-0 pointer-events-none">
                <h1 class="text-text-main dark:text-white text-xl font-bold tracking-tight text-center pointer-events-auto">Flat Details</h1>
            </div>
        </div>
    </header>
    <main class="w-full max-w-md mx-auto flex flex-col gap-4 p-4">
        <div class="bg-white dark:bg-surface-dark rounded-xl p-6 shadow-card border border-border dark:border-gray-700 flex flex-col gap-4">
            <div class="flex items-center gap-4">
                <div class="relative w-16 h-16 rounded-lg overflow-hidden shrink-0 flex flex-col items-center justify-center bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 shadow-card">
                    <!-- Home Icon -->
                    <span class="material-symbols-outlined text-primary text-3xl">home</span>
                    <!-- Status Dot -->
                    <span class="absolute top-2 right-2 w-3 h-3 rounded-full border-2 border-white dark:border-surface-dark"
                        style="background-color:
                            @if($flat->status === 'occupied') #22c55e
                            @elseif($flat->status === 'vacant') #64748b
                            @elseif($flat->status === 'pending') #eab308
                            @else #d1d5db
                            @endif;"></span>
                </div>
                <div>
                    <h2 class="text-text-main dark:text-white font-bold text-xl mb-1">Flat {{ $flat->block ?? '' }}-{{ $flat->flat_number }}</h2>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ $flat->status === 'occupied' ? 'bg-success/10 text-success border border-success/20' : ($flat->status === 'vacant' ? 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-600' : 'bg-warning/10 text-warning border border-warning/20') }} uppercase tracking-wide">
                        {{ ucfirst($flat->status) }}
                    </span>
                </div>
            </div>
            <div class="text-text-sub dark:text-gray-400 text-base">
                <div><strong>Floor:</strong> {{ $flat->floor }}</div>
                <div><strong>Type:</strong> {{ $flat->type }}</div>
                <div><strong>Resident:</strong> {{ $flat->resident->name ?? 'No Resident' }}</div>
            </div>
            <div class="flex gap-2 mt-4">
                <a href="{{ route('building-admin.flats.edit', $flat) }}" class="bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined">edit</span> Edit
                </a>
                <form action="{{ route('building-admin.flats.destroy', $flat) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this flat?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <span class="material-symbols-outlined">delete</span> Delete
                    </button>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection
