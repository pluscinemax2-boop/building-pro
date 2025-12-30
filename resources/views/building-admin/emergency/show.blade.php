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
                <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Alert Details</h2>
            </div>
            <div class="flex w-12 items-center justify-end">
                <a href="{{ route('building-admin.emergency.edit', $emergency->id) }}" class="text-primary">
                    <span class="material-symbols-outlined text-2xl">edit</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Alert Details -->
    <div class="p-4">
        <div class="flex flex-col items-stretch justify-start rounded-xl shadow-sm bg-white dark:bg-[#1a2632] overflow-hidden border border-[#dbe0e6] dark:border-gray-700">
            <div class="w-full h-32 bg-center bg-no-repeat bg-cover relative" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD_-oNXsdEHxhNF8E7sC-60A-edXrXmgv2yG4SAwZwr9FsdNszm1kPXGwvXos0AACdsDgpDTpqDpxWcJDg1ozEQqpHzxbK1TuiNfs9As01vuIW6-9j5352Uy8urGAAbnjZk0pC4QpOX_lkRveGqFNNOLEG_t_Mxt9X2kt1upCaw1fplcs5FkdRZFPpZJxD1Oq0w5p4LfTGvq21nkyTWgzYPBgmXY81OQYX5je1aoagvuzziMYcruLrlYEIg2YY_liDUU8Uie9PuBV2z");'>
                <div class="absolute inset-0 bg-primary/40 mix-blend-multiply"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="bg-white/20 backdrop-blur-sm p-3 rounded-full border border-white/30">
                        <span class="material-symbols-outlined text-white text-3xl">
                            @if($emergency->priority == 'critical') warning
                            @elseif($emergency->priority == 'high') water_drop
                            @elseif($emergency->priority == 'medium') elevator
                            @else flag @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex w-full flex-col items-stretch justify-center gap-3 p-4">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between">
                        <p class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">{{ $emergency->title }}</p>
                        <div class="@if($emergency->status == 'sent') bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                    @elseif($emergency->status == 'scheduled') bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400
                                    @elseif($emergency->status == 'draft') bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300
                                    @else bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 @endif 
                                    rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide">
                            {{ ucfirst($emergency->status) }}
                        </div>
                    </div>
                    <p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal">
                        Created: {{ $emergency->created_at->format('M d, Y h:i A') }}
                        @if($emergency->scheduled_at)
                        | Scheduled: {{ $emergency->scheduled_at->format('M d, Y h:i A') }}
                        @endif
                        @if($emergency->sent_at)
                        | Sent: {{ $emergency->sent_at->format('M d, Y h:i A') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alert Message -->
    <div class="p-4">
        <div class="rounded-xl shadow-sm bg-white dark:bg-[#1a2632] overflow-hidden border border-[#dbe0e6] dark:border-gray-700 p-4">
            <h3 class="text-[#111418] dark:text-white font-bold text-sm mb-2">Message</h3>
            <p class="text-[#3b4a59] dark:text-gray-300">{{ $emergency->message }}</p>
        </div>
    </div>
    
    <!-- Priority and Additional Info -->
    <div class="p-4">
        <div class="rounded-xl shadow-sm bg-white dark:bg-[#1a2632] overflow-hidden border border-[#dbe0e6] dark:border-gray-700 p-4">
            <h3 class="text-[#111418] dark:text-white font-bold text-sm mb-3">Details</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">Priority</p>
                    <p class="text-[#111418] dark:text-white">
                        @if($emergency->priority == 'critical') Critical
                        @elseif($emergency->priority == 'high') High
                        @elseif($emergency->priority == 'medium') Medium
                        @else Low @endif
                    </p>
                </div>
                <div>
                    <p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">Status</p>
                    <p class="text-[#111418] dark:text-white">{{ ucfirst($emergency->status) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="p-4 space-y-3">
        @if($emergency->status === 'draft')
        <form method="POST" action="{{ route('building-admin.emergency.update', $emergency->id) }}" class="inline-block w-full">
            @csrf
            @method('PUT')
            <input type="hidden" name="title" value="{{ $emergency->title }}">
            <input type="hidden" name="message" value="{{ $emergency->message }}">
            <input type="hidden" name="priority" value="{{ $emergency->priority }}">
            <input type="hidden" name="status" value="sent">
            <button type="submit" class="w-full flex cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-red-600 text-white text-sm font-bold leading-normal hover:bg-red-700 transition-colors shadow-sm">
                <span class="material-symbols-outlined mr-2 text-[20px]">send</span>
                <span class="truncate">Send Alert Now</span>
            </button>
        </form>
        @endif
        
        <form method="POST" action="{{ route('building-admin.emergency.destroy', $emergency->id) }}" class="inline-block w-full">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full flex cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-gray-200 dark:bg-gray-700 text-[#111418] dark:text-white text-sm font-bold leading-normal hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors shadow-sm" 
                    onclick="return confirm('Are you sure you want to delete this emergency alert?')">
                <span class="material-symbols-outlined mr-2 text-[20px]">delete</span>
                <span class="truncate">Delete Alert</span>
            </button>
        </form>
    </div>
    
    <!-- Bottom Navigation Bar -->
    @include('building-admin.partials.bottom-nav', ['active' => 'emergency'])
</div>
@endsection