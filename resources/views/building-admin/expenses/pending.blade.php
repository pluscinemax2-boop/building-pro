@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display min-h-screen flex flex-col antialiased selection:bg-primary/20">
    <div class="flex items-center bg-white dark:bg-[#1e2732] p-4 sticky top-0 z-20 shadow-sm border-b border-[#e5e7eb] dark:border-gray-800">
        <a href="{{ route('building-admin.expenses.index') }}" class="text-text-primary dark:text-white flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-neutral-100 dark:hover:bg-gray-800 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div class="ml-4 flex-1 flex flex-col items-center justify-center">
            <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight text-center">Pending Expenses</h2>
        </div>
    </div>
    <main class="flex-1 flex flex-col pb-24 max-w-lg mx-auto w-full">
        <section class="p-4">
            <h3 class="text-slate-900 dark:text-white font-bold text-lg mb-4">All Pending Expenses</h3>
            <div class="flex flex-col gap-3">
                @forelse($expenses as $expense)
                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-sm border border-slate-100 dark:border-slate-700 flex justify-between items-center opacity-80">
                    <div class="flex gap-3 items-center">
                        <div class="w-10 h-10 rounded-lg bg-orange-50 dark:bg-orange-900/20 text-orange-600 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[20px]">{{ $expense->category->icon ?? 'receipt_long' }}</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-white text-sm">{{ $expense->title }}</h4>
                            <p class="text-slate-500 text-xs mt-0.5">{{ $expense->vendor ?? '-' }} • {{ \Illuminate\Support\Carbon::parse($expense->expense_date)->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="block font-bold text-slate-900 dark:text-white text-sm">₹{{ number_format($expense->amount, 2) }}</span>
                        <span class="text-orange-600 text-[10px] font-bold uppercase tracking-wide">Pending</span>
                        <form method="POST" action="{{ route('building-admin.expenses.approve', $expense->id) }}">
                            @csrf
                            <button type="submit" class="bg-primary text-white px-3 py-1 rounded-lg text-xs font-semibold shadow hover:bg-primary-dark transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                Approve
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center text-slate-500 py-8">No pending expenses found.</div>
                @endforelse
                <div class="mt-6 flex justify-center">
                    {{ $expenses->links() }}
                </div>
            </div>
        </section>
    </main>
</div>
@endsection