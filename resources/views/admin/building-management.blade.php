
@extends('layouts.app')
@section('content')
<div class="relative flex flex-col w-full h-screen max-w-md mx-auto bg-background-light dark:bg-background-dark shadow-2xl overflow-hidden border-x border-gray-100 dark:border-gray-800">
	<!-- Top App Bar -->
	<header class="shrink-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md pt-5 pb-3 px-5 border-b border-gray-200/50 dark:border-gray-800">
		<div class="flex items-center justify-between">
			<div>
				<h1 class="text-2xl font-bold tracking-tight text-[#111418] dark:text-white">Buildings</h1>
				<p class="text-sm text-[#617589] dark:text-gray-400 font-medium">Overview of properties</p>
			</div>
			<a href="{{ route('buildings.create') }}" class="flex items-center justify-center w-11 h-11 rounded-full bg-primary text-white shadow-lg hover:bg-blue-600 active:scale-95 transition-all">
				<span class="material-symbols-outlined" style="font-size: 26px;">add</span>
			</a>
		</div>
	</header>
	<!-- Main Content Scroll Area -->
	<div class="flex-1 overflow-y-auto no-scrollbar pb-24">
		<!-- Search Section -->
		<div class="px-5 pt-4 pb-2 sticky top-0 z-10 bg-background-light dark:bg-background-dark">
			<form method="GET" action="" class="relative flex items-center w-full h-12 rounded-xl focus-within:ring-2 ring-primary/20 transition-all bg-white dark:bg-[#1e293b] shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
				<div class="grid place-items-center h-full w-12 text-[#617589]">
					<span class="material-symbols-outlined">search</span>
				</div>
				<input name="search" value="{{ request('search') }}" class="peer h-full w-full outline-none text-[15px] text-gray-700 dark:text-gray-200 pr-4 bg-transparent placeholder-gray-400 font-normal" placeholder="Search buildings, admins..." type="text"/>
			</form>
		</div>
		<!-- Filters (Chips) -->
		<div class="flex gap-2 px-5 py-2 overflow-x-auto no-scrollbar mask-linear-fade">
			<a href="?" class="flex h-9 shrink-0 items-center justify-center rounded-full bg-[#111418] dark:bg-white px-5 transition-transform active:scale-95 shadow-sm {{ !request('status') ? 'text-white' : '' }}">
				<p class="text-white dark:text-[#111418] text-sm font-medium">All</p>
			</a>
			<a href="?status=active" class="flex h-9 shrink-0 items-center justify-center rounded-full bg-white dark:bg-[#1e293b] border border-gray-200 dark:border-gray-700 px-5 transition-transform active:scale-95 {{ request('status')=='active' ? 'text-primary font-bold' : '' }}">
				<p class="text-[#617589] dark:text-gray-300 text-sm font-medium">Active</p>
			</a>
			<a href="?status=inactive" class="flex h-9 shrink-0 items-center justify-center rounded-full bg-white dark:bg-[#1e293b] border border-gray-200 dark:border-gray-700 px-5 transition-transform active:scale-95 {{ request('status')=='inactive' ? 'text-primary font-bold' : '' }}">
				<p class="text-[#617589] dark:text-gray-300 text-sm font-medium">Inactive</p>
			</a>
			<a href="?status=premium" class="flex h-9 shrink-0 items-center justify-center rounded-full bg-white dark:bg-[#1e293b] border border-gray-200 dark:border-gray-700 px-5 transition-transform active:scale-95 {{ request('status')=='premium' ? 'text-primary font-bold' : '' }}">
				<p class="text-[#617589] dark:text-gray-300 text-sm font-medium">Premium</p>
			</a>
		</div>
		<!-- Building List Cards -->
		<div class="flex flex-col gap-4 p-5 pt-3">
			@forelse($buildings as $building)
				<div class="group relative flex flex-col gap-3 rounded-2xl bg-white dark:bg-[#1e293b] p-3 shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-gray-100 dark:border-gray-800 transition-all active:scale-[0.99]">
					<div class="flex items-start gap-3">
						<div class="h-[84px] w-[84px] shrink-0 overflow-hidden rounded-xl bg-gray-100 relative">
							<div class="h-full w-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110" data-alt="{{ $building->name }}" style="background-image: url('{{ $building->image_url ?? 'https://via.placeholder.com/84x84?text=Building' }}');"></div>
							<div class="absolute inset-0 bg-black/5 dark:bg-black/20"></div>
						</div>
						<div class="flex flex-1 flex-col justify-between h-[84px] py-0.5">
							<div>
								<h2 class="text-lg font-bold text-[#111418] dark:text-white">{{ $building->name }}</h2>
								<p class="text-xs text-[#617589] dark:text-gray-400">{{ $building->address }}</p>
							</div>
							<div class="flex gap-2 mt-1">
								<span class="inline-flex items-center gap-1 text-xs text-primary font-bold"><span class="material-symbols-outlined text-base">apartment</span>{{ $building->total_flats }} Flats</span>
								<span class="inline-flex items-center gap-1 text-xs text-[#617589] dark:text-gray-400"><span class="material-symbols-outlined text-base">person</span>{{ $building->admin->name ?? 'No Admin' }}</span>
							</div>
						</div>
					</div>
					<div class="flex items-center justify-between mt-2">
						<span class="px-3 py-1 rounded-full text-xs font-bold @if($building->status=='active') bg-green-100 text-green-700 @elseif($building->status=='inactive') bg-gray-100 text-gray-700 @else bg-yellow-100 text-yellow-700 @endif">
							{{ ucfirst($building->status) }}
						</span>
						<a href="{{ route('buildings.edit', $building->id) }}" class="flex items-center gap-1 text-primary text-xs font-medium hover:underline">
							<span class="material-symbols-outlined text-base">edit</span>Edit
						</a>
					</div>
				</div>
			@empty
				<div class="text-center text-gray-400 py-6">No buildings found.</div>
			@endforelse
		</div>
	</div>
	<!-- Spacer for content to not be hidden behind bottom nav -->
	<div class="h-8"></div>
</div>
<!-- Bottom Navigation Bar -->
<div class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-[#192531] border-t border-gray-200 dark:border-gray-700 pb-safe pt-2 px-2 max-w-md mx-auto">
	<div class="flex items-center justify-around pb-2">
		<a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
			<span class="material-symbols-outlined group-hover:scale-110 transition-transform">dashboard</span>
			<span class="text-[10px] font-medium">Home</span>
		</a>
		<a href="{{ route('admin.building-management') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-primary group">
			<span class="material-symbols-outlined group-hover:scale-110 transition-transform filled" style="font-variation-settings: 'FILL' 1;">apartment</span>
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
@endsection
