@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto p-8 bg-white dark:bg-[#1a2632] rounded-2xl shadow-lg mt-10">
    <h2 class="text-3xl font-extrabold mb-6 text-[#111418] dark:text-white text-center">Subscription Details</h2>
    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 text-center font-semibold">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800 text-center font-semibold">{{ session('error') }}</div>
    @endif
    <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <div class="text-xs text-[#617589] dark:text-gray-400">Subscription ID</div>
            <div class="font-bold text-lg text-[#111418] dark:text-white">{{ $subscription->id }}</div>
        </div>
        <div>
            <div class="text-xs text-[#617589] dark:text-gray-400">Building</div>
            <div class="font-bold text-lg text-[#111418] dark:text-white">{{ $subscription->building->name ?? 'N/A' }}</div>
        </div>
        <div>
            <div class="text-xs text-[#617589] dark:text-gray-400">Plan</div>
            <div class="font-bold text-lg text-[#111418] dark:text-white">{{ $subscription->plan->name ?? 'N/A' }}</div>
        </div>
        <div>
            <div class="text-xs text-[#617589] dark:text-gray-400">Price</div>
            <div class="font-bold text-lg text-[#111418] dark:text-white">₹{{ number_format($subscription->plan->price ?? 0, 2) }}</div>
        </div>
        <div>
            <div class="text-xs text-[#617589] dark:text-gray-400">Billing Cycle</div>
            <div class="font-bold text-lg text-[#111418] dark:text-white">{{ ucfirst($subscription->plan->billing_cycle ?? 'N/A') }}</div>
        </div>
        <div>
            <div class="text-xs text-[#617589] dark:text-gray-400">Status</div>
            <span class="inline-block px-3 py-1 rounded-full font-semibold text-xs {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' : ($subscription->status === 'suspended' ? 'bg-red-100 text-red-800' : 'bg-gray-200 text-gray-700') }}">
                {{ ucfirst($subscription->status) }}
            </span>
        </div>
        <div>
            <div class="text-xs text-[#617589] dark:text-gray-400">Start Date</div>
            <div class="font-bold text-lg text-[#111418] dark:text-white">{{ $subscription->start_date ? $subscription->start_date->format('M d, Y') : 'N/A' }}</div>
        </div>
        <div>
            <div class="text-xs text-[#617589] dark:text-gray-400">Expiry Date</div>
            <div class="font-bold text-lg text-[#111418] dark:text-white">{{ $subscription->end_date ? $subscription->end_date->format('M d, Y') : 'N/A' }}</div>
        </div>
    </div>
    <div class="flex flex-col gap-6 mt-8">
        <h3 class="text-xl font-bold text-[#111418] dark:text-white mb-2 text-center">Admin Actions</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <form method="POST" action="{{ route('admin.subcription.activate', $subscription->id) }}" class="w-full">@csrf
                <button type="submit" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700 transition w-full shadow">
                    <span class="material-symbols-outlined">power_settings_new</span> Activate / Suspend
                </button>
            </form>
            <a href="{{ route('admin.subcription.extend.form', $subscription->id) }}" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-purple-600 text-white font-bold hover:bg-purple-700 transition w-full shadow">
                <span class="material-symbols-outlined">schedule</span> Extend Expiry Date
            </a>
            <a href="{{ route('admin.subcription.change-plan.form', $subscription->id) }}" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition w-full shadow">
                <span class="material-symbols-outlined">swap_horiz</span> Change Assigned Plan
            </a>
            <a href="{{ route('admin.subcription.view-payments', $subscription->id) }}" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition w-full shadow">
                <span class="material-symbols-outlined">receipt_long</span> View Payment History
            </a>
        </div>
        <a href="{{ route('admin.subcription') }}" class="mt-6 px-4 py-2 rounded-xl bg-gray-200 dark:bg-gray-700 text-[#111418] dark:text-white font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition w-full text-center">Back</a>
    </div>
</div>
@endsection
