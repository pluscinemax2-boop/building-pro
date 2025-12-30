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
    </div>
    <!-- Search Bar -->
    <div class="px-4 py-3 bg-white dark:bg-[#1a2632]">
        <label class="flex flex-col min-w-40 h-12 w-full">
            <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                <div class="text-[#617589] flex border-none bg-[#f0f2f4] dark:bg-gray-800 items-center justify-center pl-4 rounded-l-lg border-r-0">
                    <span class="material-symbols-outlined text-2xl">search</span>
                </div>
                <input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] dark:text-white focus:outline-0 focus:ring-0 border-none bg-[#f0f2f4] dark:bg-gray-800 focus:border-none h-full placeholder:text-[#617589] px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal" placeholder="Search notices..." value="{{ request('search') }}" name="search" form="notice-search-form"/>
            </div>
        </label>
    </div>
    <!-- Segmented Buttons (Tabs) -->
    <form id="notice-search-form" method="GET" action="{{ route('building-admin.notices.index') }}">
        <div class="flex px-4 py-2 bg-white dark:bg-[#1a2632] pb-4">
            <div class="flex h-10 flex-1 items-center justify-center rounded-lg bg-[#f0f2f4] dark:bg-gray-800 p-1">
                <label class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-md px-2 has-[:checked]:bg-white dark:has-[:checked]:bg-[#2c3b4a] has-[:checked]:shadow-sm has-[:checked]:text-primary text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal transition-all">
                    <span class="truncate">Active ({{ $counts['active'] ?? 0 }})</span>
                    <input class="invisible w-0" name="tabs" type="radio" value="Active" onchange="this.form.submit()" {{ ($tab ?? 'Active') == 'Active' ? 'checked' : '' }} />
                </label>
                <label class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-md px-2 has-[:checked]:bg-white dark:has-[:checked]:bg-[#2c3b4a] has-[:checked]:shadow-sm has-[:checked]:text-primary text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal transition-all">
                    <span class="truncate">Scheduled</span>
                    <input class="invisible w-0" name="tabs" type="radio" value="Scheduled" onchange="this.form.submit()" {{ ($tab ?? '') == 'Scheduled' ? 'checked' : '' }} />
                </label>
                <label class="flex cursor-pointer h-full grow items-center justify-center overflow-hidden rounded-md px-2 has-[:checked]:bg-white dark:has-[:checked]:bg-[#2c3b4a] has-[:checked]:shadow-sm has-[:checked]:text-primary text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal transition-all">
                    <span class="truncate">Expired</span>
                    <input class="invisible w-0" name="tabs" type="radio" value="Expired" onchange="this.form.submit()" {{ ($tab ?? '') == 'Expired' ? 'checked' : '' }} />
                </label>
            </div>
        </div>
    </form>
    <!-- Content Area: Notices List -->
    <div class="flex-1 flex flex-col gap-4 p-4 pb-24">
        @forelse($notices as $notice)
            @if($notice->image)
                <div class="bg-cover bg-center flex flex-col items-stretch justify-end rounded-xl pt-[120px] shadow-sm overflow-hidden relative group cursor-pointer transform transition-transform active:scale-[0.98]"
                    style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%), url('{{ asset('storage/' . $notice->image) }}');">
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
                        <div class="flex gap-2">
                            @php $isExpired = $notice->visible_to && \Carbon\Carbon::parse($notice->visible_to)->lt(\Carbon\Carbon::now()); @endphp
                            @if(!$isExpired)
                                <a href="{{ route('building-admin.notices.edit', $notice->id) }}" class="inline-flex items-center justify-center rounded-lg h-9 px-3 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white border border-white/30 text-sm font-bold leading-normal tracking-[0.015em] transition-colors">
                                    <span class="material-symbols-outlined text-base mr-1">edit</span> Edit
                                </a>
                            @endif
                            <form method="POST" action="{{ route('building-admin.notices.destroy', $notice->id) }}" onsubmit="return confirm('Are you sure you want to delete this notice?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center rounded-lg h-9 px-3 bg-red-600/10 hover:bg-red-600/20 text-red-700 border border-red-700/20 text-sm font-bold leading-normal tracking-[0.015em] transition-colors">                                    <span class="material-symbols-outlined text-base mr-1">delete</span> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Fallback Card Design (matches static example) -->
                <div class="bg-cover bg-center flex flex-col items-stretch justify-end rounded-xl shadow-sm overflow-hidden relative group cursor-pointer transform transition-transform active:scale-[0.98] border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#1a2632]">
                    <div class="p-4 flex flex-col gap-3">
                        <div class="flex justify-between items-start">
                            <span class="bg-primary/10 text-primary text-xs font-bold px-2.5 py-1 rounded-full">Important</span>
                            <div class="flex gap-2">
                                @php $isExpired = $notice->visible_to && \Carbon\Carbon::parse($notice->visible_to)->lt(\Carbon\Carbon::now()); @endphp
                                @if(!$isExpired)
                                    <a href="{{ route('building-admin.notices.edit', $notice->id) }}" class="inline-flex items-center justify-center rounded-lg h-9 px-3 bg-primary/10 hover:bg-primary/20 text-primary border border-primary/30 text-sm font-bold leading-normal tracking-[0.015em] transition-colors">
                                        <span class="material-symbols-outlined text-base mr-1">edit</span> Edit
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('building-admin.notices.destroy', $notice->id) }}" onsubmit="return confirm('Are you sure you want to delete this notice?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center rounded-lg h-9 px-3 bg-red-600/10 hover:bg-red-600/20 text-red-700 border border-red-700/20 text-sm font-bold leading-normal tracking-[0.015em] transition-colors">
                                        <span class="material-symbols-outlined text-base mr-1">delete</span> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-[#111418] dark:text-white text-lg font-bold leading-tight mb-1">{{ $notice->title }}</h3>
                            <p class="text-[#617589] dark:text-gray-400 text-sm line-clamp-2">{{ $notice->body }}</p>
                        </div>
                        <div class="flex items-center gap-2 pt-2 border-t border-gray-100 dark:border-gray-700 mt-1">
                            <span class="material-symbols-outlined text-[#617589] text-sm">event_busy</span>
                            <p class="text-[#617589] text-xs font-medium">{{ $notice->expires_label }}</p>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <p class="text-[#617589] dark:text-gray-400 text-sm">No notices found.</p>
        @endforelse
    </div>
        <!-- Floating Create Expense Button -->
    <a href="{{ route('building-admin.notices.create') }}" class="fixed bottom-20 left-1/2 transform -translate-x-1/2 z-50 bg-primary text-white rounded-lg shadow-lg px-6 py-3 flex items-center gap-2 font-bold text-base hover:bg-primary/90 transition">
        <span class="material-symbols-outlined">add_circle</span>
        Create Notice
    </a>
</div>
@endsection
