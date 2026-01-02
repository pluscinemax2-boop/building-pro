@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white pb-24 min-h-screen">
    <!-- Header -->
    <div class="sticky top-0 z-20 bg-white dark:bg-[#111418] border-b border-[#dbe0e6] dark:border-gray-800 shadow-sm">
        <div class="flex items-center justify-between p-4 pb-2">
            <a href="{{ route('building-admin.dashboard') }}" class="text-[#111418] dark:text-white flex size-12 shrink-0 items-center cursor-pointer">
                <span class="material-symbols-outlined text-2xl">arrow_back</span>
            </a>
            <div class="flex-1 text-center">
                <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Emergency Alerts</h2>
            </div>
            <div class="flex w-12 items-center justify-end">
            </div>
        </div>
    </div>
    
    <!-- Hero Section: Compose Alert -->
    <div class="p-4">
        <div class="flex flex-col items-stretch justify-start rounded-xl shadow-sm bg-white dark:bg-[#1a2632] overflow-hidden border border-[#dbe0e6] dark:border-gray-700">
            <div class="w-full h-32 bg-center bg-no-repeat bg-cover relative" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD_-oNXsdEHxhNF8E7sC-60A-edXrXmgv2yG4SAwZwr9FsdNszm1kPXGwvXos0AACdsDgpDTpqDpxWcJDg1ozEQqpHzxbK1TuiNfs9As01vuIW6-9j5352Uy8urGAAbnjZk0pC4QpOX_lkRveGqFNNOLEG_t_Mxt9X2kt1upCaw1fplcs5FkdRZFPpZJxD1Oq0w5p4LfTGvq21nkyTWgzYPBgmXY81OQYX5je1aoagvuzziMYcruLrlYEIg2YY_liDUU8Uie9PuBV2z");'>
                <div class="absolute inset-0 bg-primary/40 mix-blend-multiply"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="bg-white/20 backdrop-blur-sm p-3 rounded-full border border-white/30">
                        <span class="material-symbols-outlined text-white text-3xl">campaign</span>
                    </div>
                </div>
            </div>
            <div class="flex w-full flex-col items-stretch justify-center gap-3 p-4">
                <div class="flex flex-col gap-1">
                    <p class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Broadcast Emergency</p>
                    <p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal">Send an urgent notification to all residents instantly. Use for fire, weather, or security alerts.</p>
                </div>
                <a href="{{ route('building-admin.emergency.create') }}" class="flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal hover:bg-blue-600 transition-colors shadow-sm active:scale-[0.98]">
                    <span class="material-symbols-outlined mr-2 text-[20px]">add_alert</span>
                    <span class="truncate">Compose New Alert</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Search Bar -->
    <div class="px-4 py-2">
        <form method="GET" action="{{ route('building-admin.emergency') }}" class="flex">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-[#617589]">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </div>
                <input type="text" name="search" value="{{ old('search', request('search')) }}" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary h-10 text-sm font-normal leading-normal" placeholder="Search alert history..." />
                @if(request('search'))
                <a href="{{ route('building-admin.emergency') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#617589]">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </a>
                @endif
            </div>
        </form>
    </div>
    
    <!-- Filter Chips -->
    <div class="flex gap-2 p-4 overflow-x-auto scrollbar-hide pb-2">
        <a href="{{ route('building-admin.emergency') }}" class="flex h-8 shrink-0 cursor-pointer items-center justify-center gap-x-2 rounded-full {{ !request()->has('status') ? 'bg-[#111418] dark:bg-white text-white dark:text-[#111418]' : 'bg-background-light dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#111418] dark:text-white' }} pl-4 pr-4 transition-colors">
            <p class="text-xs font-bold leading-normal">All</p>
        </a>
        <a href="{{ route('building-admin.emergency') }}?status=sent" class="flex h-8 shrink-0 cursor-pointer items-center justify-center gap-x-2 rounded-full {{ request('status') == 'sent' ? 'bg-[#111418] dark:bg-white text-white dark:text-[#111418]' : 'bg-background-light dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#111418] dark:text-white' }} pl-4 pr-4 transition-colors">
            <p class="text-xs font-medium leading-normal">Sent</p>
        </a>
        <a href="{{ route('building-admin.emergency') }}?status=scheduled" class="flex h-8 shrink-0 cursor-pointer items-center justify-center gap-x-2 rounded-full {{ request('status') == 'scheduled' ? 'bg-[#111418] dark:bg-white text-white dark:text-[#111418]' : 'bg-background-light dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#111418] dark:text-white' }} pl-4 pr-4 transition-colors">
            <p class="text-xs font-medium leading-normal">Scheduled</p>
        </a>
        <a href="{{ route('building-admin.emergency') }}?status=draft" class="flex h-8 shrink-0 cursor-pointer items-center justify-center gap-x-2 rounded-full {{ request('status') == 'draft' ? 'bg-[#111418] dark:bg-white text-white dark:text-[#111418]' : 'bg-background-light dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-700 text-[#111418] dark:text-white' }} pl-4 pr-4 transition-colors">
            <p class="text-xs font-medium leading-normal">Drafts</p>
        </a>
    </div>
    
    <!-- Past Broadcasts Section -->
    <div class="flex flex-col flex-1">
        <h2 class="text-[#111418] dark:text-white tracking-tight text-lg font-bold leading-tight px-4 text-left pb-2 pt-2">Past Broadcasts</h2>
        <div class="flex flex-col gap-3 p-4 pt-2">
            @forelse($alerts as $alert)
                <!-- Alert Item -->
                <div class="group flex flex-col gap-2 rounded-xl border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#1a2632] p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full 
                                @if($alert->priority == 'critical') bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400
                                @elseif($alert->priority == 'high') bg-orange-50 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400
                                @elseif($alert->priority == 'medium') bg-blue-50 text-primary dark:bg-blue-900/30 dark:text-blue-400
                                @else bg-gray-50 text-gray-600 dark:bg-gray-700 dark:text-gray-300 @endif">
                                <span class="material-symbols-outlined text-[20px]">
                                    @if($alert->priority == 'critical') warning
                                    @elseif($alert->priority == 'high') water_drop
                                    @elseif($alert->priority == 'medium') elevator
                                    @else edit_document @endif
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-sm font-bold text-[#111418] dark:text-white">{{ $alert->title }}</p>
                                <p class="text-xs text-[#617589] dark:text-gray-400">{{ $alert->created_at->format('M d, h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="@if($alert->status == 'sent') bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                        @elseif($alert->status == 'scheduled') bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400
                                        @elseif($alert->status == 'draft') bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300
                                        @else bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 @endif 
                                        rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide">
                                {{ ucfirst($alert->status) }}
                            </div>
                            <div class="flex gap-1">
                                @if(in_array($alert->status, ['draft', 'scheduled']))
                                <a href="{{ route('building-admin.emergency.edit', $alert->id) }}" class="text-[#617589] hover:text-primary dark:text-gray-400 dark:hover:text-blue-400 p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </a>
                                @endif
                                <form action="{{ route('building-admin.emergency.destroy', $alert->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this alert?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[#617589] hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-[#3b4a59] dark:text-gray-300 line-clamp-2 pl-[52px]">
                        {{ $alert->message }}
                    </p>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>No emergency alerts found.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Bottom Navigation Bar -->
    @include('building-admin.partials.bottom-nav', ['active' => 'emergency'])
</div>
@endsection