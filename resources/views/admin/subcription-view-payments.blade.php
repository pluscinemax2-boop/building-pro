@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-[#1a2632] rounded-xl shadow-md mt-8">
    <h2 class="text-2xl font-bold mb-4 text-[#111418] dark:text-white">View Payment History</h2>
    <p class="mb-4 text-gray-600 dark:text-gray-300">Subscription ID: {{ $subscriptionId }}</p>
    <div class="overflow-x-auto rounded-xl shadow border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#1a2632]">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-[#22303c]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Gateway</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Txn ID</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-[#1a2632] divide-y divide-gray-100 dark:divide-gray-800">
                @foreach(\App\Models\Payment::where('subscription_id', $subscriptionId)->latest()->with(['user'])->get() as $payment)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $payment->user->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-700 dark:text-green-300 font-bold">₹{{ number_format($payment->amount,2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ ucfirst($payment->gateway) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($payment->isSuccessful())
                            <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 text-xs font-bold">Success</span>
                        @elseif($payment->isPending())
                            <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 text-xs font-bold">Pending</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 text-xs font-bold">Failed</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">{{ $payment->gateway_payment_id }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-[#111418] dark:text-white font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition">Back</a>
    </div>
</div>
@endsection
