@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto p-8 bg-white dark:bg-[#1a2632] rounded-2xl shadow-lg mt-10">
    <h2 class="text-2xl font-bold mb-6 text-[#111418] dark:text-white text-center">Create Subscription Plan</h2>
    <form method="POST" action="{{ url('admin/subcription-plan/create') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Plan Name</label>
            <input type="text" name="name" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-800 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price (₹)</label>
            <input type="number" step="0.01" name="price" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-800 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Billing Cycle</label>
            <select name="billing_cycle" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-800 dark:text-white" required>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Flats</label>
            <input type="number" name="max_flats" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-800 dark:text-white">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Features (comma separated)</label>
            <input type="text" name="features" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-800 dark:text-white">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
            <select name="is_active" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-800 dark:text-white">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <button type="submit" class="w-full px-4 py-2 rounded-lg bg-primary text-white font-bold hover:bg-primary/90 transition">Create Plan</button>
    </form>
    <div class="mt-6 text-center">
        <a href="{{ route('admin.subcription-plan') }}" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-[#111418] dark:text-white font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition">Back</a>
    </div>
</div>
@endsection
