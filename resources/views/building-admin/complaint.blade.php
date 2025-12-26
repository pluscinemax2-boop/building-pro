@extends('building-admin.layout')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col max-w-md mx-auto bg-white dark:bg-background-dark shadow-xl overflow-hidden">
    <!-- Sticky Top Bar -->
    <div class="sticky top-0 z-20 bg-white dark:bg-background-dark border-b border-neutral-100 dark:border-neutral-800">
        <div class="flex items-center p-4 pb-2 justify-between">
            <div class="flex items-center gap-2">
                <a href="{{ route('building-admin.dashboard') }}" class="text-text-primary dark:text-white flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-neutral-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h2 class="text-text-primary dark:text-white text-xl font-bold leading-tight tracking-tight">Complaints</h2>
            </div>
            <div class="flex items-center justify-end gap-2">
                <button class="flex items-center justify-center size-10 rounded-full hover:bg-neutral-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="material-symbols-outlined text-text-primary dark:text-white">filter_list</span>
                </button>
                <a href="{{ route('building-admin.complaints.create') }}" class="flex items-center justify-center size-10 rounded-full hover:bg-neutral-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="material-symbols-outlined text-primary">add_circle</span>
                </a>
            </div>
        </div>
        <!-- Search Bar -->
        <div class="px-4 pb-4">
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
    </div>
    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto pb-20">
        <!-- Summary Stats -->
        <div class="pt-4 px-4">
            <div class="flex gap-3 overflow-x-auto no-scrollbar pb-2">
                <div class="flex min-w-[130px] flex-1 flex-col gap-1 rounded-2xl p-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-100 dark:border-orange-800/30 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div class="p-1.5 bg-orange-100 dark:bg-orange-800/40 rounded-lg text-orange-600 dark:text-orange-400">
                            <span class="material-symbols-outlined" style="font-size: 20px;">warning</span>
                        </div>
                        <span class="flex h-2 w-2 rounded-full bg-orange-500"></span>
                    </div>
                    <div class="mt-2">
                        <p class="text-text-secondary dark:text-gray-400 text-xs font-semibold uppercase tracking-wider">Pending</p>
                        <p class="text-text-primary dark:text-white text-2xl font-bold leading-tight">{{ $stats['pending'] ?? 0 }}</p>
                    </div>
                </div>
                <div class="flex min-w-[130px] flex-1 flex-col gap-1 rounded-2xl p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div class="p-1.5 bg-blue-100 dark:bg-blue-800/40 rounded-lg text-blue-600 dark:text-blue-400">
                            <span class="material-symbols-outlined" style="font-size: 20px;">engineering</span>
                        </div>
                    </div>
                    <div class="mt-2">
                        <p class="text-text-secondary dark:text-gray-400 text-xs font-semibold uppercase tracking-wider">In Progress</p>
                        <p class="text-text-primary dark:text-white text-2xl font-bold leading-tight">{{ $stats['in_progress'] ?? 0 }}</p>
                    </div>
                </div>
                <div class="flex min-w-[130px] flex-1 flex-col gap-1 rounded-2xl p-4 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/30 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div class="p-1.5 bg-green-100 dark:bg-green-800/40 rounded-lg text-green-600 dark:text-green-400">
                            <span class="material-symbols-outlined" style="font-size: 20px;">check_circle</span>
                        </div>
                    </div>
                    <div class="mt-2">
                        <p class="text-text-secondary dark:text-gray-400 text-xs font-semibold uppercase tracking-wider">Resolved</p>
                        <p class="text-text-primary dark:text-white text-2xl font-bold leading-tight">{{ $stats['resolved'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Priority Section -->
        <div class="px-4 pt-6 pb-2">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-text-primary dark:text-white text-lg font-bold leading-tight">High Priority Actions</h3>
                <a href="{{ route('building-admin.complaints.index', ['priority' => 'high']) }}" class="text-primary text-sm font-medium hover:text-blue-600">See All</a>
            </div>
            @forelse($highPriorityComplaints as $complaint)
                <div class="flex flex-col gap-4 mb-4 rounded-2xl bg-white dark:bg-gray-800 p-4 border border-neutral-200 dark:border-gray-700 shadow-sm transition-transform active:scale-[0.99]">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="inline-flex items-center rounded-md bg-red-50 dark:bg-red-900/30 px-2 py-1 text-xs font-medium text-red-700 dark:text-red-400 ring-1 ring-inset ring-red-600/10">High Priority</span>
                                <span class="text-xs text-text-secondary dark:text-gray-400">• {{ $complaint->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-text-primary dark:text-white text-base font-bold leading-tight mb-1">{{ $complaint->unit }} - {{ $complaint->title }}</p>
                            <p class="text-text-secondary dark:text-gray-400 text-sm font-normal line-clamp-2">{{ $complaint->description }}</p>
                        </div>
                        @if($complaint->image)
                        <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl border border-neutral-200 dark:border-gray-700">
                            <img src="{{ $complaint->image }}" alt="Complaint image" class="w-full h-full object-cover" />
                        </div>
                        @endif
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-neutral-100 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <div class="h-6 w-6 rounded-full bg-gray-200 dark:bg-gray-600 overflow-hidden">
                                <img alt="Tenant avatar" class="h-full w-full object-cover" src="{{ $complaint->user->avatar ?? asset('images/avatar-placeholder.png') }}" />
                            </div>
                            <span class="text-xs font-medium text-text-secondary dark:text-gray-400">{{ $complaint->user->name ?? 'User' }}</span>
                        </div>
                        <a href="{{ route('building-admin.complaints.edit', $complaint) }}" class="flex cursor-pointer items-center justify-center rounded-lg h-8 px-4 bg-primary text-white text-sm font-medium hover:bg-blue-600 transition-colors shadow-sm shadow-blue-200 dark:shadow-none">
                            Update Status
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-text-secondary dark:text-gray-400 text-sm">No high priority complaints.</p>
            @endforelse
        </div>
        <!-- Recent Activity Section -->
        <div class="px-4 pt-2">
            <h3 class="text-text-primary dark:text-white text-lg font-bold leading-tight mb-3">Recent Complaints</h3>
            @forelse($recentComplaints as $complaint)
                <div class="flex flex-col gap-4 mb-3 rounded-2xl bg-white dark:bg-gray-800 p-4 border border-neutral-200 dark:border-gray-700 shadow-sm @if($complaint->status === 'resolved') opacity-80 @endif">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{
                                    $complaint->status === 'resolved' ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 ring-green-600/20' :
                                    ($complaint->priority === 'high' ? 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 ring-red-600/10' :
                                    ($complaint->priority === 'medium' ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 ring-yellow-600/20' :
                                    'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 ring-blue-700/10'))
                                }}">
                                    {{ ucfirst($complaint->status === 'resolved' ? 'Resolved' : ($complaint->priority ?? 'In Progress')) }}
                                </span>
                                <span class="text-xs text-text-secondary dark:text-gray-400">• {{ $complaint->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-text-primary dark:text-white text-base font-bold leading-tight mb-1">{{ $complaint->unit }} - {{ $complaint->title }}</p>
                            <p class="text-text-secondary dark:text-gray-400 text-sm font-normal line-clamp-2">{{ $complaint->description }}</p>
                        </div>
                        @if($complaint->image)
                        <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl border border-neutral-200 dark:border-gray-700">
                            <img src="{{ $complaint->image }}" alt="Complaint image" class="w-full h-full object-cover" />
                        </div>
                        @endif
                    </div>
                    <div class="flex items-center justify-end pt-2 border-t border-neutral-100 dark:border-gray-700">
                        <a href="{{ route('building-admin.complaints.show', $complaint) }}" class="flex cursor-pointer items-center justify-center rounded-lg h-8 px-4 bg-neutral-100 dark:bg-gray-700 text-text-primary dark:text-white text-sm font-medium hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-text-secondary dark:text-gray-400 text-sm">No recent complaints.</p>
            @endforelse
            <div class="h-20"></div> <!-- Spacer for bottom area -->
        </div>
        <!-- Floating Action Button (Alternative placement) -->
        <div class="absolute bottom-6 right-6 z-30">
            <a href="{{ route('building-admin.complaints.create') }}" class="flex items-center justify-center size-14 rounded-full bg-primary text-white shadow-lg shadow-blue-500/30 hover:bg-blue-600 hover:scale-105 transition-all">
                <span class="material-symbols-outlined" style="font-size: 28px;">add</span>
            </a>
        </div>
    </div>
</div>
@endsection
