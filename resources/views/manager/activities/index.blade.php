@extends('manager.layout')

@section('title', 'Recent Activities')

@section('content')
<div class="p-4">
    <!-- Search and Filter Section -->
    <div class="mb-6">
        <!-- Search Input -->
        <div class="relative mb-4">
            <input 
                type="text" 
                id="searchInput"
                placeholder="Search activities..." 
                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 py-3 pl-10 pr-4 text-[#111418] dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                value="{{ request('search') ?? '' }}"
            >
            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-[#617589] dark:text-gray-400">search</span>
        </div>
        
        <!-- Filter Chips -->
        <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
            <button type="button" class="filter-chip whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium {{ (request('status') ?? 'All') === 'All' ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-[#111418] dark:text-white' }}" data-status="All">All</button>
            <button type="button" class="filter-chip whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium {{ request('status') === 'Open' ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-[#111418] dark:text-white' }}" data-status="Open">Open</button>
            <button type="button" class="filter-chip whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium {{ request('status') === 'In Progress' ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-[#111418] dark:text-white' }}" data-status="In Progress">In Progress</button>
            <button type="button" class="filter-chip whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium {{ request('status') === 'Resolved' ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-[#111418] dark:text-white' }}" data-status="Resolved">Resolved</button>
            <button type="button" class="filter-chip whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium {{ request('status') === 'Pending Approval' ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-[#111418] dark:text-white' }}" data-status="Pending Approval">Pending Approval</button>
        </div>
    </div>
    
    <div>
        <p class="text-[#617589] dark:text-gray-400 mb-4">All complaint activities in your building</p>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterChips = document.querySelectorAll('.filter-chip');
            
            // Function to apply filters
            function applyFilters() {
                const searchValue = searchInput.value.trim();
                const statusValue = document.querySelector('.filter-chip.active')?.dataset.status || 
                                 document.querySelector('.filter-chip.bg-primary')?.dataset.status || 'All';
                
                // Build URL with parameters
                let url = window.location.pathname;
                const params = new URLSearchParams();
                
                if (searchValue) {
                    params.append('search', searchValue);
                }
                if (statusValue && statusValue !== 'All') {
                    params.append('status', statusValue);
                }
                
                if (params.toString()) {
                    url += '?' + params.toString();
                }
                
                // Navigate to the new URL
                window.location.href = url;
            }
            
            // Add event listener to search input with debounce
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 500); // 500ms debounce
            });
            
            // Add event listeners to filter chips
            filterChips.forEach(chip => {
                chip.addEventListener('click', function() {
                    // Remove active class from all chips
                    filterChips.forEach(c => {
                        c.classList.remove('bg-primary', 'text-white');
                        c.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-[#111418]', 'dark:text-white');
                    });
                    
                    // Add active class to clicked chip
                    this.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-[#111418]', 'dark:text-white');
                    this.classList.add('bg-primary', 'text-white');
                    
                    // Apply filters
                    applyFilters();
                });
            });
        });
    </script>

    <div class="space-y-3">
        @forelse($activities as $complaint)
        <div class="flex items-center justify-between gap-4 rounded-xl bg-white dark:bg-gray-800 p-3 shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700 shrink-0 size-10 text-[#111418] dark:text-white">
                    <span class="material-symbols-outlined text-xl">folder_shared</span>
                </div>
                <div class="flex flex-col justify-center">
                    <p class="text-[#111418] dark:text-white text-sm font-semibold leading-normal line-clamp-1">{{ $complaint->title }}</p>
                    <p class="text-[#617589] dark:text-gray-400 text-xs font-normal leading-normal">{{ $complaint->building->name ?? 'N/A' }} • {{ $complaint->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <span class="px-2 py-1 rounded text-[10px] font-bold {{ $complaint->status === 'Open' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : ($complaint->status === 'In Progress' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300') }}">
                {{ $complaint->status }}
            </span>
        </div>
        @empty
        <div class="text-center py-12">
            <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600 mb-4">inbox</span>
            <h3 class="text-lg font-semibold text-[#111418] dark:text-white mb-1">No activities yet</h3>
            <p class="text-[#617589] dark:text-gray-400">No complaints have been raised in your building yet.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection