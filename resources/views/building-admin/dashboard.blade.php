@extends('layouts.app')
@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col pb-24">
    <!-- Header -->
    <div class="flex items-center bg-white dark:bg-[#1e2732] p-4 sticky top-0 z-20 shadow-sm border-b border-[#e5e7eb] dark:border-gray-800">
        <div class="flex size-10 shrink-0 items-center">
            <a href="{{ route('building-admin.profile') }}">
                <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shadow-sm ring-2 ring-gray-50 dark:ring-gray-700" data-alt="Profile picture of building administrator" style="background-image: url('{{ $adminProfilePic ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuA3ZuObFSZHcFPwZeebevPXn90ykSdYyyRbFwvZT5kxnwTN6g0DWnCPKbsm7VahpVebE_uFjE_4-d47cmFDjGeJ7RCW0kY3-eARZBZirBsPh9bf8SczIWPuXLCvxcBESlhUjessmmHRvAE2PXPNwDlD1yzhursTNvWM_-o_Xg1V4nS-aGNhU-1FlP940QzNY6WiqElxstzTfFmxE1SW8nqAxchbcKm6V67KVqCvDJB-gM6-gqoSIVOZqkpEMF1EmdHQpN1hIvWKNzmK' }}');"></div>
            </a>
        </div>
        <div class="ml-4 flex-1">
            <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight">{{ $buildingName ?? 'Sunrise Heights' }}</h2>
            <p class="text-[#617589] dark:text-gray-400 text-xs font-medium">Admin Dashboard</p>
        </div>
        <div class="flex w-12 items-center justify-end">
            <button id="notification-btn" type="button" onclick="toggleNotifications()" class="relative flex items-center justify-center rounded-full size-10 bg-transparent text-[#111418] dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none">
                <span class="material-symbols-outlined">notifications</span>
                @if($unreadNotifications ?? false)
                <span class="absolute top-2 right-2 size-2.5 bg-red-500 rounded-full border-2 border-white dark:border-[#1e2732]"></span>
                @endif
            </button>
            <!-- Notification Dropdown -->
            <div id="notification-dropdown" class="hidden absolute right-4 top-16 w-80 max-w-xs bg-white dark:bg-[#192531] rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 z-50 animate-fade-in">
                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-[#111418] dark:text-white text-base font-bold">Notifications</h3>
                    <button onclick="toggleNotifications()" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
                    <div class="text-center text-gray-400 py-6">No new notifications.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 flex flex-col gap-6">
        <!-- Subscription Banner -->
        <div class="flex items-center justify-between gap-4 rounded-xl bg-white dark:bg-[#1e2732] p-4 shadow-sm border border-[#e5e7eb] dark:border-gray-800 relative overflow-hidden group">
            <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-gradient-to-l from-blue-50 to-transparent dark:from-blue-900/20 opacity-50"></div>
            <div class="flex flex-col gap-1 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="flex items-center justify-center size-5 rounded-full bg-primary/10 text-primary">
                        <span class="material-symbols-outlined text-[14px] font-bold">verified</span>
                    </span>
                    <p class="text-[#111418] dark:text-white text-sm font-bold leading-tight">{{ $subscriptionTier ?? 'Pro Tier Active' }}</p>
                </div>
                <p class="text-[#617589] dark:text-gray-400 text-sm font-normal pl-7">Expires in {{ $subscriptionExpiresIn ?? '15 days' }}</p>
            </div>
            <a href="{{ route('building-admin.subscription') }}" class="relative z-10 flex cursor-pointer items-center justify-center overflow-hidden rounded-lg h-9 px-4 bg-primary text-white text-sm font-bold leading-normal shadow-sm hover:bg-blue-600 transition-colors">
                <span class="truncate">Renew</span>
            </a>
        </div>
        <!-- Metrics Grid (Stats) -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Total Flats -->
            <div class="flex flex-col gap-3 rounded-xl bg-white dark:bg-[#1e2732] p-5 shadow-sm border border-[#e5e7eb] dark:border-gray-800">
                <div class="flex items-center justify-between">
                    <p class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">Total Flats</p>
                    <span class="material-symbols-outlined text-primary">apartment</span>
                </div>
                <p class="text-[#111418] dark:text-white text-2xl font-bold leading-tight">{{ $totalFlats ?? 0 }}</p>
            </div>
            <!-- Total Residents -->
            <div class="flex flex-col gap-3 rounded-xl bg-white dark:bg-[#1e2732] p-5 shadow-sm border border-[#e5e7eb] dark:border-gray-800">
                <div class="flex items-center justify-between">
                    <p class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">Residents</p>
                    <span class="material-symbols-outlined text-primary">group</span>
                </div>
                <p class="text-[#111418] dark:text-white text-2xl font-bold leading-tight">{{ $totalResidents ?? 0 }}</p>
            </div>
            <!-- Open Complaints (Highlighted) -->
            <div class="flex flex-col gap-3 rounded-xl bg-red-50 dark:bg-red-900/10 p-5 shadow-sm border border-red-100 dark:border-red-900/30 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 size-16 bg-red-100 dark:bg-red-900/20 rounded-full blur-xl"></div>
                <div class="flex items-center justify-between relative z-10">
                    <p class="text-red-800 dark:text-red-300 text-sm font-bold leading-normal">Complaints</p>
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400">warning</span>
                </div>
                <div class="flex items-end gap-2 relative z-10">
                    <p class="text-red-900 dark:text-red-200 text-2xl font-bold leading-tight">{{ $openComplaints ?? 0 }}</p>
                    <span class="text-[10px] font-bold text-red-700 dark:text-red-300 mb-1.5 bg-red-200/50 dark:bg-red-900/40 px-1.5 py-0.5 rounded uppercase tracking-wide">High Priority</span>
                </div>
            </div>
            <!-- Monthly Expenses -->
            <div class="flex flex-col gap-3 rounded-xl bg-white dark:bg-[#1e2732] p-5 shadow-sm border border-[#e5e7eb] dark:border-gray-800">
                <div class="flex items-center justify-between">
                    <p class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">Expenses</p>
                    <span class="material-symbols-outlined text-primary">payments</span>
                </div>
                <div class="flex flex-col">
                    <p class="text-[#111418] dark:text-white text-2xl font-bold leading-tight">{{ $monthlyExpenses ?? '$0' }}</p>
                    <p class="text-[#078838] text-xs font-medium mt-1">{{ $expensesChange ?? '' }}</p>
                </div>
            </div>
        </div>
        <!-- Quick Actions -->
        <div>
            <h3 class="text-[#111418] dark:text-white text-lg font-bold leading-tight mb-3 px-1">Quick Actions</h3>
            <div class="flex gap-4 overflow-x-auto pb-4 pt-1 px-1 scrollbar-hide -mx-1">
                <a href="{{ route('building-admin.residents.create') }}" class="flex flex-col items-center gap-2 min-w-[76px] group">
                    <div class="flex size-14 items-center justify-center rounded-full bg-primary text-white shadow-md shadow-blue-200 dark:shadow-blue-900/30 group-active:scale-95 transition-all">
                        <span class="material-symbols-outlined text-[26px]">person_add</span>
                    </div>
                    <span class="text-xs font-semibold text-[#111418] dark:text-gray-300 text-center leading-tight">Add<br/>Resident</span>
                </a>
                <a href="{{ route('building-admin.notices.index') }}" class="flex flex-col items-center gap-2 min-w-[76px] group">
                    <div class="flex size-14 items-center justify-center rounded-full bg-white dark:bg-[#1e2732] text-primary shadow-sm border border-gray-200 dark:border-gray-700 group-active:scale-95 group-hover:border-primary/50 transition-all">
                        <span class="material-symbols-outlined text-[26px]">campaign</span>
                    </div>
                    <span class="text-xs font-medium text-[#111418] dark:text-gray-300 text-center leading-tight">New<br/>Notice</span>
                </a>
                <a href="{{ route('building-admin.reports') }}" class="flex flex-col items-center gap-2 min-w-[76px] group">
                    <div class="flex size-14 items-center justify-center rounded-full bg-white dark:bg-[#1e2732] text-primary shadow-sm border border-gray-200 dark:border-gray-700 group-active:scale-95 group-hover:border-primary/50 transition-all">
                        <span class="material-symbols-outlined text-[26px]">bar_chart</span>
                    </div>
                    <span class="text-xs font-medium text-[#111418] dark:text-gray-300 text-center leading-tight">Reports</span>
                </a>
                <a href="{{ route('building-admin.expenses.create') }}" class="flex flex-col items-center gap-2 min-w-[76px] group">
                    <div class="flex size-14 items-center justify-center rounded-full bg-white dark:bg-[#1e2732] text-primary shadow-sm border border-gray-200 dark:border-gray-700 group-active:scale-95 group-hover:border-primary/50 transition-all">
                        <span class="material-symbols-outlined text-[26px]">receipt_long</span>
                    </div>
                    <span class="text-xs font-medium text-[#111418] dark:text-gray-300 text-center leading-tight">Log<br/>Expense</span>
                </a>
            </div>
        </div>
        <!-- Recent Activity -->
        <div class="flex flex-col gap-3">
            <div class="flex items-center justify-between px-1">
                <h3 class="text-[#111418] dark:text-white text-lg font-bold leading-tight">Recent Activity</h3>
                <a class="text-primary text-sm font-semibold hover:opacity-80" href="{{ route('building-admin.recent-activities') }}">View All</a>
            </div>
            <div class="rounded-xl bg-white dark:bg-[#1e2732] border border-[#e5e7eb] dark:border-gray-800 divide-y divide-[#f0f2f4] dark:divide-gray-800 overflow-hidden shadow-sm max-h-72 overflow-y-auto">
                @php $count = 0; @endphp
                @forelse($recentActivity as $activity)
                    @php $count++; @endphp
                    <div class="flex gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors cursor-pointer {{ $count > 3 ? 'border-t border-[#f0f2f4] dark:border-gray-800' : '' }}">
                        <div class="flex-none pt-0.5">
                            <div class="{{ $activity['iconBg'] }} rounded-full p-2.5 {{ $activity['iconText'] }}">
                                <span class="material-symbols-outlined text-[20px] block">{{ $activity['icon'] }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 gap-1">
                            <div class="flex justify-between items-start">
                                <p class="text-[#111418] dark:text-white text-sm font-bold">{{ $activity['title'] }}</p>
                                <span class="text-[#617589] dark:text-gray-500 text-[10px] font-medium whitespace-nowrap mt-0.5">{{ $activity['time'] }}</span>
                            </div>
                            <p class="text-[#617589] dark:text-gray-400 text-xs leading-relaxed">{!! $activity['desc'] !!}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-400">No recent activity</div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Bottom Navigation -->
    @include('building-admin.partials.bottom-nav', ['active' => 'dashboard'])
</div>
<script>
function toggleNotifications() {
    const dropdown = document.getElementById('notification-dropdown');
    dropdown.classList.toggle('hidden');
    // Optional: close if clicked outside
    if (!dropdown.classList.contains('hidden')) {
        document.addEventListener('mousedown', closeOnClickOutside);
    } else {
        document.removeEventListener('mousedown', closeOnClickOutside);
    }
}
function closeOnClickOutside(e) {
    const dropdown = document.getElementById('notification-dropdown');
    const btn = document.getElementById('notification-btn');
    if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
        dropdown.classList.add('hidden');
        document.removeEventListener('mousedown', closeOnClickOutside);
    }
}
</script>
@endsection
