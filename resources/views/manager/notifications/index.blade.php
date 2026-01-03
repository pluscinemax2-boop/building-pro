@extends('manager.layout')

@section('title', 'Notifications')

@section('content')
<div class="p-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#111418] dark:text-white">Notifications</h1>
        <p class="text-[#617589] dark:text-gray-400">All your building management notifications</p>
    </div>

    <div class="space-y-3">
        @forelse($notifications as $notification)
        <div class="flex items-start gap-3 rounded-xl bg-white dark:bg-gray-800 p-3 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 size-10">
                <span class="material-symbols-outlined">notifications</span>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-[#111418] dark:text-white">{{ $notification->data['title'] ?? 'Notification' }}</h3>
                    <span class="text-xs text-[#617589] dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-[#617589] dark:text-gray-400 mt-1">{{ $notification->data['message'] ?? 'New notification' }}</p>
                
                @if(is_null($notification->read_at))
                <span class="inline-block mt-2 px-2 py-1 bg-primary text-white text-xs rounded-full">New</span>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600 mb-4">notifications_off</span>
            <h3 class="text-lg font-semibold text-[#111418] dark:text-white mb-1">No notifications</h3>
            <p class="text-[#617589] dark:text-gray-400">You're all caught up! Check back later for updates.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection