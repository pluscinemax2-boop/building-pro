
@extends('layouts.app')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col max-w-md mx-auto bg-background-light dark:bg-background-dark group/design-root shadow-xl">
	<div class="sticky top-0 z-10 flex items-center bg-white dark:bg-[#1c2936] p-4 border-b border-[#e5e7eb] dark:border-[#2a3c4d]">
		<a href="{{ route('building-admin.subscription') }}" class="flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-[#111418] dark:text-white transition-colors">
			<span class="material-symbols-outlined">arrow_back</span>
		</a>
		<h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center pr-10">Payment History</h2>
	</div>
	<div class="flex-1 overflow-y-auto pb-24">
		<div class="px-4 flex flex-col gap-3 mt-4">
			@forelse($payments as $payment)
				<div class="flex flex-col gap-1 p-3 rounded-lg bg-white dark:bg-[#1c2936] border border-[#e5e7eb] dark:border-[#2a3c4d] shadow-sm">
					<div class="flex items-center gap-3">
						<div class="flex items-center justify-center size-10 rounded-full bg-blue-50 dark:bg-blue-900/30 text-primary">
							<span class="material-symbols-outlined" style="font-size: 20px;">receipt_long</span>
						</div>
						<div class="flex flex-col">
							<p class="text-[#111418] dark:text-white text-sm font-bold">{{ $payment->title ?? ($payment->subscription->plan->name ?? 'Subscription Payment') }}</p>
							<p class="text-[#617589] dark:text-gray-400 text-xs">Paid on {{ $payment->created_at->format('d M Y, h:i A') }}</p>
						</div>
					</div>
					<div class="grid grid-cols-2 gap-2 mt-2">
						<div>
							<span class="text-xs text-[#617589] dark:text-gray-400">Amount</span>
							<p class="text-[#111418] dark:text-white text-sm font-bold">₹{{ $payment->amount }}</p>
						</div>
						<div>
							<span class="text-xs text-[#617589] dark:text-gray-400">Status</span>
							@if($payment->status === 'success')
								<p class="text-xs font-semibold text-green-600 dark:text-green-400 flex items-center gap-1">
									<span class="material-symbols-outlined" style="font-size: 14px;">check_circle</span> Paid
								</p>
							@elseif($payment->status === 'pending')
								<p class="text-xs font-semibold text-yellow-600 dark:text-yellow-400 flex items-center gap-1">
									<span class="material-symbols-outlined" style="font-size: 14px;">hourglass_empty</span> Pending
								</p>
							@else
								<p class="text-xs font-semibold text-red-600 dark:text-red-400 flex items-center gap-1">
									<span class="material-symbols-outlined" style="font-size: 14px;">cancel</span> Failed
								</p>
							@endif
						</div>
						<div>
							<span class="text-xs text-[#617589] dark:text-gray-400">Gateway</span>
							<p class="text-[#111418] dark:text-white text-xs">{{ $payment->gateway ?? '-' }}</p>
						</div>
						<div>
							<span class="text-xs text-[#617589] dark:text-gray-400">Transaction ID</span>
							<p class="text-[#111418] dark:text-white text-xs">{{ $payment->gateway_payment_id ?? '-' }}</p>
						</div>
						<div class="col-span-2 flex justify-end mt-2">
							@php
								$invoice = \App\Models\Invoice::where('subscription_id', $payment->subscription_id)
									->where('building_id', $payment->building_id)
									->orderByDesc('issue_date')
									->first();
							@endphp
							@if($invoice)
								<a href="{{ route('building-admin.invoice.view', $invoice->id) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-primary text-white rounded text-xs font-semibold hover:bg-blue-600 transition-colors">
									<span class="material-symbols-outlined" style="font-size: 16px;">visibility</span> View Invoice
								</a>
							@endif
						</div>
					</div>
				</div>
			@empty
				<p class="text-[#617589] dark:text-gray-400 text-sm">No payment history found.</p>
			@endforelse
		</div>
	</div>
</div>
@endsection
