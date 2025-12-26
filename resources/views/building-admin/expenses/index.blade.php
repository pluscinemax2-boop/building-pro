
@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display min-h-screen flex flex-col antialiased selection:bg-primary/20">
    <!-- Top Navigation Bar (Dashboard Style) -->
    <div class="flex items-center bg-white dark:bg-[#1e2732] p-4 sticky top-0 z-20 shadow-sm border-b border-[#e5e7eb] dark:border-gray-800">
        <a href="{{ route('building-admin.dashboard') }}" class="text-text-primary dark:text-white flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-neutral-100 dark:hover:bg-gray-800 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div class="ml-4 flex-1 flex flex-col items-center justify-center">
            <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight text-center">Expenses</h2>
        </div>

    </div>
    <main class="flex-1 flex flex-col pb-24 max-w-lg mx-auto w-full">
            <!-- ...existing code... -->
        <!-- Summary Stats -->
        <section class="p-4 grid grid-cols-2 gap-3">
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-medium uppercase tracking-wider mb-1">Total Pending</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['pending_amount'] ?? '₹0' }}</span>
                    <span class="text-sm font-medium text-slate-500"></span>
                </div>
                <div class="mt-2 flex items-center text-xs font-medium text-orange-600 bg-orange-50 dark:bg-orange-900/20 w-fit px-2 py-0.5 rounded-full">
                    {{ $stats['pending_count'] ?? '0 Requests' }}
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-medium uppercase tracking-wider mb-1">Budget Used</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-bold {{ (int)($stats['budget_used'] ?? 0) >= 100 ? 'text-red-600' : 'text-slate-900 dark:text-white' }}">{{ $stats['budget_used'] ?? '0%' }}</span>
                    @if((int)($stats['budget_used'] ?? 0) >= 100)
                        <span class="ml-2 px-2 py-0.5 text-red-700 text-xs font-bold">Budget Exceeded!</span>
                    @endif
                </div>
                <div class="mt-2 w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-300" style="width: {{ $stats['budget_used'] ?? '0%' }}; background: {{ (int)($stats['budget_used'] ?? 0) >= 100 ? '#dc2626' : '#2563eb' }};"></div>
                </div>
            </div>
        </section>
        <!-- Mobile-First Monthly Budget Card -->
        <section class="px-2 pt-4 pb-2">
            @php
                $showEdit = session('showEdit', false);
                $showSummary = isset($budget) && !$showEdit;
                $monthName = isset($budget) ? \Carbon\Carbon::create()->month($budget->month)->format('F') : null;
            @endphp

            @if($showSummary)
                <div class="flex items-center justify-between bg-gradient-to-r from-primary/10 to-blue-100 dark:from-primary/20 dark:to-slate-800 border border-primary/30 dark:border-primary/40 rounded-2xl shadow-lg p-4 mb-2">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[32px] text-primary">savings</span>
                        <span class="font-bold text-lg text-slate-900 dark:text-white">{{ $monthName }} Budget</span>
                        <span class="font-bold text-lg text-primary bg-primary/10 dark:bg-primary/20 px-3 py-1 rounded-lg ml-2">₹{{ number_format($budget->amount, 2) }}</span>
                    </div>
                    <form method="POST" action="{{ route('building-admin.expenses.budget.edit') }}">
                        @csrf
                        <button type="submit" class="ml-2 px-4 py-2 rounded-lg bg-primary text-white font-bold text-sm shadow hover:bg-primary/90 transition flex items-center gap-1">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                            Edit
                        </button>
                    </form>
                </div>
            @else
                <form method="POST" action="{{ route('building-admin.expenses.budget.save') }}" class="backdrop-blur-md bg-white/80 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-lg p-4 flex flex-col gap-4 relative overflow-hidden">
                    @csrf
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-[32px] text-primary">savings</span>
                        <span class="font-bold text-base text-slate-900 dark:text-white">Set Monthly Budget</span>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-row gap-2">
                            <div class="flex flex-col gap-1 flex-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-200 text-xs">Month</label>
                                <select name="month" class="form-select bg-background-light dark:bg-background-dark border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 w-full">
                                    @foreach(range(1,12) as $m)
                                        <option value="{{ $m }}" {{ ($month ?? now()->month) == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-col gap-1 flex-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-200 text-xs">Year</label>
                                <select name="year" class="form-select bg-background-light dark:bg-background-dark border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 w-full">
                                    @foreach(range(now()->year-3, now()->year+1) as $y)
                                        <option value="{{ $y }}" {{ ($year ?? now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-row gap-2 mt-2">
                            <div class="flex flex-col gap-1 flex-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-200 text-xs">Budget Amount (₹)</label>
                                <input type="number" name="budget_amount" min="0" step="0.01" class="form-input bg-background-light dark:bg-background-dark border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 font-bold text-lg w-full" placeholder="Enter amount" required value="{{ $budget ? $budget->amount : '' }}">
                            </div>
                            <div class="flex flex-col gap-1 flex-1 flex-shrink-0 justify-end">
                                <button type="submit" class="w-full py-3 rounded-lg bg-primary text-white font-bold text-base shadow-lg hover:bg-primary/90 transition mt-auto">Set Budget</button>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </section>
        <!-- Pending Requests Section -->
        <div class="px-4 pt-6 pb-2">
            <div class="flex items-center justify-between">
                <h3 class="text-slate-900 dark:text-white font-bold text-lg flex items-center gap-2">
                    Pending Requests
                    <span class="bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 text-xs px-2 py-0.5 rounded-full font-bold">{{ $stats['pending_count'] ?? 0 }}</span>
                </h3>
                <a href="{{ route('building-admin.expenses.pending') }}" class="text-primary text-sm font-semibold hover:underline">View All</a>
            </div>
        </div>
        <div class="flex flex-col gap-4 px-4">
            @forelse($pendingExpenses as $expense)
            <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex gap-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined">{{ $expense->category->icon ?? 'receipt_long' }}</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 dark:text-white leading-tight">{{ $expense->title }}</h4>
                            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">{{ $expense->vendor ?? '-' }}</p>
                            <div class="flex items-center gap-2 mt-1.5">
                                <span class="bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-[10px] font-semibold px-2 py-0.5 rounded uppercase tracking-wide">{{ $expense->category->name ?? '-' }}</span>
                                <span class="text-slate-400 text-xs">• {{ \Illuminate\Support\Carbon::parse($expense->expense_date)->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-lg font-bold text-slate-900 dark:text-white">₹{{ number_format($expense->amount, 2) }}</span>
                        <span class="inline-block px-2 py-0.5 bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 text-xs font-medium rounded-full mt-1">Pending</span>
                    </div>
                </div>
                <!-- Action Buttons -->
                @php $user = auth()->user(); @endphp
                @if($user && $user->role && $user->role->name === 'Building Admin')
                <div class="grid grid-cols-2 gap-3 mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('building-admin.expenses.edit', $expense->id) }}" class="flex items-center justify-center gap-2 py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors w-full">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit
                    </a>
                    <form method="POST" action="{{ route('building-admin.expenses.approve', $expense->id) }}">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-2 py-2.5 rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-semibold shadow-sm transition-colors w-full">
                            <span class="material-symbols-outlined text-[18px]">check</span>
                            Approve
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @empty
            <div class="text-center text-slate-500 py-12">No pending requests.</div>
            @endforelse
        </div>
        <!-- History Section -->
        <div class="px-4 pt-8 pb-2 flex items-center justify-between">
            <h3 class="text-slate-900 dark:text-white font-bold text-lg">History</h3>
            <a href="{{ route('building-admin.expenses.history') }}" class="text-primary text-sm font-semibold hover:underline">View All</a>
        </div>
        <div class="flex flex-col gap-3 px-4">
            @forelse($historyExpenses as $expense)
            <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-sm border border-slate-100 dark:border-slate-700 flex justify-between items-center opacity-80">
                <div class="flex gap-3 items-center">
                    <div class="w-10 h-10 rounded-lg {{ $expense->status == 'approved' ? 'bg-green-50 dark:bg-green-900/20 text-green-600' : 'bg-red-50 dark:bg-red-900/20 text-red-600' }} flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px]">{{ $expense->category->icon ?? 'receipt_long' }}</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-900 dark:text-white text-sm">{{ $expense->title }}</h4>
                        <p class="text-slate-500 text-xs mt-0.5">{{ $expense->vendor ?? '-' }} • {{ \Illuminate\Support\Carbon::parse($expense->expense_date)->format('M d') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="block font-bold text-slate-900 dark:text-white text-sm">₹{{ number_format($expense->amount, 2) }}</span>
                    <span class="{{ $expense->status == 'approved' ? 'text-green-600' : 'text-red-600' }} text-[10px] font-bold uppercase tracking-wide">{{ ucfirst($expense->status) }}</span>
                </div>
            </div>
            @empty
            <div class="text-center text-slate-500 py-8">No history found.</div>
            @endforelse
        </div>
    </main>
    <!-- Floating Create Expense Button -->
        <a href="{{ route('building-admin.expenses.create') }}" class="fixed bottom-20 left-1/2 transform -translate-x-1/2 z-50 bg-primary text-white rounded-lg shadow-lg px-6 py-3 flex items-center gap-2 font-bold text-base hover:bg-primary/90 transition">
            <span class="material-symbols-outlined">add_circle</span>
            Create Expense
        </a>
    @include('building-admin.partials.bottom-nav', ['active' => 'expenses'])
</div>

    <!-- Floating FAB overlayed on nav -->
    <div class="absolute -top-6 left-1/2 -translate-x-1/2">
        <button class="flex items-center justify-center w-14 h-14 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-full shadow-lg shadow-slate-900/20 active:scale-95 transition-transform">
            <span class="material-symbols-outlined text-[28px]">qr_code_scanner</span>
        </button>
    </div>
</nav>
<!-- Safe area spacing for mobile -->
<div class="h-6"></div>
</div>
@endsection
