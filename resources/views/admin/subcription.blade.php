@extends('layouts.app')
@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col overflow-x-hidden">
	<!-- TopAppBar -->
	<header class="sticky top-0 z-10 bg-white dark:bg-[#1a2632] shadow-sm">
		<div class="flex items-center px-4 py-3 justify-between">
			   <a href="{{ route('dashboard') }}" class="flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
				<span class="material-symbols-outlined text-[#111418] dark:text-white">arrow_back</span>
			</a>
			<h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">Subscriptions</h2>
		</div>
	</header>
	<!-- Main Content -->
	<main class="flex-1 flex flex-col gap-4 p-4 pb-24">
		<!-- Tab Bar -->
		<section class="w-full">
			<div class="flex border-b border-[#dbe0e6] dark:border-gray-700 mb-2">
				   <a href="?tab=subscription" class="flex-1 flex flex-col items-center justify-center border-b-2 {{ request('tab') == 'subscription' || !request('tab') ? 'border-primary text-primary' : 'border-transparent text-[#617589] dark:text-gray-400' }} pb-2 pt-2 hover:text-primary transition-colors">
					   <span class="material-symbols-outlined">credit_card</span>
					   <span class="text-xs font-bold">Subscription</span>
				   </a>
				   <a href="?tab=plan" class="flex-1 flex flex-col items-center justify-center border-b-2 {{ request('tab') == 'plan' ? 'border-primary text-primary' : 'border-transparent text-[#617589] dark:text-gray-400' }} pb-2 pt-2 hover:text-primary transition-colors">
					   <span class="material-symbols-outlined">dns</span>
					   <span class="text-xs font-bold">Subscription Plan</span>
				   </a>
			</div>
		</section>
		<!-- Tab Content -->
		<section class="flex flex-col gap-3 mt-4">
			   @if(request('tab') == 'plan')
				   @include('admin.subcription-plan')
			   @elseif(request('tab') == 'billing')
				   @include('admin.billing')
			   @else
				<!-- Search Bar -->
				<section class="mb-2">
					<form method="GET" class="flex flex-col h-12 w-full">
						<input type="hidden" name="tab" value="subscription" />
						<div class="flex w-full flex-1 items-stretch rounded-xl h-full shadow-sm">
							<div class="text-[#617589] dark:text-gray-400 flex border-none bg-white dark:bg-[#1a2632] items-center justify-center pl-4 rounded-l-xl border-r-0">
								<span class="material-symbols-outlined">search</span>
							</div>
							<input name="search" value="{{ request('search','') }}" class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white focus:outline-0 focus:ring-0 border-none bg-white dark:bg-[#1a2632] focus:border-none h-full placeholder:text-[#617589] dark:placeholder:text-gray-500 px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal" placeholder="Search by Building or ID..." />
						</div>
					</form>
				</section>
				<!-- Filter Chips -->
				<section class="w-full overflow-x-auto no-scrollbar mb-2">
					<div class="flex gap-3 min-w-max">
						@php $status = request('status','all'); @endphp
						<a href="?tab=subscription" class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full {{ $status=='all' ? 'bg-[#111418] dark:bg-primary text-white' : 'bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#111418] dark:text-white' }} px-5 transition-colors">All</a>
						<a href="?tab=subscription&status=active" class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full {{ $status=='active' ? 'bg-[#111418] dark:bg-primary text-white' : 'bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#111418] dark:text-white' }} px-5 transition-colors">Active</a>
						<a href="?tab=subscription&status=expired" class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full {{ $status=='expired' ? 'bg-[#111418] dark:bg-primary text-white' : 'bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#111418] dark:text-white' }} px-5 transition-colors">Expired</a>
						<a href="?tab=subscription&status=pending" class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full {{ $status=='pending' ? 'bg-[#111418] dark:bg-primary text-white' : 'bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#111418] dark:text-white' }} px-5 transition-colors">Pending</a>
					</div>
				</section>
				<!-- Subscription List -->
				<h3 class="text-[#111418] dark:text-white text-base font-bold leading-normal px-1">Buildings</h3>
				@php
					$filtered = $subscriptions;
					if(request('search')) {
						$filtered = $filtered->filter(function($s) {
							$search = strtolower(request('search'));
							return str_contains(strtolower($s->building->name ?? ''), $search) || str_contains((string)($s->building->id ?? ''), $search);
						});
					}
					if($status !== 'all') {
						$filtered = $filtered->where('status', $status);
					}
				@endphp
				@forelse($filtered as $subscription)
					<div class="flex flex-col gap-3 bg-white dark:bg-[#1a2632] px-4 py-4 rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700">
						<div class="flex justify-between items-start">
							<div class="flex flex-col gap-1">
								<p class="text-[#111418] dark:text-white text-base font-bold leading-tight">{{ $subscription->building->name ?? 'Building' }}</p>
								<p class="text-[#617589] dark:text-gray-400 text-sm font-normal">{{ $subscription->plan->name ?? 'Plan' }}</p>
							</div>
							@php
								$badge = [
									'active' => ['bg' => 'bg-green-50 dark:bg-green-900/30', 'text' => 'text-green-700 dark:text-green-400', 'dot' => 'bg-green-700 dark:bg-green-400', 'label' => 'Active'],
									'expired' => ['bg' => 'bg-red-50 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-400', 'dot' => 'bg-red-700 dark:bg-red-400', 'label' => 'Expired'],
									'pending' => ['bg' => 'bg-gray-100 dark:bg-gray-700', 'text' => 'text-gray-700 dark:text-gray-300', 'dot' => 'bg-gray-500 dark:bg-gray-400', 'label' => 'Pending'],
									'expiring' => ['bg' => 'bg-yellow-50 dark:bg-yellow-900/30', 'text' => 'text-yellow-700 dark:text-yellow-400', 'dot' => 'bg-yellow-700 dark:bg-yellow-400', 'label' => 'Expiring'],
								];
								$b = $badge[$subscription->status] ?? $badge['pending'];
							@endphp
							<span class="inline-flex items-center gap-1 rounded-full {{ $b['bg'] }} px-2 py-1 text-xs font-semibold {{ $b['text'] }}">
								<span class="size-1.5 rounded-full {{ $b['dot'] }}"></span>
								{{ $b['label'] }}
							</span>
						</div>
						<div class="h-px bg-[#f0f2f4] dark:bg-gray-700 w-full"></div>
						<div class="flex justify-between items-center">
							<div class="flex items-center gap-2 text-[#617589] dark:text-gray-400">
								@if($subscription->status=='active')
									<span class="material-symbols-outlined text-lg">calendar_today</span>
									<p class="text-sm font-medium">Expires {{ $subscription->end_date->format('M d, Y') }}</p>
								@elseif($subscription->status=='expired')
									<span class="material-symbols-outlined text-lg">event_busy</span>
									<p class="text-sm font-medium">Ended {{ $subscription->end_date->format('M d, Y') }}</p>
								@elseif($subscription->status=='pending')
									<span class="material-symbols-outlined text-lg">hourglass_empty</span>
									<p class="text-sm font-medium">Awaiting Payment</p>
								@elseif($subscription->status=='expiring')
									<span class="material-symbols-outlined text-lg">warning</span>
									<p class="text-sm font-medium">In {{ $subscription->end_date->diffInDays(now()) }} Days</p>
								@endif
							</div>
							@if($subscription->status=='active' || $subscription->status=='expiring')
								<a href="{{ route('admin.subcription.manage', $subscription->id) }}" class="text-primary hover:text-blue-700 text-sm font-bold flex items-center gap-1">Manage <span class="material-symbols-outlined text-lg">chevron_right</span></a>
							@elseif($subscription->status=='expired')
								<a href="{{ route('admin.subcription.manage', $subscription->id) }}" class="text-primary hover:text-blue-700 text-sm font-bold flex items-center gap-1">Renew <span class="material-symbols-outlined text-lg">chevron_right</span></a>
							@else
								<a href="{{ route('admin.subcription.manage', $subscription->id) }}" class="text-primary hover:text-blue-700 text-sm font-bold flex items-center gap-1">Details <span class="material-symbols-outlined text-lg">chevron_right</span></a>
							@endif
						</div>
					</div>
				@empty
					<div class="text-center text-gray-400 py-6">No subscriptions found.</div>
				@endforelse
				
			@endif
		</section>
	</main>
</div>
@endsection
