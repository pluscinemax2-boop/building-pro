@extends('layouts.app')
@section('content')
<div class="w-full max-w-md bg-background-light dark:bg-background-dark relative flex flex-col h-full min-h-screen overflow-x-hidden pb-24 shadow-xl">
    <div class="px-4 py-5 bg-white dark:bg-[#101922] sticky top-0 z-10 shadow-sm border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="flex size-10 shrink-0 items-center justify-center cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full text-[#111418] dark:text-white">
                <span class="material-symbols-outlined">arrow_back_ios_new</span>
            </a>
            <h2 class="text-[#111418] dark:text-white text-lg font-bold">Recent Activities</h2>
        </div>
    </div>
    <div class="px-4 py-6">
        <div class="flex flex-col gap-3">
            @forelse($recentActivities as $activity)
                <div class="flex items-center gap-3 p-3 bg-white dark:bg-[#192531] rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full 
                        @if($activity['type']==='building') bg-green-50 dark:bg-green-900/20
                        @elseif($activity['type']==='complaint') bg-blue-50 dark:bg-blue-900/20
                        @elseif($activity['type']==='user') bg-orange-50 dark:bg-orange-900/20
                        @else bg-gray-100 dark:bg-gray-700 @endif shrink-0">
                        <span class="material-symbols-outlined 
                            @if($activity['type']==='building') text-green-600 dark:text-green-400
                            @elseif($activity['type']==='complaint') text-primary
                            @elseif($activity['type']==='user') text-orange-600 dark:text-orange-400
                            @else text-gray-400 @endif" style="font-size: 20px;">
                            @if($activity['type']==='building') add_circle
                            @elseif($activity['type']==='complaint') autorenew
                            @elseif($activity['type']==='user') person_add
                            @else info @endif
                        </span>
                    </div>
                    <div class="flex flex-col flex-1 min-w-0">
                        <p class="text-[#111418] dark:text-white text-sm font-semibold truncate">{{ $activity['title'] }}</p>
                        <p class="text-[#617589] dark:text-gray-400 text-xs truncate">{{ $activity['desc'] }}</p>
                    </div>
                    <p class="text-[#9aa2ac] dark:text-gray-500 text-xs whitespace-nowrap">{{ $activity['time'] }}</p>
                </div>
            @empty
                <div class="text-center text-gray-400 py-6">No recent activity found.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
