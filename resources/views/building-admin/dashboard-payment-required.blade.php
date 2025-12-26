@extends('layouts.app')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col max-w-md mx-auto bg-background-light dark:bg-background-dark group/design-root shadow-xl">
	<!-- TopAppBar -->
	<div class="sticky top-0 z-10 flex items-center bg-white dark:bg-[#1c2936] p-4 border-b border-[#e5e7eb] dark:border-[#2a3c4d]">
		<h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">Dashboard</h2>
	</div>
	<div class="flex-1 overflow-y-auto pb-24 flex flex-col items-center justify-center">
		<div class="max-w-sm w-full bg-white dark:bg-[#1c2936] rounded-xl shadow p-6 mt-12 flex flex-col items-center">
			<span class="material-symbols-outlined text-primary text-5xl mb-2">lock</span>
			<h3 class="text-xl font-bold text-[#111418] dark:text-white mb-2 text-center">Subscription Required</h3>
			<p class="text-[#617589] dark:text-gray-400 text-center mb-4">To access all dashboard features, please upgrade your plan.</p>
			<a href="{{ route('building-admin.subscription.setup', ['upgrade' => 1]) }}" class="w-full flex items-center justify-center rounded-xl h-12 px-5 bg-primary hover:bg-blue-600 transition-colors text-white text-base font-bold leading-normal tracking-[0.015em] shadow-lg shadow-blue-500/20">
				<span class="truncate">Upgrade Plan</span>
			</a>
		</div>
	</div>
	<!-- Disable navigation buttons with overlay -->
	<div class="fixed inset-0 pointer-events-none z-50">
		<div class="absolute inset-0 bg-black bg-opacity-10"></div>
	</div>
</div>
@endsection
