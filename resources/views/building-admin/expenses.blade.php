@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display min-h-screen flex flex-col antialiased selection:bg-primary/20">
    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4 py-3 flex items-center justify-between shadow-sm">
        <a href="{{ route('building-admin.dashboard') }}" class="p-2 -ml-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-slate-600 dark:text-slate-300">
            <span class="material-symbols-outlined text-[24px]">arrow_back</span>
        </a>
        <h1 class="text-lg font-bold text-slate-900 dark:text-white flex-1 text-center pr-2">Expenses</h1>
        <a href="{{ route('building-admin.expenses.create') }}" class="p-2 -mr-2 rounded-full bg-primary/10 text-primary hover:bg-primary/20 transition-colors">
            <span class="material-symbols-outlined text-[24px]">add</span>
        </a>
    </header>
    <main class="flex-1 flex flex-col pb-24 max-w-lg mx-auto w-full">
        <!-- Summary Stats -->
        <section class="p-4 grid grid-cols-2 gap-3">
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-medium uppercase tracking-wider mb-1">Total Pending</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['pending_amount'] ?? '$0' }}</span>
                    <span class="text-sm font-medium text-slate-500">.00</span>
                </div>
                <div class="mt-2 flex items-center text-xs font-medium text-orange-600 bg-orange-50 dark:bg-orange-900/20 w-fit px-2 py-0.5 rounded-full">
                    {{ $stats['pending_count'] ?? '0 Requests' }}
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-medium uppercase tracking-wider mb-1">Budget Used</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['budget_used'] ?? '0%' }}</span>
                </div>
                <div class="mt-2 w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                    <div class="bg-primary h-full rounded-full" style="width: {{ $stats['budget_used'] ?? '0%' }}"></div>
                </div>
            </div>
        </section>
        <!-- Filter Chips -->
        <section class="px-4 pb-2">
            <div class="flex gap-2 overflow-x-auto scrollbar-hide py-1">
                <button class="flex items-center justify-center px-5 py-2 rounded-full bg-primary text-white text-sm font-medium shadow-sm transition-transform active:scale-95 shrink-0">All</button>
                <button class="flex items-center justify-center px-5 py-2 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors shrink-0">Pending</button>
                <button class="flex items-center justify-center px-5 py-2 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors shrink-0">Approved</button>
                <button class="flex items-center justify-center px-5 py-2 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors shrink-0">Rejected</button>
            </div>
        </section>
        <!-- Pending Requests Section -->
        <div class="px-4 pt-6 pb-2">
            <h3 class="text-slate-900 dark:text-white font-bold text-lg flex items-center gap-2">
                Pending Requests
                <span class="bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 text-xs px-2 py-0.5 rounded-full font-bold">{{ $stats['pending_count'] ?? 0 }}</span>
            </h3>
        </div>
        <div class="flex flex-col gap-4 px-4">
            @forelse($pendingExpenses as $expense)
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex gap-3">
                            <div class="w-12 h-12 rounded-xl {{ $expense->icon_bg }} flex items-center justify-center {{ $expense->icon_color }} shrink-0">
                                <span class="material-symbols-outlined">{{ $expense->icon }}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 dark:text-white leading-tight">{{ $expense->title }}</h4>
                                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">{{ $expense->vendor }}</p>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span class="bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-[10px] font-semibold px-2 py-0.5 rounded uppercase tracking-wide">{{ $expense->category }}</span>
                                    <span class="text-slate-400 text-xs">• {{ $expense->date }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block text-lg font-bold text-slate-900 dark:text-white">${{ $expense->amount }}</span>
                            <span class="inline-block px-2 py-0.5 bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 text-xs font-medium rounded-full mt-1">Pending</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <button class="flex items-center justify-center gap-2 py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                            Reject
                        </button>
                        <button class="flex items-center justify-center gap-2 py-2.5 rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-semibold shadow-sm transition-colors">
                            <span class="material-symbols-outlined text-[18px]">check</span>
                            Approve
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-slate-500 dark:text-slate-400 text-sm">No pending expenses.</p>
            @endforelse
        </div>
        <!-- History Section -->
        <div class="px-4 pt-8 pb-2">
            <h3 class="text-slate-900 dark:text-white font-bold text-lg">History</h3>
        </div>
        <div class="flex flex-col gap-3 px-4">
            @forelse($historyExpenses as $expense)
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-sm border border-slate-100 dark:border-slate-700 flex justify-between items-center opacity-80">
                    <div class="flex gap-3 items-center">
                        <div class="w-10 h-10 rounded-lg {{ $expense->icon_bg }} flex items-center justify-center {{ $expense->icon_color }} shrink-0">
                            <span class="material-symbols-outlined text-[20px]">{{ $expense->icon }}</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-white text-sm">{{ $expense->title }}</h4>
                            <p class="text-slate-500 text-xs mt-0.5">{{ $expense->vendor }} • {{ $expense->date }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block font-bold text-slate-900 dark:text-white text-sm">${{ $expense->amount }}</span>
                        <span class="{{ $expense->status_color }} text-[10px] font-bold uppercase tracking-wide">{{ ucfirst($expense->status) }}</span>
                    </div>
                </div>
            @empty
                <p class="text-slate-500 dark:text-slate-400 text-sm">No expense history.</p>
            @endforelse
        </div>
    </main>
    @include('building-admin.partials.bottom-nav', ['active' => 'expenses'])
</div>
@endsection
