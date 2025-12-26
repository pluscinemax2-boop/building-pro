@extends('layouts.app')

@section('title', 'Register Building')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 bg-background-light dark:bg-background-dark">
    <div class="w-full max-w-lg">
        <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                        <span class="material-symbols-outlined text-white text-3xl">apartment</span>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-text-main dark:text-white">Register Your Building</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Create your building admin account</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 mr-3">error</span>
                        <ul class="text-red-700 dark:text-red-300 text-sm mb-0">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ url('/register-building') }}" class="space-y-6">
                @csrf
                <div>
                    <h2 class="text-lg font-semibold text-text-main dark:text-white mb-2">Admin Details</h2>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="admin_name" placeholder="Your Name" required class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" value="{{ old('admin_name') }}">
                        <input type="email" name="email" placeholder="Email Address" required class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" value="{{ old('email') }}">
                        <input type="text" name="phone" placeholder="Phone Number" required class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" value="{{ old('phone') }}">
                        <input type="password" name="password" placeholder="Password" required class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none">
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-text-main dark:text-white mb-2">Building Details</h2>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="building_name" placeholder="Building Name" required class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" value="{{ old('building_name') }}">
                        <textarea name="address" id="address" placeholder="Address" required rows="2" class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none resize-none">{{ old('address') }}</textarea>
                        <input type="text" name="city" placeholder="City" required class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" value="{{ old('city') }}">
                        <input type="text" name="state" placeholder="State" required class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" value="{{ old('state') }}">
                        <input type="text" name="pincode" placeholder="Pincode" required class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" value="{{ old('pincode') }}">
                        <input type="text" name="country" placeholder="Country" required class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" value="{{ old('country', 'India') }}">
                        <input type="number" name="total_flats" placeholder="Total Flats" required class="rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" value="{{ old('total_flats') }}">
                    </div>
                </div>
                <button type="submit" class="w-full bg-primary text-white font-bold py-3 rounded-lg hover:bg-primary/90 transition duration-200 flex items-center justify-center space-x-2 mt-4">
                    <span>Submit Registration</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
