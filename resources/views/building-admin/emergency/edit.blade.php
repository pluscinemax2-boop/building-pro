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
                <!-- Submit button moved to bottom of form -->
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
        
        <!-- Priority Level -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-[#111418] dark:text-white mb-2">Priority Level</label>
            <select name="priority" class="w-full px-4 py-3 rounded-lg border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                <option value="low" {{ old('priority', $emergency->priority) == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority', $emergency->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('priority', $emergency->priority) == 'high' ? 'selected' : '' }}>High</option>
                <option value="critical" {{ old('priority', $emergency->priority) == 'critical' ? 'selected' : '' }}>Critical</option>
            </select>
            @error('priority')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Alert Type -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-[#111418] dark:text-white mb-2">Alert Type</label>
            <select name="type" class="w-full px-4 py-3 rounded-lg border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                <option value="fire" {{ old('type', $emergency->type) == 'fire' ? 'selected' : '' }}>Fire</option>
                <option value="gas" {{ old('type', $emergency->type) == 'gas' ? 'selected' : '' }}>Gas</option>
                <option value="power" {{ old('type', $emergency->type) == 'power' ? 'selected' : '' }}>Power</option>
                <option value="water" {{ old('type', $emergency->type) == 'water' ? 'selected' : '' }}>Water</option>
                <option value="security" {{ old('type', $emergency->type) == 'security' ? 'selected' : '' }}>Security</option>
                <option value="other" {{ old('type', $emergency->type) == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('type')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Status -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-[#111418] dark:text-white mb-2">Status</label>
            <select name="status" class="w-full px-4 py-3 rounded-lg border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                <option value="sent" {{ old('status', $emergency->status) == 'sent' ? 'selected' : '' }}>Send Now</option>
                <option value="draft" {{ old('status', $emergency->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="scheduled" {{ old('status', $emergency->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
            </select>
            @error('status')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Scheduled Time (only shown if scheduled is selected) -->
        <div id="scheduledTimeContainer" class="{{ old('status', $emergency->status) != 'scheduled' ? 'hidden' : '' }}">
            <div class="mb-6">
                <label class="block text-sm font-medium text-[#111418] dark:text-white mb-2">Scheduled Time</label>
                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at', $emergency->scheduled_at ? $emergency->scheduled_at->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-3 rounded-lg border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white placeholder:text-[#9aa2ac] dark:placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                @error('scheduled_at')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
            
        <!-- Submit Button at Bottom -->
        <div class="flex justify-center mt-6 mb-6">
            <button type="submit" class="flex w-full max-w-md cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-4 bg-primary text-white text-sm font-bold leading-normal hover:bg-blue-600 transition-colors shadow-sm active:scale-[0.98]">
                <span class="material-symbols-outlined mr-2 text-[20px]">check</span>
                <span>Update Alert</span>
            </button>
        </div>
    </form>
    
    <!-- Bottom Navigation Bar -->
    @include('building-admin.partials.bottom-nav', ['active' => 'emergency'])
</div>

<script>
// Toggle scheduled time field based on status selection
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.querySelector('select[name="status"]');
    const scheduledContainer = document.getElementById('scheduledTimeContainer');
    
    statusSelect.addEventListener('change', function() {
        if (this.value === 'scheduled') {
            scheduledContainer.classList.remove('hidden');
        } else {
            scheduledContainer.classList.add('hidden');
        }
    });
    
    // Trigger change event on page load to set initial state
    statusSelect.dispatchEvent(new Event('change'));
});
</script>
@endsection