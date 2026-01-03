@extends('manager.layout')

@section('title', 'Manager Dashboard')

@section('content')
<div class="p-4">
    <!-- Emergency Banner - Only show if there are active emergencies -->
    @php
        $activeEmergency = App\Models\EmergencyAlert::where('building_id', $user->building_id)
                                      ->where('status', '!=', 'Resolved')
                                      ->latest()
                                      ->first();
    @endphp
    
    @if($activeEmergency)
    <div class="flex flex-col gap-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/50 p-4 shadow-sm mb-4">
        <div class="flex items-start justify-between gap-4">
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2 mb-1">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-xl">warning</span>
                    <p class="text-red-700 dark:text-red-300 text-xs font-bold uppercase tracking-wide">Active Emergency</p>
                </div>
                <p class="text-[#111418] dark:text-white text-base font-bold leading-tight">{{ $activeEmergency->title ?? 'Emergency Alert' }}</p>
                <p class="text-[#617589] dark:text-gray-300 text-sm font-normal leading-normal">{{ $activeEmergency->description ?? 'Urgent attention required.' }}</p>
            </div>
            <div class="bg-center bg-no-repeat size-16 bg-cover rounded-lg shrink-0" data-alt="Red warning icon graphic on soft background" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDuv3ntlIrNFzxDxyhVPZUCkisx0nz-IIEhjDOVFbjf8BJmbEWJ8jnmBS5ekuTVOYEaX51iqRxBDRbW7OECoBE8AjbBxRWBlDpgDGCItoWbMjkxaJYJdaO6bKESbaxysaWWFzsBczeztMQn2YB3I71W_aWDEjRRlf65RleO1lg0GR-SBV1VBfxsuM5VzR1QQYgVNFKoXdMz7ZPVl6QuVahvLsIB6d8hNzCzn0eFug_wgZaoUv70RINnWm5SuW8T0If-3ujGeVCnMrJ6");'></div>
        </div>
        <a href="{{ route('manager.emergency') }}" class="flex w-full cursor-pointer items-center justify-center rounded-lg h-9 px-4 bg-red-100 hover:bg-red-200 dark:bg-red-800 dark:hover:bg-red-700 text-red-800 dark:text-red-100 text-sm font-semibold transition-colors">
            View Emergency Details
        </a>
    </div>
    @endif
    
    <!-- KPI Stats Grid -->
    <div class="grid grid-cols-2 gap-3 mb-4">
        <!-- Open Complaints -->
        <div class="flex flex-col gap-2 rounded-xl p-4 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 p-2 flex-shrink-0">
                    <span class="material-symbols-outlined">folder_open</span>
                </div>
                <div class="text-right ml-2">
                    <p class="text-[#111418] dark:text-white text-3xl font-bold leading-tight">{{ $openComplaints }}</p>
                </div>
            </div>
            <div>
                <p class="text-[#617589] dark:text-gray-400 text-sm font-medium">Open Complaints</p>
            </div>
        </div>
        <!-- In Progress -->
        <div class="flex flex-col gap-2 rounded-xl p-4 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-400 p-2 flex-shrink-0">
                    <span class="material-symbols-outlined">pending</span>
                </div>
                <div class="text-right ml-2">
                    <p class="text-[#111418] dark:text-white text-3xl font-bold leading-tight">{{ $inProgress }}</p>
                </div>
            </div>
            <div>
                <p class="text-[#617589] dark:text-gray-400 text-sm font-medium">In Progress</p>
            </div>
        </div>
        <!-- Resolved Today -->
        <div class="flex flex-col gap-2 rounded-xl p-4 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-center rounded-lg bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 p-2 flex-shrink-0">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <div class="text-right ml-2">
                    <p class="text-[#111418] dark:text-white text-3xl font-bold leading-tight">{{ $resolvedToday }}</p>
                </div>
            </div>
            <div>
                <p class="text-[#617589] dark:text-gray-400 text-sm font-medium">Resolved Today</p>
            </div>
        </div>
        <!-- Pending Approval -->
        <div class="flex flex-col gap-2 rounded-xl p-4 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400 p-2 flex-shrink-0">
                    <span class="material-symbols-outlined">assignment_turned_in</span>
                </div>
                <div class="text-right ml-2">
                    <p class="text-[#111418] dark:text-white text-3xl font-bold leading-tight">{{ $pendingApproval }}</p>
                </div>
            </div>
            <div>
                <p class="text-[#617589] dark:text-gray-400 text-sm font-medium">To Approve</p>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity Header -->
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Recent Activity</h3>
        <a href="{{ route('manager.activities') }}" class="text-primary text-sm font-medium hover:underline">View All</a>
    </div>
    
    <!-- Recent Activity List -->
    <div class="flex flex-col gap-3">
        @forelse($recentComplaints as $complaint)
        <div class="flex items-center justify-between gap-4 rounded-xl bg-white dark:bg-gray-800 p-3 shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700 shrink-0 size-10 text-[#111418] dark:text-white">
                    <span class="material-symbols-outlined text-xl">folder_shared</span>
                </div>
                <div class="flex flex-col justify-center">
                    <p class="text-[#111418] dark:text-white text-sm font-semibold leading-normal line-clamp-1">{{ $complaint->title }}</p>
                    <p class="text-[#617589] dark:text-gray-400 text-xs font-normal leading-normal">{{ $complaint->building->name ?? 'N/A' }} • {{ $complaint->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <span class="px-2 py-1 rounded text-[10px] font-bold {{ $complaint->status === 'Open' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : ($complaint->status === 'In Progress' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300') }}">
                {{ $complaint->status }}
            </span>
        </div>
        @empty
        <div class="text-center py-4 text-gray-500">
            <span class="material-symbols-outlined text-4xl mb-2">inbox</span>
            <p>No recent complaints</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
