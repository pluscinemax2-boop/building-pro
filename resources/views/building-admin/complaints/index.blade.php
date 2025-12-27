@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display min-h-screen flex flex-col antialiased selection:bg-primary/20">
    <!-- Sticky Top Bar -->
    <div class="sticky top-0 z-20 bg-white dark:bg-background-dark border-b border-neutral-100 dark:border-neutral-800">
        <div class="flex items-center p-4 pb-2 justify-between">
            <div class="flex items-center gap-2 w-full relative">
                <a href="{{ route('building-admin.dashboard') }}" class="absolute left-0 text-text-primary dark:text-white flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-neutral-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h2 class="text-text-primary dark:text-white text-xl font-bold leading-tight tracking-tight w-full text-center">Complaints</h2>
            </div>
            <div class="flex items-center justify-end gap-2">
                <!-- Removed top-right create button -->
            </div>
        </div>
    </div>
    <!-- Scrollable Content -->
    <div class="flex-1 flex flex-col pb-24 max-w-lg mx-auto w-full">
        <!-- Search Bar -->
        <div class="px-5 pt-4">
            <form method="GET" action="{{ route('building-admin.complaints.index') }}">
                <label class="flex flex-col h-11 w-full">
                    <div class="flex w-full flex-1 items-stretch rounded-xl h-full shadow-sm">
                        <div class="text-text-secondary dark:text-gray-400 flex border-none bg-neutral-100 dark:bg-gray-800 items-center justify-center pl-4 rounded-l-xl border-r-0">
                            <span class="material-symbols-outlined" style="font-size: 20px;">search</span>
                        </div>
                        <input name="search" value="{{ request('search') }}" class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-text-primary dark:text-white focus:outline-0 focus:ring-0 border-none bg-neutral-100 dark:bg-gray-800 focus:border-none h-full placeholder:text-text-secondary dark:placeholder:text-gray-500 px-3 rounded-l-none border-l-0 text-sm font-medium leading-normal transition-all" placeholder="Search unit, issue, or tenant name" />
                    </div>
                </label>
            </form>
        </div>
        <!-- Summary Stats -->
        <div class="pt-4 px-4">
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-medium uppercase tracking-wider mb-1 flex items-center gap-1">
                        <span class="inline-block w-2 h-2 rounded-full bg-red-500"></span> Pending
                    </p>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-bold text-red-600">{{ $stats['open'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-medium uppercase tracking-wider mb-1 flex items-center gap-1">
                        <span class="inline-block w-2 h-2 rounded-full bg-blue-500"></span> In Progress
                    </p>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-bold text-blue-600">{{ $stats['in_progress'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-medium uppercase tracking-wider mb-1 flex items-center gap-1">
                        <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span> Resolved
                    </p>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-bold text-green-600">{{ $stats['resolved'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- High Priority Actions -->
        <div x-data="{ showModal: false, modalType: '' }">
        <div class="px-4 pt-6 pb-2">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-text-primary dark:text-white text-lg font-bold leading-tight">High Priority Actions</h3>
                <a href="{{ route('building-admin.complaints.all') }}" class="text-primary text-sm font-semibold hover:underline">View All</a>
            </div>
            @php $highPriority = $complaints->where('priority', 'High')->sortByDesc('created_at')->take(3); @endphp
            @forelse($highPriority as $complaint)
                @include('building-admin.complaints._card', ['complaint' => $complaint])
            @empty
                <div class="text-slate-400 text-sm">No high priority actions.</div>
            @endforelse
        </div>

        <!-- Recent Complaints -->
        <div class="px-4 pt-2 pb-2">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-text-primary dark:text-white text-lg font-bold leading-tight">Recent Complaints</h3>
                <a href="{{ route('building-admin.complaints.all') }}" class="text-primary text-sm font-semibold hover:underline">View All</a>
            </div>
            @foreach($complaints->sortByDesc('created_at')->take(5) as $complaint)
            <div>
            @include('building-admin.complaints._card', ['complaint' => $complaint])
                </div>
            @endforeach
        </div>

            <!-- View All Modal or Page Placeholder -->
            <!--
            <div id="viewAllComplaintsModal" style="display:none;">
                @foreach($complaints->sortByDesc('created_at')->take(20) as $complaint)
                    ...same card design as above...
                @endforeach
            </div>
            -->
        </div>
    </div>

    <!-- Floating Create Complaint Button -->
    <a href="{{ route('building-admin.complaints.create') }}" class="fixed bottom-20 left-1/2 transform -translate-x-1/2 z-50 bg-primary text-white rounded-lg shadow-lg px-6 py-3 flex items-center gap-2 font-bold text-base hover:bg-primary/90 transition">
        <span class="material-symbols-outlined">add_circle</span>
        Create Complaint
    </a>
</div>
    @include('building-admin.partials.bottom-nav', ['active' => 'complaints'])
@endsection
