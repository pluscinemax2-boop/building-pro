@extends('building-admin.layout')

@section('content')
<div class="min-h-screen relative pb-24 bg-background-light dark:bg-background-dark">
    <header class="sticky top-0 z-50 bg-white dark:bg-surface-dark/95 backdrop-blur-sm border-b border-border dark:border-gray-800">
        <div class="flex items-center px-4 py-3 relative">
            <a href="{{ route('building-admin.manager-management.index') }}" class="flex items-center justify-center h-10 w-10 rounded-full hover:bg-background-light dark:hover:bg-gray-800 transition-colors text-text-main dark:text-white mr-2 z-10">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div class="flex-1 flex justify-center absolute left-0 right-0 pointer-events-none">
                <h1 class="text-text-main dark:text-white text-xl font-bold tracking-tight text-center pointer-events-auto">Edit Manager</h1>
            </div>
        </div>
    </header>
    <main class="w-full max-w-md mx-auto p-4">
        <form method="POST" action="{{ route('building-admin.managers.update', $manager) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-text-main dark:text-white text-sm font-medium mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $manager->name) }}" required class="w-full px-4 py-3 rounded-lg border border-border dark:border-gray-700 bg-white dark:bg-surface-dark text-text-main dark:text-white placeholder-text-sub dark:placeholder-text-sub focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter full name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-text-main dark:text-white text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $manager->email) }}" required class="w-full px-4 py-3 rounded-lg border border-border dark:border-gray-700 bg-white dark:bg-surface-dark text-text-main dark:text-white placeholder-text-sub dark:placeholder-text-sub focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter email address">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-text-main dark:text-white text-sm font-medium mb-2">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $manager->phone) }}" required class="w-full px-4 py-3 rounded-lg border border-border dark:border-gray-700 bg-white dark:bg-surface-dark text-text-main dark:text-white placeholder-text-sub dark:placeholder-text-sub focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter phone number">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-text-main dark:text-white text-sm font-medium mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-3 rounded-lg border border-border dark:border-gray-700 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="active" {{ old('status', $manager->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $manager->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <button type="submit" class="w-full mt-6 bg-primary text-white rounded-lg shadow-sm px-4 py-3 text-base font-bold hover:bg-primary/90 transition">Update Manager</button>
        </form>
    </main>
</div>
@endsection