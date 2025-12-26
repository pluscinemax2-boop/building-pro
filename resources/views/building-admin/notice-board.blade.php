
@extends('building-admin.layout')

@section('content')
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root">
    <!-- Top App Bar -->
    <div class="flex items-center bg-white dark:bg-[#1a2632] p-4 pb-2 justify-between sticky top-0 z-20 shadow-sm border-b border-gray-100 dark:border-gray-800">
        <div class="text-[#111418] dark:text-white flex size-12 shrink-0 items-center justify-start cursor-pointer">
            <a href="{{ route('building-admin.dashboard') }}">
                <span class="material-symbols-outlined text-2xl">arrow_back</span>
            </a>
        </div>
        <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">Notice Board</h2>
        <div class="flex w-12 items-center justify-end">
            <button class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 w-10 bg-background-light dark:bg-gray-800 text-[#111418] dark:text-white gap-2 text-base font-bold leading-normal tracking-[0.015em] min-w-0 p-0">
                <span class="material-symbols-outlined text-2xl">account_circle</span>
            </button>
        </div>
    </div>
    <!-- Search Bar -->
    <div class="px-4 py-3 bg-white dark:bg-[#1a2632]">
        <label class="flex flex-col min-w-40 h-12 w-full">
            <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                <div class="text-[#617589] flex border-none bg-[#f0f2f4] dark:bg-gray-800 items-center justify-center pl-4 rounded-l-lg border-r-0">
                    <span class="material-symbols-outlined text-2xl">search</span>
                </div>
                <input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] dark:text-white focus:outline-0 focus:ring-0 border-none bg-[#f0f2f4] dark:bg-gray-800 focus:border-none h-full placeholder:text-[#617589] px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal" placeholder="Search notices..." value="{{ request('search') }}" name="search"/>
            </div>
        </label>
    </div>
    <!-- Segmented Buttons (Tabs) -->
    <div class="flex px-4 py-2 bg-white dark:bg-[#1a2632] pb-4">
        <div class="flex h-10 flex-1 items-center justify-center rounded-lg bg-[#f0f2f4] dark:bg-gray-800 p-1">
            <label class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-md px-2 has-[:checked]:bg-white dark:has-[:checked]:bg-[#2c3b4a] has-[:checked]:shadow-sm has-[:checked]:text-primary text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal transition-all">
                <span class="truncate">Active ({{ $counts['active'] ?? 0 }})</span>
                <input checked class="invisible w-0" name="tabs" type="radio" value="Active" />
            </label>
            <label class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-md px-2 has-[:checked]:bg-white dark:has-[:checked]:bg-[#2c3b4a] has-[:checked]:shadow-sm has-[:checked]:text-primary text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal transition-all">
                <span class="truncate">Scheduled</span>
                <input class="invisible w-0" name="tabs" type="radio" value="Scheduled" />
            </label>
            <label class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-md px-2 has-[:checked]:bg-white dark:has-[:checked]:bg-[#2c3b4a] has-[:checked]:shadow-sm has-[:checked]:text-primary text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal transition-all">
                <span class="truncate">Expired</span>
                <input class="invisible w-0" name="tabs" type="radio" value="Expired" />
            </label>
        </div>
    </div>
    <!-- Content Area: Notices List -->
    <div class="flex-1 flex flex-col gap-4 p-4 pb-24">
        @forelse($notices as $notice)
            <div class="bg-cover bg-center flex flex-col items-stretch justify-end rounded-xl pt-[120px] shadow-sm overflow-hidden relative group cursor-pointer transform transition-transform active:scale-[0.98]" style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%), url('{{ $notice->image_url }}');">
                @if($notice->status_badge)
                <div class="absolute top-3 left-3 {{ $notice->status_badge_bg }} backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm flex items-center gap-1">
                    @if($notice->status_badge_pulse)
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    @endif
                    {{ $notice->status_badge }}
                </div>
                @endif
                <div class="flex w-full items-end justify-between gap-4 p-4">
                    <div class="flex max-w-[440px] flex-1 flex-col gap-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-white/80 text-sm">calendar_clock</span>
                            <p class="text-white/80 text-xs font-medium uppercase tracking-wider">{{ $notice->expires_label }}</p>
                        </div>
                        <p class="text-white tracking-tight text-xl font-bold leading-tight max-w-[440px]">{{ $notice->title }}</p>
                    </div>
                    <button class="flex min-w-[72px] shrink-0 cursor-pointer items-center justify-center overflow-hidden rounded-lg h-9 px-3 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white border border-white/30 text-sm font-bold leading-normal tracking-[0.015em] transition-colors">
                        <span class="truncate">Edit</span>
                    </button>
                </div>
            </div>
        @empty
            <p class="text-[#617589] dark:text-gray-400 text-sm">No notices found.</p>
        @endforelse
        <!-- Fallback Card Example -->
        <div class="bg-cover bg-center flex flex-col items-stretch justify-end rounded-xl shadow-sm overflow-hidden relative group cursor-pointer transform transition-transform active:scale-[0.98] border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#1a2632]">
            <div class="p-4 flex flex-col gap-3">
                <div class="flex justify-between items-start">
                    <span class="bg-primary/10 text-primary text-xs font-bold px-2.5 py-1 rounded-full">Important</span>
                    <div class="flex gap-1 text-[#617589]">
                        <span class="material-symbols-outlined text-lg">more_horiz</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-[#111418] dark:text-white text-lg font-bold leading-tight mb-1">Water Supply Interruption</h3>
                    <p class="text-[#617589] dark:text-gray-400 text-sm line-clamp-2">The main water supply will be shut off for emergency repairs on Block A.</p>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-gray-100 dark:border-gray-700 mt-1">
                    <span class="material-symbols-outlined text-[#617589] text-sm">event_busy</span>
                    <p class="text-[#617589] text-xs font-medium">Expires: Tomorrow, 2:00 PM</p>
                </div>
            </div>
        </div>
    </div>
    <!-- FAB: Create Notice -->
    <div class="fixed bottom-24 right-4 z-30">
        <button class="group flex items-center justify-center w-14 h-14 bg-primary rounded-full shadow-lg shadow-primary/30 text-white hover:bg-blue-600 transition-all hover:scale-105 active:scale-95">
            <span class="material-symbols-outlined text-3xl">add</span>
        </button>
    </div>
    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-[#1a2632] border-t border-gray-200 dark:border-gray-800 z-40 pb-safe">
        <div class="flex justify-around items-center h-16 max-w-lg mx-auto px-2">
            <button class="flex flex-col items-center justify-center w-full h-full space-y-1 text-[#9ca3af] hover:text-[#111418] dark:hover:text-white group">
                <span class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">dashboard</span>
                <span class="text-[10px] font-medium">Home</span>
            </button>
            <button class="flex flex-col items-center justify-center w-full h-full space-y-1 text-[#9ca3af] hover:text-[#111418] dark:hover:text-white group">
                <span class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">group</span>
                <span class="text-[10px] font-medium">Residents</span>
            </button>
            <button class="flex flex-col items-center justify-center w-full h-full space-y-1 text-primary relative group">
                <span class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">campaign</span>
                <span class="text-[10px] font-medium">Notices</span>
                <span class="absolute top-3 right-8 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <button class="flex flex-col items-center justify-center w-full h-full space-y-1 text-[#9ca3af] hover:text-[#111418] dark:hover:text-white group">
                <span class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">inbox</span>
                <span class="text-[10px] font-medium">Requests</span>
            </button>
        </div>
        <div class="h-4 w-full bg-white dark:bg-[#1a2632]"></div>
    </div>
</div>
@endsection
