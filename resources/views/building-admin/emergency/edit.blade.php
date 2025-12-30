@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white pb-24 min-h-screen">
    <!-- Header -->
    <div class="sticky top-0 z-20 bg-white dark:bg-[#111418] border-b border-[#dbe0e6] dark:border-gray-800 shadow-sm">
        <div class="flex items-center justify-between p-4 pb-2">
            <a href="{{ route('building-admin.emergency') }}" class="text-[#111418] dark:text-white flex size-12 shrink-0 items-center cursor-pointer">
                <span class="material-symbols-outlined text-2xl">arrow_back</span>
            </a>
            <div class="flex-1 text-center">
                <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Edit Alert</h2>
            </div>
            <div class="flex w-12 items-center justify-end">
                <button type="submit" form="emergencyForm" class="text-primary">
                    <span class="material-symbols-outlined text-2xl">check</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Form -->
    <form id="emergencyForm" method="POST" action="{{ route('building-admin.emergency.update', $emergency->id) }}" class="p-4">
        @csrf
        @method('PUT')
        
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
            <div class="flex items-center">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400 mr-3">check_circle</span>
                <p class="text-green-700 dark:text-green-300 text-sm">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
            <div class="flex items-center">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400 mr-3">error</span>
                <p class="text-red-700 dark:text-red-300 text-sm">{{ $errors->first() }}</p>
            </div>
        </div>
        @endif
        
        <!-- Alert Title -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-[#111418] dark:text-white mb-2">Alert Title</label>
            <input type="text" name="title" value="{{ old('title', $emergency->title) }}" required class="w-full px-4 py-3 rounded-lg border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white placeholder:text-[#9aa2ac] dark:placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter alert title">
            @error('title')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Alert Message -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-[#111418] dark:text-white mb-2">Alert Message</label>
            <textarea name="message" required rows="6" class="w-full px-4 py-3 rounded-lg border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white placeholder:text-[#9aa2ac] dark:placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter your emergency message...">{{ old('message', $emergency->message) }}</textarea>
            @error('message')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Priority -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-[#111418] dark:text-white mb-2">Priority Level</label>
            <div class="grid grid-cols-2 gap-3">
                <label class="flex items-center p-3 border border-[#dbe0e6] dark:border-gray-700 rounded-lg bg-white dark:bg-[#1a2632] cursor-pointer {{ old('priority', $emergency->priority) == 'low' ? 'ring-2 ring-primary border-primary' : '' }}">
                    <input type="radio" name="priority" value="low" class="sr-only" {{ old('priority', $emergency->priority) == 'low' ? 'checked' : '' }}>
                    <span class="material-symbols-outlined text-gray-400 mr-2">flag</span>
                    <span class="text-[#111418] dark:text-white">Low</span>
                </label>
                <label class="flex items-center p-3 border border-[#dbe0e6] dark:border-gray-700 rounded-lg bg-white dark:bg-[#1a2632] cursor-pointer {{ old('priority', $emergency->priority) == 'medium' ? 'ring-2 ring-primary border-primary' : '' }}">
                    <input type="radio" name="priority" value="medium" class="sr-only" {{ old('priority', $emergency->priority) == 'medium' ? 'checked' : '' }}>
                    <span class="material-symbols-outlined text-primary mr-2">flag</span>
                    <span class="text-[#111418] dark:text-white">Medium</span>
                </label>
                <label class="flex items-center p-3 border border-[#dbe0e6] dark:border-gray-700 rounded-lg bg-white dark:bg-[#1a2632] cursor-pointer {{ old('priority', $emergency->priority) == 'high' ? 'ring-2 ring-primary border-primary' : '' }}">
                    <input type="radio" name="priority" value="high" class="sr-only" {{ old('priority', $emergency->priority) == 'high' ? 'checked' : '' }}>
                    <span class="material-symbols-outlined text-orange-500 mr-2">warning</span>
                    <span class="text-[#111418] dark:text-white">High</span>
                </label>
                <label class="flex items-center p-3 border border-[#dbe0e6] dark:border-gray-700 rounded-lg bg-white dark:bg-[#1a2632] cursor-pointer {{ old('priority', $emergency->priority) == 'critical' ? 'ring-2 ring-primary border-primary' : '' }}">
                    <input type="radio" name="priority" value="critical" class="sr-only" {{ old('priority', $emergency->priority) == 'critical' ? 'checked' : '' }}>
                    <span class="material-symbols-outlined text-red-500 mr-2">warning</span>
                    <span class="text-[#111418] dark:text-white">Critical</span>
                </label>
            </div>
            @error('priority')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Status -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-[#111418] dark:text-white mb-2">Status</label>
            <div class="grid grid-cols-3 gap-3">
                <label class="flex flex-col items-center p-3 border border-[#dbe0e6] dark:border-gray-700 rounded-lg bg-white dark:bg-[#1a2632] cursor-pointer {{ old('status', $emergency->status) == 'draft' ? 'ring-2 ring-primary border-primary' : '' }}">
                    <input type="radio" name="status" value="draft" class="sr-only" {{ old('status', $emergency->status) == 'draft' ? 'checked' : '' }}>
                    <span class="material-symbols-outlined text-[#111418] dark:text-white mb-1">edit_document</span>
                    <span class="text-[#111418] dark:text-white text-sm">Draft</span>
                </label>
                <label class="flex flex-col items-center p-3 border border-[#dbe0e6] dark:border-gray-700 rounded-lg bg-white dark:bg-[#1a2632] cursor-pointer {{ old('status', $emergency->status) == 'scheduled' ? 'ring-2 ring-primary border-primary' : '' }}">
                    <input type="radio" name="status" value="scheduled" class="sr-only" {{ old('status', $emergency->status) == 'scheduled' ? 'checked' : '' }}>
                    <span class="material-symbols-outlined text-[#111418] dark:text-white mb-1">schedule</span>
                    <span class="text-[#111418] dark:text-white text-sm">Scheduled</span>
                </label>
                <label class="flex flex-col items-center p-3 border border-[#dbe0e6] dark:border-gray-700 rounded-lg bg-white dark:bg-[#1a2632] cursor-pointer {{ old('status', $emergency->status) == 'sent' ? 'ring-2 ring-primary border-primary' : '' }}">
                    <input type="radio" name="status" value="sent" class="sr-only" {{ old('status', $emergency->status) == 'sent' ? 'checked' : '' }}>
                    <span class="material-symbols-outlined text-[#111418] dark:text-white mb-1">send</span>
                    <span class="text-[#111418] dark:text-white text-sm">Send Now</span>
                </label>
            </div>
            @error('status')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Scheduled Time (only shown if scheduled is selected) -->
        <div id="scheduledTimeContainer" class="{{ old('status', $emergency->status) != 'scheduled' ? 'hidden' : '' }}">
            <div class="mb-6">
                <label class="block text-sm font-medium text-[#111418] dark:text-white mb-2">Scheduled Time</label>
                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at', $emergency->scheduled_at ? $emergency->scheduled_at->format('Y-m-d\\TH:i') : '') }}" class="w-full px-4 py-3 rounded-lg border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white placeholder:text-[#9aa2ac] dark:placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                @error('scheduled_at')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </form>
    
    <!-- Bottom Navigation Bar -->
    @include('building-admin.partials.bottom-nav', ['active' => 'emergency'])
</div>

<script>
// Toggle scheduled time field based on status selection
document.addEventListener('DOMContentLoaded', function() {
    const statusRadios = document.querySelectorAll('input[name="status"]');
    const scheduledContainer = document.getElementById('scheduledTimeContainer');
    
    statusRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'scheduled') {
                scheduledContainer.classList.remove('hidden');
            } else {
                scheduledContainer.classList.add('hidden');
            }
        });
    });
});
</script>
@endsection