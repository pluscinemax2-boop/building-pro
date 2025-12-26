
@extends('layouts.app')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col max-w-md mx-auto bg-background-light dark:bg-background-dark group/design-root shadow-xl">
	<!-- TopAppBar -->
	<div class="sticky top-0 z-10 flex items-center bg-white dark:bg-[#1c2936] p-4 border-b border-[#e5e7eb] dark:border-[#2a3c4d]">
		<a href="{{ route('building-admin.dashboard') }}" class="flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-[#111418] dark:text-white transition-colors">
			<span class="material-symbols-outlined">arrow_back</span>
		</a>
		<h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center pr-10">Subscription &amp; Billing</h2>
	</div>
	<!-- Scrollable Content -->
	<div class="flex-1 overflow-y-auto pb-24">
		<!-- Current Plan Card -->
		<div class="p-4">
			<div class="relative flex flex-col gap-4 rounded-xl bg-white dark:bg-[#1c2936] p-5 shadow-sm border border-[#e5e7eb] dark:border-[#2a3c4d]">
				<!-- Header of Card -->
				<div class="flex items-start justify-between">
					<div class="flex flex-col gap-1">
						<div class="flex items-center gap-2">
							<span class="material-symbols-outlined text-primary" style="font-size: 20px;">diamond</span>
							<p class="text-[#111418] dark:text-white text-lg font-bold leading-tight">{{ $plan['name'] ?? 'No Active Plan' }}</p>
						</div>
					</div>
					<span class="inline-flex items-center rounded-full bg-green-50 dark:bg-green-900/30 px-2.5 py-1 text-xs font-bold text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800">
						{{ $plan['status'] ?? 'Inactive' }}
					</span>
				</div>
				<div class="flex items-baseline gap-1 mt-1">
					<span class="text-3xl font-bold text-[#111418] dark:text-white">₹{{ $plan['price'] ?? '-' }}</span>
					<span class="text-[#617589] dark:text-gray-400 text-sm">/ {{ $plan['billing_cycle'] ?? '-' }}</span>
				</div>
				<!-- ProgressBar Section -->
				<div class="flex flex-col gap-2 mt-2">
					<div class="flex gap-6 justify-between items-center">
						<p class="text-[#111418] dark:text-white text-sm font-medium leading-normal">{{ $plan['days_remaining'] ?? '-' }}</p>
						<span class="text-xs text-[#617589] dark:text-gray-400 font-medium">{{ $plan['usage_percent'] ?? '0%' }} used</span>
					</div>
					<div class="h-2 w-full rounded-full bg-[#f0f2f4] dark:bg-gray-700 overflow-hidden">
						<div class="h-full rounded-full bg-primary" style="width: {{ $plan['usage_percent'] ?? '0%' }};"></div>
					</div>
					<p class="text-[#617589] dark:text-gray-400 text-xs font-normal leading-normal text-right">Auto-renews on {{ $plan['renew_date'] ?? '-' }}</p>
				</div>
				<hr class="border-[#e5e7eb] dark:border-[#2a3c4d] my-1"/>
				<!-- DescriptionList Grid -->
				<div class="grid grid-cols-2 gap-y-4 gap-x-2">
					<div class="flex flex-col gap-1">
						<p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Start Date</p>
						<p class="text-[#111418] dark:text-white text-sm font-semibold">{{ $plan['start_date'] ?? '-' }}</p>
					</div>
					<div class="flex flex-col gap-1">
						<p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Expiry Date</p>
						<p class="text-[#111418] dark:text-white text-sm font-semibold">{{ $plan['expiry_date'] ?? '-' }}</p>
					</div>
					<div class="flex flex-col gap-1">
						<p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Billing Cycle</p>
						<p class="text-[#111418] dark:text-white text-sm font-semibold">{{ $plan['billing_cycle'] ?? '-' }}</p>
					</div>
					<div class="flex flex-col gap-1">
						<p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wide">Invoices</p>
						<a href="{{ route('building-admin.invoices') }}" class="text-primary text-sm font-semibold hover:underline">View Invoices</a>
					</div>
				</div>
				<!-- Features List -->
				@if(!empty($plan['features']))
				<div class="flex flex-col gap-2 pt-2 border-t border-[#f0f2f4] dark:border-[#2a3c4d]">
					@foreach($plan['features'] as $feature)
						<div class="text-[13px] font-medium leading-normal flex gap-3 text-[#3d4d5c] dark:text-[#cbd5e1]">
							<span class="material-symbols-outlined text-primary text-[18px]">check_circle</span>
							{{ $feature }}
						</div>
					@endforeach
				</div>
				@endif
			</div>
		</div>
		<!-- Action Buttons -->
		<div class="flex flex-col gap-3 px-4">
			       <a href="{{ url('/building-admin/subscription/setup?renew=1') }}" class="flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 px-5 bg-primary hover:bg-blue-600 transition-colors text-white text-base font-bold leading-normal tracking-[0.015em] shadow-lg shadow-blue-500/20">
				       <span class="truncate">Renew Subscription</span>
			       </a>
			<a href="{{ url('/building-admin/subscription/setup?upgrade=1') }}" class="flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 px-5 bg-transparent border border-primary text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors text-base font-bold leading-normal tracking-[0.015em]">
				<span class="truncate">Upgrade Plan</span>
			</a>
		</div>
		<!-- Payment History Header -->
		<div class="mt-8 px-4 flex justify-between items-end mb-2">
			<h3 class="text-[#111418] dark:text-white text-lg font-bold leading-tight">Payment History</h3>
			<a class="text-primary text-sm font-semibold hover:underline" href="{{ route('building-admin.payment-history') }}">View All</a>
		</div>
		<!-- Payment History List -->
		<div class="px-4 flex flex-col gap-3">
			@forelse($payments as $payment)
				<div class="flex items-center justify-between p-3 rounded-lg bg-white dark:bg-[#1c2936] border border-[#e5e7eb] dark:border-[#2a3c4d] shadow-sm">
					<div class="flex items-center gap-3">
						<div class="flex items-center justify-center size-10 rounded-full bg-blue-50 dark:bg-blue-900/30 text-primary">
							<span class="material-symbols-outlined" style="font-size: 20px;">receipt_long</span>
						</div>
						<div class="flex flex-col">
							<p class="text-[#111418] dark:text-white text-sm font-bold">{{ $payment->title }}</p>
							<p class="text-[#617589] dark:text-gray-400 text-xs">Paid on {{ $payment->paid_on }}</p>
						</div>
					</div>
					<div class="flex flex-col items-end gap-1">
						<p class="text-[#111418] dark:text-white text-sm font-bold">₹{{ $payment->amount }}</p>
						@if($payment->status === 'success')
							<div class="flex items-center gap-1 text-green-600 dark:text-green-400 text-xs font-medium bg-green-50 dark:bg-green-900/20 px-1.5 py-0.5 rounded">
								<span class="material-symbols-outlined" style="font-size: 12px;">check_circle</span>
								Paid
							</div>
						@elseif($payment->status === 'pending')
							<div class="flex items-center gap-1 text-yellow-600 dark:text-yellow-400 text-xs font-medium bg-yellow-50 dark:bg-yellow-900/20 px-1.5 py-0.5 rounded">
								<span class="material-symbols-outlined" style="font-size: 12px;">hourglass_empty</span>
								Pending
							</div>
						@else
							<div class="flex items-center gap-1 text-red-600 dark:text-red-400 text-xs font-medium bg-red-50 dark:bg-red-900/20 px-1.5 py-0.5 rounded">
								<span class="material-symbols-outlined" style="font-size: 12px;">cancel</span>
								Failed
							</div>
						@endif
					</div>
				</div>
			@empty
				<p class="text-[#617589] dark:text-gray-400 text-sm">No payment history found.</p>
			@endforelse
		</div>
		<!-- Support Link -->
		<div class="p-6 flex justify-center">
			<button class="flex items-center gap-2 text-[#617589] dark:text-gray-400 text-sm font-medium hover:text-primary transition-colors">
				<span class="material-symbols-outlined" style="font-size: 18px;">help</span>
				Need help with billing?
			</button>
		</div>
	</div>
</div>
@endsection
