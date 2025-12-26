@extends('layouts.app')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col max-w-2xl mx-auto bg-background-light dark:bg-background-dark group/design-root shadow-xl">
    <!-- TopAppBar -->
    <div class="sticky top-0 z-10 flex items-center bg-white dark:bg-[#1c2936] p-4 border-b border-[#e5e7eb] dark:border-[#2a3c4d]">
        <a href="{{ route('building-admin.subscription') }}" class="flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-[#111418] dark:text-white transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center pr-10">Choose a Plan</h2>
    </div>
    <!-- Building Info -->
    <div class="p-4">
        <div class="flex items-center gap-3 mb-4">
            <span class="material-symbols-outlined text-primary text-2xl">apartment</span>
            <div>
                <div class="text-lg font-bold text-[#111418] dark:text-white">{{ $building->name }}</div>
                <div class="text-xs text-[#617589] dark:text-gray-400 flex items-center gap-1"><span class="material-symbols-outlined text-base">location_on</span>{{ $building->address }}</div>
                <div class="text-xs text-[#617589] dark:text-gray-400 flex items-center gap-1"><span class="material-symbols-outlined text-base">home</span>{{ $building->total_flats }} Flats</div>
            </div>
        </div>
        <!-- Plans List -->
        <div class="flex flex-col gap-6">
            @forelse($plans as $plan)
            <div class="relative flex flex-col gap-4 rounded-xl bg-white dark:bg-[#1c2936] p-5 shadow-sm border border-[#e5e7eb] dark:border-[#2a3c4d]">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="material-symbols-outlined text-primary">diamond</span>
                        <span class="text-lg font-bold text-[#111418] dark:text-white">{{ $plan->name }}</span>
                        @if(!empty($plan->highlight))
                        <span class="ml-2 px-2 py-0.5 rounded bg-primary text-white text-xs font-bold">{{ $plan->highlight }}</span>
                        @endif
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-bold text-[#111418] dark:text-white">₹{{ number_format($plan->price, 0) }}</span>
                        <span class="text-xs text-[#617589] dark:text-gray-400">/ {{ ucfirst($plan->billing_cycle) }}</span>
                    </div>
                    <div class="text-xs text-[#617589] dark:text-gray-400 mb-2">{{ $plan->description ?? 'Full-featured package' }}</div>
                    <div class="flex flex-col gap-1 mb-4">
                        @foreach($plan->features ?? [] as $feature)
                        <div class="flex items-center gap-2 text-[13px] text-[#3d4d5c] dark:text-[#cbd5e1]">
                            <span class="material-symbols-outlined text-primary text-[18px]">check_circle</span>
                            {{ $feature }}
                        </div>
                        @endforeach
                    </div>
                    <form action="/building-admin/subscription/activate" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <button type="submit"
                            class="w-full flex items-center justify-center rounded-xl h-12 px-5 
                            {{ $loop->index === 1 ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white hover:opacity-90' : 'bg-primary text-white hover:bg-blue-600' }}
                            transition-colors text-base font-bold leading-normal tracking-[0.015em] shadow-lg shadow-blue-500/20 mt-2">
                            <span>Upgrade</span>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-400 py-6">No plans found.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

