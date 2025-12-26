@extends('layouts.app')

@section('content')
<div class="w-full max-w-md bg-background-light dark:bg-background-dark relative flex flex-col h-full min-h-screen overflow-x-hidden pb-24 shadow-xl">
<!-- Header Section -->
<div class="px-4 py-5 bg-white dark:bg-[#101922] sticky top-0 z-10 shadow-sm border-b border-gray-100 dark:border-gray-800">
<div class="flex items-center justify-between">
<div class="flex items-center gap-3">
	<a href="{{ route('admin.profile') }}" class="flex items-center gap-3 group">
		<div class="bg-center bg-no-repeat bg-cover rounded-full h-10 w-10 ring-2 ring-primary/10 group-hover:ring-primary transition-all" data-alt="Portrait of the Super Admin user" style='background-image: url("{{ Auth::user()->avatar_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAcYeXuLyMrwndkpOZkLl7jegOHzvA6WfxHdxEOQQxZdyI6UEvGYVjcPydGpUgyGibGBDTW_M0zRyY2429Xe_4iqGhvseN6UwoG6bn8zZkBsTOH1Nxkk8Sgn0xxBOCMc8Jqrl0R-DUrOplefgF6vR6i1paX2iGeAzmhPC-lv5JJgqOiz06WFKNbjMwIQravrEvN1CxuVJgpqRun0pFZ2HFy3rxHQsEkW54CJfMMl4BIGdMzzPKByOJwjIV-xykHmdBgq25ZWD6KDcV' }}");'>
		</div>
		<div class="flex flex-col">
			<p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Welcome Back</p>
			<h1 class="text-[#111418] dark:text-white text-lg font-bold leading-tight group-hover:text-primary transition-colors">Super Admin</h1>
		</div>
	</a>
</div>
<button class="relative flex items-center justify-center w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
<button id="notification-btn" type="button" onclick="toggleNotifications()" class="relative flex items-center justify-center w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none">
	<span class="material-symbols-outlined text-[#111418] dark:text-white" style="font-size: 24px;">notifications</span>
	<span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-[#101922]"></span>
</button>
<!-- Notification Dropdown -->
<div id="notification-dropdown" class="hidden absolute right-4 top-16 w-80 max-w-xs bg-white dark:bg-[#192531] rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 z-50 animate-fade-in">
	<div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700">
		<h3 class="text-[#111418] dark:text-white text-base font-bold">Notifications</h3>
		<button onclick="toggleNotifications()" class="text-gray-400 hover:text-primary transition-colors">
			<span class="material-symbols-outlined">close</span>
		</button>
	</div>
	<div class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
		@forelse($notifications as $note)
		<div class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
			<span class="material-symbols-outlined @if($note['icon']==='report') text-primary bg-blue-50 dark:bg-blue-900/20 @elseif($note['icon']==='payments') text-green-600 bg-green-50 dark:bg-green-900/20 @elseif($note['icon']==='person_add') text-orange-600 bg-orange-50 dark:bg-orange-900/20 @else text-gray-400 bg-gray-100 dark:bg-gray-700 @endif rounded-full p-1">{{ $note['icon'] }}</span>
			<div class="flex-1 min-w-0">
				<p class="text-[#111418] dark:text-white text-sm font-semibold truncate">{{ $note['title'] }}</p>
				<p class="text-[#617589] dark:text-gray-400 text-xs truncate">{{ $note['desc'] }}</p>
				<span class="text-xs text-gray-400">{{ $note['time'] }}</span>
			</div>
		</div>
		@empty
		<div class="text-center text-gray-400 py-6">No new notifications.</div>
		@endforelse
	</div>
</div>
<script>
function toggleNotifications() {
	const dropdown = document.getElementById('notification-dropdown');
	dropdown.classList.toggle('hidden');
	// Optional: close if clicked outside
	if (!dropdown.classList.contains('hidden')) {
		document.addEventListener('mousedown', closeOnClickOutside);
	} else {
		document.removeEventListener('mousedown', closeOnClickOutside);
	}
}
function closeOnClickOutside(e) {
	const dropdown = document.getElementById('notification-dropdown');
	const btn = document.getElementById('notification-btn');
	if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
		dropdown.classList.add('hidden');
		document.removeEventListener('mousedown', closeOnClickOutside);
	}
}
</script>
</div>
</div>
<!-- Search Bar -->
<div class="px-4 pt-6 pb-2">
<label class="flex flex-col w-full">
<div class="flex w-full items-center rounded-xl h-12 bg-white dark:bg-[#192531] shadow-sm border border-gray-100 dark:border-gray-700 transition-all focus-within:ring-2 focus-within:ring-primary/20">
<div class="pl-4 flex items-center justify-center text-[#617589] dark:text-gray-400">
<span class="material-symbols-outlined" style="font-size: 20px;">search</span>
</div>
<form method="GET" action="">
	<input name="search" value="{{ old('search', $search) }}" class="w-full bg-transparent border-none focus:ring-0 text-[#111418] dark:text-white placeholder:text-[#9aa2ac] h-full px-3 text-sm font-medium" placeholder="Search buildings, users, or reports..."/>
