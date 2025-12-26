@extends('layouts.app')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col max-w-md mx-auto bg-background-light dark:bg-background-dark group/design-root shadow-xl">
	<div class="sticky top-0 z-10 flex items-center bg-white dark:bg-[#1c2936] p-4 border-b border-[#e5e7eb] dark:border-[#2a3c4d]">
		<a href="{{ route('building-admin.invoices') }}" class="flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-[#111418] dark:text-white transition-colors">
			<span class="material-symbols-outlined">arrow_back</span>
		</a>
		<h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center pr-10">Invoice Details</h2>
	</div>
	<div class="flex-1 overflow-y-auto pb-24">
		<div class="px-4 flex flex-col gap-3 mt-4">
			<div class="flex flex-col gap-2 p-4 rounded-lg bg-white dark:bg-[#1c2936] border border-[#e5e7eb] dark:border-[#2a3c4d] shadow-sm">
				<div class="flex flex-wrap gap-4 justify-between">
					<div>
						<span class="text-xs text-[#617589] dark:text-gray-400">Invoice Number</span>
						<p class="text-[#111418] dark:text-white text-sm font-bold">{{ $invoice->invoice_number }}</p>
					</div>
					<div>
						<span class="text-xs text-[#617589] dark:text-gray-400">Invoice Date</span>
						<p class="text-[#111418] dark:text-white text-sm">{{ $invoice->issue_date->format('d M Y') }}</p>
					</div>
				</div>
				<div class="flex flex-wrap gap-4 justify-between">
					<div>
						<span class="text-xs text-[#617589] dark:text-gray-400">Building Name</span>
						<p class="text-[#111418] dark:text-white text-sm">{{ $invoice->building->name ?? '-' }}</p>
					</div>
					<div>
						<span class="text-xs text-[#617589] dark:text-gray-400">Plan Name</span>
						<p class="text-[#111418] dark:text-white text-sm">{{ $invoice->subscription->plan->name ?? '-' }}</p>
					</div>
				</div>
				<div class="flex flex-wrap gap-4 justify-between">
					<div>
						<span class="text-xs text-[#617589] dark:text-gray-400">Amount</span>
						<p class="text-[#111418] dark:text-white text-sm">₹{{ $invoice->amount }}</p>
					</div>
					<div>
						<span class="text-xs text-[#617589] dark:text-gray-400">Tax (GST)</span>
						<p class="text-[#111418] dark:text-white text-sm">₹{{ $invoice->meta['gst'] ?? '0.00' }}</p>
					</div>
					<div>
						<span class="text-xs text-[#617589] dark:text-gray-400">Total Amount</span>
						<p class="text-[#111418] dark:text-white text-sm font-bold">₹{{ number_format($invoice->amount + ($invoice->meta['gst'] ?? 0), 2) }}</p>
					</div>
				</div>
				<div class="flex flex-wrap gap-4 justify-between">
					<div>
						<span class="text-xs text-[#617589] dark:text-gray-400">Payment Transaction ID</span>
						<p class="text-[#111418] dark:text-white text-sm">{{ $invoice->meta['payment_transaction_id'] ?? '-' }}</p>
					</div>
					<div>
						<span class="text-xs text-[#617589] dark:text-gray-400">Payment Date</span>
						<p class="text-[#111418] dark:text-white text-sm">{{ $invoice->meta['payment_date'] ?? '-' }}</p>
					</div>
					<div>
						<span class="text-xs text-[#617589] dark:text-gray-400">Status</span>
						<p class="text-xs font-semibold {{ $invoice->status === 'paid' ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
							{{ ucfirst($invoice->status) }}
						</p>
					</div>
				</div>
				<div class="flex justify-end mt-4">
					<a href="{{ route('building-admin.invoice.download', $invoice->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg font-semibold shadow hover:bg-blue-600 transition-colors">
						<span class="material-symbols-outlined">download</span> Download PDF
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
