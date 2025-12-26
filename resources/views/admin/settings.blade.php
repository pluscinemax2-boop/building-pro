@extends('layouts.app')
@section('content')
<div class="w-full max-w-md bg-background-light dark:bg-background-dark relative flex flex-col h-full min-h-screen overflow-x-hidden pb-24 shadow-xl">
	<!-- Header Section -->
	<div class="px-4 py-5 bg-white dark:bg-[#101922] sticky top-0 z-10 shadow-sm border-b border-gray-100 dark:border-gray-800">
		<div class="flex items-center justify-between">
			<div class="flex items-center gap-3">
				<div class="bg-center bg-no-repeat bg-cover rounded-full h-10 w-10 ring-2 ring-primary/10" data-alt="Portrait of the Super Admin user" style='background-image: url("{{ Auth::user()->avatar_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAcYeXuLyMrwndkpOZkLl7jegOHzvA6WfxHdxEOQQxZdyI6UEvGYVjcPydGpUgyGibGBDTW_M0zRyY2429Xe_4iqGhvseN6UwoG6bn8zZkBsTOH1Nxkk8Sgn0xxBOCMc8Jqrl0R-DUrOplefgF6vR6i1paX2iGeAzmhPC-lv5JJgqOiz06WFKNbjMwIQravrEvN1CxuVJgpqRun0pFZ2HFy3rxHQsEkW54CJfMMl4BIGdMzzPKByOJwjIV-xykHmdBgq25ZWD6KDcV' }}");'>
				</div>
				<div class="flex flex-col">
					<p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Welcome Back</p>
					<h1 class="text-[#111418] dark:text-white text-lg font-bold leading-tight">Super Admin</h1>
				</div>
			</div>
			<button class="relative flex items-center justify-center w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
				<span class="material-symbols-outlined text-[#111418] dark:text-white" style="font-size: 24px;">notifications</span>
				<span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-[#101922]"></span>
			</button>
		</div>
	</div>
	<!-- Search Bar -->
	<div class="px-4 pt-6 pb-2">
		<label class="flex flex-col w-full">
			<div class="flex w-full items-center rounded-xl h-12 bg-white dark:bg-[#192531] shadow-sm border border-gray-100 dark:border-gray-700 transition-all focus-within:ring-2 focus-within:ring-primary/20">
				<div class="pl-4 flex items-center justify-center text-[#617589] dark:text-gray-400">
					<span class="material-symbols-outlined" style="font-size: 20px;">search</span>
				</div>
				<input class="w-full bg-transparent border-none focus:ring-0 text-[#111418] dark:text-white placeholder:text-[#9aa2ac] h-full px-3 text-sm font-medium" placeholder="Search buildings, users, or reports..."/>
			</div>
		</label>
	</div>
	<!-- Main Content Placeholder -->
	<div class="flex-1"></div>
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
			<a href="{{ route('users.index') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
				<span class="material-symbols-outlined group-hover:scale-110 transition-transform">group</span>
				<span class="text-[10px] font-medium">Users</span>
			</a>
			<a href="{{ route('reports.index') }}" class="flex flex-col items-center justify-center w-full gap-1 p-2 text-[#617589] dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors group">
				<span class="material-symbols-outlined group-hover:scale-110 transition-transform">bar_chart</span>
				<span class="text-[10px] font-medium">Reports</span>
			</a>

</div>
@endsection