</form>
</div>
</label>
</div>
<!-- Main Stats: Revenue -->
<div class="px-4 py-4">
<div class="flex flex-col gap-2 rounded-xl p-5 bg-white dark:bg-[#192531] shadow-sm border border-gray-100 dark:border-gray-700">
	<div class="flex justify-between items-start">
		<div class="flex flex-col gap-1">
			<p class="text-[#617589] dark:text-gray-400 text-sm font-medium">Monthly Recurring Revenue</p>
			<p class="text-[#111418] dark:text-white text-3xl font-bold tracking-tight">₹{{ number_format($monthlyRevenue, 0) }}</p>
		</div>
		<div class="flex items-center gap-1 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-lg">
			@if($revenueChange >= 0)
				<span class="material-symbols-outlined text-green-600 dark:text-green-400" style="font-size: 16px;">trending_up</span>
				<span class="text-green-700 dark:text-green-400 text-xs font-bold">+{{ $revenueChange }}%</span>
			@else
				<span class="material-symbols-outlined text-red-600 dark:text-red-400" style="font-size: 16px;">trending_down</span>
				<span class="text-red-700 dark:text-red-400 text-xs font-bold">{{ $revenueChange }}%</span>
			@endif
		</div>
	</div>
</div>
</div>
<!-- Grid Stats -->
<div class="px-4 pb-4">
<div class="grid grid-cols-2 gap-3">
<!-- Total Buildings -->
<div class="flex flex-col gap-2 rounded-xl p-4 bg-white dark:bg-[#192531] shadow-sm border border-gray-100 dark:border-gray-700">
<div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center mb-1">
<span class="material-symbols-outlined text-primary" style="font-size: 24px;">apartment</span>
</div>
<p class="text-[#617589] dark:text-gray-400 text-xs font-medium">Total Buildings</p>
<p class="text-[#111418] dark:text-white text-xl font-bold">{{ $totalBuildings }}</p>
</div>
<!-- Active Subscriptions -->
<div class="flex flex-col gap-2 rounded-xl p-4 bg-white dark:bg-[#192531] shadow-sm border border-gray-100 dark:border-gray-700">
<div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center mb-1">
<span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400" style="font-size: 24px;">verified</span>
</div>
<p class="text-[#617589] dark:text-gray-400 text-xs font-medium">Active Subs</p>
<p class="text-[#111418] dark:text-white text-xl font-bold">{{ $activeSubscriptions }}</p>
</div>
<!-- Total Users -->
<div class="flex flex-col gap-2 rounded-xl p-4 bg-white dark:bg-[#192531] shadow-sm border border-gray-100 dark:border-gray-700">
<div class="w-10 h-10 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center mb-1">
<span class="material-symbols-outlined text-teal-600 dark:text-teal-400" style="font-size: 24px;">group</span>
</div>
<p class="text-[#617589] dark:text-gray-400 text-xs font-medium">Total Users</p>
<p class="text-[#111418] dark:text-white text-xl font-bold">{{ $totalUsers }}</p>
</div>
<!-- Expired Subs (Alert) -->
<div class="flex flex-col gap-2 rounded-xl p-4 bg-red-50 dark:bg-red-900/10 shadow-sm border border-red-100 dark:border-red-900/30 relative overflow-hidden">
<div class="absolute -right-4 -top-4 w-16 h-16 bg-red-100 dark:bg-red-900/20 rounded-full z-0"></div>
<div class="relative z-10 w-10 h-10 rounded-lg bg-white/60 dark:bg-white/10 flex items-center justify-center mb-1">
<span class="material-symbols-outlined text-red-600 dark:text-red-400" style="font-size: 24px;">warning</span>
</div>
<p class="relative z-10 text-red-800 dark:text-red-300 text-xs font-bold">Expired Subs</p>
<p class="relative z-10 text-red-900 dark:text-red-200 text-xl font-bold">{{ $expiredSubscriptions }}</p>
</div>
</div>
</div>
<!-- Recent Activity -->
<div class="px-4 pb-4">
<div class="flex items-center justify-between mb-3">
<h2 class="text-[#111418] dark:text-white text-lg font-bold">Recent Activity</h2>
<a href="{{ route('admin.recent.activities') }}" class="text-primary text-sm font-medium hover:underline">View All</a>
</div>
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
<!-- Spacer for content to not be hidden behind bottom nav -->
<div class="h-8"></div>
<!-- Bottom Navigation Bar -->
<div class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-[#192531] border-t border-gray-200 dark:border-gray-700 pb-safe pt-2 px-2 max-w-md mx-auto">
<div class="flex items-center justify-around pb-2">
<a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-primary group">
	<span class="material-symbols-outlined group-hover:scale-110 transition-transform filled" style="font-variation-settings: 'FILL' 1;">dashboard</span>
	<span class="text-[10px] font-medium">Home</span>
</a>
<a href="{{ route('admin.building-management') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
	<span class="material-symbols-outlined group-hover:scale-110 transition-transform">apartment</span>
	<span class="text-[10px] font-medium">Buildings</span>
</a>
<a href="{{ route('users.index') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
	<span class="material-symbols-outlined group-hover:scale-110 transition-transform">group</span>
	<span class="text-[10px] font-medium">Users</span>
</a>
<a href="{{ route('reports.index') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
	<span class="material-symbols-outlined group-hover:scale-110 transition-transform">bar_chart</span>
	<span class="text-[10px] font-medium">Reports</span>
</a>
<button type="button" onclick="document.getElementById('settings-overlay').classList.remove('hidden')" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
	<span class="material-symbols-outlined group-hover:scale-110 transition-transform">settings</span>
	<span class="text-[10px] font-medium">Settings</span>
</button>
</div>
</div>
</div>
@endsection
