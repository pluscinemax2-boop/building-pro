@extends('layouts.app')
@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col overflow-hidden bg-[#f6f7f8]">
	<!-- Top App Bar -->
	<!-- TopAppBar -->
	<header class="sticky top-0 z-10 bg-white dark:bg-[#1a2632] shadow-sm">
		<div class="flex items-center px-4 py-3 justify-between">
			   <a href="{{ route('dashboard') }}" class="flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
				<span class="material-symbols-outlined text-[#111418] dark:text-white">arrow_back</span>
			</a>
			<h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">Subscription Plans</h2>
		</div>
	</header>
	<!-- Main Content Area -->
	<main class="flex-1 overflow-y-auto no-scrollbar p-4 flex flex-col gap-4">
        <!-- Tab Bar -->
		<section class="w-full">
			<div class="flex border-b border-[#dbe0e6] dark:border-gray-700 mb-2">
				   <a href="?tab=subscription" class="flex-1 flex flex-col items-center justify-center border-b-2 {{ request('tab') == 'subscription' ? 'border-primary text-primary' : 'border-transparent text-[#617589] dark:text-gray-400' }} pb-2 pt-2 hover:text-primary transition-colors">
					   <span class="material-symbols-outlined">credit_card</span>
					   <span class="text-xs font-bold">Subscription</span>
				   </a>
				   <a href="?tab=plan" class="flex-1 flex flex-col items-center justify-center border-b-2 {{ request('tab') == 'plan' ? 'border-primary text-primary' : 'border-transparent text-[#617589] dark:text-gray-400' }} pb-2 pt-2 hover:text-primary transition-colors">
					   <span class="material-symbols-outlined">dns</span>
					   <span class="text-xs font-bold">Subscription Plan</span>
				   </a>
			</div>
		</section>
		<!-- Summary Stats (Dynamic) -->
		<div class="grid grid-cols-2 gap-3 mb-2">
			<div class="bg-white p-3 rounded-xl border border-[#e5e7eb] flex flex-col shadow-sm">
				<span class="text-[#637588] text-xs font-medium">Total Plans</span>
				<span class="text-[#111418] text-xl font-bold">{{ isset($plans) ? count($plans) : 0 }}</span>
			</div>
			<div class="bg-white p-3 rounded-xl border border-[#e5e7eb] flex flex-col shadow-sm">
				<span class="text-[#637588] text-xs font-medium">Active Plans</span>
				<span class="text-green-600 text-xl font-bold">{{ isset($activePlansCount) ? $activePlansCount : (isset($plans) ? collect($plans)->where('is_active', true)->count() : 0) }}</span>
			</div>
		</div>
		   <!-- Plan List -->
		   <div class="flex flex-col gap-4">
			   @forelse($plans as $plan)
				   <div class="flex flex-col gap-4 rounded-xl border border-[#dbe0e6] dark:border-[#2a3642] bg-white dark:bg-[#1a2632] p-5 shadow-sm transition-all hover:shadow-md relative">
					   @if(!empty($plan->highlight))
					   <div class="absolute top-0 right-0 bg-primary text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg">
						   {{ $plan->highlight }}
					   </div>
					   @endif
					   <div class="flex flex-col gap-1">
						   <div class="flex items-center justify-between">
							   <h1 class="text-[#111418] dark:text-white text-lg font-bold leading-tight">{{ $plan->name }}</h1>
							   <span class="text-green-700 bg-green-100 dark:text-green-300 dark:bg-green-900/30 text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-full">
								   {{ $plan->is_active ? 'Active' : 'Inactive' }}
							   </span>
						   </div>
						   <div class="flex items-baseline gap-1 mt-1">
							   <span class="text-[#111418] dark:text-white text-3xl font-black leading-tight tracking-[-0.033em]">₹{{ number_format($plan->price,2) }}</span>
							   <span class="text-[#637588] dark:text-[#9ca3af] text-sm font-medium">/{{ $plan->billing_cycle }}</span>
						   </div>
					   </div>
					   <!-- Key Metric: Max Flats -->
					   <div class="flex items-center gap-2 bg-[#f0f4f8] dark:bg-[#232d38] p-2 rounded-lg">
						   <span class="material-symbols-outlined text-primary text-[20px]">apartment</span>
						   <span class="text-[#111418] dark:text-white text-sm font-semibold">Max {{ $plan->max_flats ?? 'Unlimited' }} Flats</span>
					   </div>
					   <!-- Features List -->
					   <div class="flex flex-col gap-2 pt-2 border-t border-[#f0f2f4] dark:border-[#2a3642]">
						   @foreach($plan->features ?? [] as $feature)
						   <div class="text-[13px] font-medium leading-normal flex gap-3 text-[#3d4d5c] dark:text-[#cbd5e1]">
							   <span class="material-symbols-outlined text-primary text-[18px]">check_circle</span>
							   {{ $feature }}
						   </div>
						   @endforeach
					   </div>
					   <div class="flex gap-3 pt-2">
						   <a href="{{ route('admin.subcription-plan.edit', $plan->id) }}" class="flex-1 flex items-center justify-center h-10 px-4 bg-[#f0f2f4] dark:bg-[#2a3642] hover:bg-[#e2e6ea] dark:hover:bg-[#364152] text-[#111418] dark:text-white rounded-lg text-sm font-bold transition-colors">Edit Plan</a>
					   </div>
				   </div>
			   @empty
				   <div class="text-center text-gray-400 py-6">No plans found.</div>
			   @endforelse
			   <!-- Bottom Spacer for FAB -->
			   <div class="h-20"></div>
		   </div>
	</main>
	<!-- FAB: Floating Action Button -->
	<div class="fixed bottom-[84px] right-5 z-30">
		<a href="{{ route('admin.subcription-plan.create') }}" class="flex items-center justify-center rounded-full h-14 w-14 bg-primary text-white shadow-lg shadow-primary/40 hover:bg-primary/90 transition-all hover:scale-105 active:scale-95">
			<span class="material-symbols-outlined text-[28px]">add</span>
		</a>
	</div>
</div>
<!-- Material Symbols font link (add to your main layout if not present) -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<!-- Tailwind CDN (add to your main layout if not present) -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
@endsection
