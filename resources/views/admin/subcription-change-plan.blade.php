@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto p-8 bg-white dark:bg-[#1a2632] rounded-2xl shadow-lg mt-10">
    <h2 class="text-2xl font-bold mb-6 text-[#111418] dark:text-white text-center">Change Assigned Plan</h2>
    <form method="POST" action="{{ route('admin.subcription.change-plan', $subscription->id) }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select New Plan</label>
            <select name="plan_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-800 dark:text-white" required>
                <option value="">-- Select Plan --</option>
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" @if($plan->id == $subscription->plan_id) selected @endif>{{ $plan->name }} (₹{{ number_format($plan->price, 2) }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="w-full px-4 py-2 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition">Update Plan</button>
    </form>
    <div class="mt-6 text-center">
        <a href="{{ route('admin.subcription.manage', $subscription->id) }}" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-[#111418] dark:text-white font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition">Back</a>
    </div>
</div>
@endsection
