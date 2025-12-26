@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto p-8 bg-white dark:bg-[#1a2632] rounded-2xl shadow-lg mt-10">
    <h2 class="text-2xl font-bold mb-6 text-[#111418] dark:text-white text-center">Extend Expiry Date</h2>
    <form method="POST" action="{{ route('admin.subcription.extend', $subscription->id) }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Expiry Date</label>
            <input type="date" name="expiry_date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-800 dark:text-white" required min="{{ now()->addDay()->toDateString() }}">
        </div>
        <button type="submit" class="w-full px-4 py-2 rounded-lg bg-purple-600 text-white font-bold hover:bg-purple-700 transition">Update Expiry Date</button>
    </form>
    <div class="mt-6 text-center">
        <a href="{{ route('admin.subcription.manage', $subscription->id) }}" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-[#111418] dark:text-white font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition">Back</a>
    </div>
</div>
@endsection
