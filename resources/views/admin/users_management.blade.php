
@extends('layouts.app')
@section('content')
<div class="sticky top-0 z-50 bg-white dark:bg-[#1a2632] shadow-sm border-b border-gray-100 dark:border-gray-800">
	<div class="flex items-center p-4 justify-between h-16">
		<h2 class="text-[#111418] dark:text-white text-xl font-bold leading-tight tracking-[-0.015em]">User Management</h2>
		<div class="flex items-center justify-end gap-2">
			<!-- User creation button removed as requested -->
		</div>
	</div>
</div>
<main class="flex-1 w-full max-w-md mx-auto px-4 py-4 pb-24">
	<!-- Stats Section -->
	<section class="grid grid-cols-3 gap-3 mb-6">
		<div class="flex flex-col gap-1 rounded-xl bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 p-3 shadow-sm items-start">
			<p class="text-[#111418] dark:text-white text-2xl font-bold leading-tight">{{ $totalUsers }}</p>
			<p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Total Users</p>
		</div>
		<div class="flex flex-col gap-1 rounded-xl bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 p-3 shadow-sm items-start">
			<p class="text-primary text-2xl font-bold leading-tight">{{ $newUsers }}</p>
			<p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wider">New (Last 30d)</p>
		</div>
		<div class="flex flex-col gap-1 rounded-xl bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 p-3 shadow-sm items-start">
			<p class="text-orange-500 text-2xl font-bold leading-tight">{{ $pendingUsers }}</p>
			<p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Pending</p>
		</div>
	</section>
	<!-- Search Bar -->
	<section class="mb-4">
		<form method="GET" action="">
			<label class="relative flex w-full items-center">
				<div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-[#617589]">
					<span class="material-symbols-outlined">search</span>
				</div>
				<input name="search" value="{{ request('search') }}" class="form-input flex w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#1a2632] py-3 pl-12 pr-4 text-base text-[#111418] dark:text-white placeholder:text-[#617589] focus:border-primary focus:ring-1 focus:ring-primary shadow-sm" placeholder="Search by name, email, or building..." type="text"/>
			</label>
		</form>
	</section>
	<!-- Filter Chips -->
	<section class="flex gap-3 mb-6 overflow-x-auto pb-2 scrollbar-hide">
		<a href="?" class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full bg-[#111418] text-white px-5 shadow-md transition-transform active:scale-95 {{ !request('role') ? 'font-bold' : '' }}">
			<span class="text-sm font-medium">All Users</span>
		</a>
		<a href="?role=admin" class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white dark:bg-[#1a2632] border border-gray-200 dark:border-gray-700 px-5 text-[#111418] dark:text-white shadow-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors active:scale-95 {{ request('role')=='admin' ? 'font-bold text-primary' : '' }}">
			<span class="text-sm font-medium">Admins</span>
		</a>
		<a href="?role=tenant" class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white dark:bg-[#1a2632] border border-gray-200 dark:border-gray-700 px-5 text-[#111418] dark:text-white shadow-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors active:scale-95 {{ request('role')=='tenant' ? 'font-bold text-primary' : '' }}">
			<span class="text-sm font-medium">Tenants</span>
		</a>
		<a href="?role=manager" class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white dark:bg-[#1a2632] border border-gray-200 dark:border-gray-700 px-5 text-[#111418] dark:text-white shadow-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors active:scale-95 {{ request('role')=='manager' ? 'font-bold text-primary' : '' }}">
			<span class="text-sm font-medium">Managers</span>
		</a>
	</section>
	<!-- User List -->
	<section class="flex flex-col gap-4">
		@forelse($users as $user)
			<div class="flex items-center gap-3 rounded-xl bg-white dark:bg-[#1a2632] p-3 shadow-sm border border-gray-100 dark:border-gray-700">
				<div class="size-12 rounded-full bg-gray-200 overflow-hidden" data-alt="User profile avatar">
					<img alt="{{ $user->name }} Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=137fec&color=fff" />
				</div>
				<div class="flex flex-col flex-1 min-w-0">
					<p class="text-[#111418] dark:text-white text-base font-semibold truncate">{{ $user->name }}</p>
					<p class="text-[#617589] dark:text-gray-400 text-xs truncate">{{ $user->email }}</p>
					<p class="text-xs text-[#617589] dark:text-gray-400">{{ $user->role->name ?? 'User' }}</p>
				</div>
				<span class="px-3 py-1 rounded-full text-xs font-bold @if($user->status=='active') bg-green-100 text-green-700 @elseif($user->status=='pending') bg-yellow-100 text-yellow-700 @else bg-gray-100 text-gray-700 @endif">
					{{ ucfirst($user->status) }}
				</span>
			</div>
		@empty
			<div class="text-center text-gray-400 py-6">No users found.</div>
		@endforelse
	</section>
</main>
<!-- Spacer for content to not be hidden behind bottom nav -->
<div class="h-8"></div>
<!-- Bottom Navigation Bar -->
<div class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-[#192531] border-t border-gray-200 dark:border-gray-700 pb-safe pt-2 px-2 max-w-md mx-auto">
	<div class="flex items-center justify-around pb-2">
		<a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
			<span class="material-symbols-outlined group-hover:scale-110 transition-transform">dashboard</span>
			<span class="text-[10px] font-medium">Home</span>
		</a>
		<a href="{{ route('admin.building-management') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
			<span class="material-symbols-outlined group-hover:scale-110 transition-transform">apartment</span>
			<span class="text-[10px] font-medium">Buildings</span>
		</a>
		<a href="{{ route('users.index') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-primary group">
			<span class="material-symbols-outlined group-hover:scale-110 transition-transform filled" style="font-variation-settings: 'FILL' 1;">group</span>
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
@endsection
