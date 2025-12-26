@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display min-h-screen flex flex-col antialiased selection:bg-primary/20">
    <div class="flex items-center bg-white dark:bg-[#1e2732] p-4 sticky top-0 z-20 shadow-sm border-b border-[#e5e7eb] dark:border-gray-800">
        <a href="{{ url()->previous() }}" class="text-text-primary dark:text-white flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-neutral-100 dark:hover:bg-gray-800 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div class="ml-4 flex-1 flex flex-col items-center justify-center">
            <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight text-center">Expense Details</h2>
        </div>
    </div>
    <main class="flex-1 flex flex-col pb-24 max-w-lg mx-auto w-full">
        <section class="p-4">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-slate-100 dark:border-slate-700">
                <div class="flex gap-4 items-center mb-4">
                    <div class="w-14 h-14 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[28px]">{{ $expense->category->icon ?? 'receipt_long' }}</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-xl text-slate-900 dark:text-white mb-1">{{ $expense->title }}</h3>
                        <div class="flex items-center gap-2">
                            <span class="bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-semibold px-2 py-0.5 rounded uppercase tracking-wide">{{ $expense->category->name ?? '-' }}</span>
                            <span class="text-slate-400 text-xs">• {{ \Illuminate\Support\Carbon::parse($expense->expense_date)->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                                    @if($expense->file)
                                        <div class="mb-4">
                                            <span class="text-slate-500 dark:text-slate-400 text-xs block mb-1">Bill Attachment:</span>
                                            @if(Str::startsWith($expense->file->file_type, 'image/'))
                                                <a href="{{ asset('storage/' . $expense->file->file_path) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $expense->file->file_path) }}" alt="Bill Image" class="rounded-lg border border-slate-200 dark:border-slate-700 max-h-48 w-auto shadow mb-2">
                                                </a>
                                            @else
                                                <a href="{{ asset('storage/' . $expense->file->file_path) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-100 text-blue-700 text-xs font-semibold shadow hover:bg-blue-200 transition-colors">
                                                    <span class="material-symbols-outlined text-[16px]">attach_file</span>
                                                    View Bill
                                                </a>
                                            @endif
                                            
                                        </div>
                                    @endif
                    <span class="text-slate-500 dark:text-slate-400 text-xs">Vendor:</span>
                    <span class="font-semibold text-slate-900 dark:text-white text-sm">{{ $expense->vendor ?? '-' }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-slate-500 dark:text-slate-400 text-xs">Amount:</span>
                    <span class="font-bold text-lg text-green-700 dark:text-green-400">₹{{ number_format($expense->amount, 2) }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-slate-500 dark:text-slate-400 text-xs">Description:</span>
                    <span class="text-slate-900 dark:text-white text-sm">{{ $expense->description ?? '-' }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-slate-500 dark:text-slate-400 text-xs">Status:</span>
                    <span class="font-semibold text-green-600 text-sm">Approved</span>
                </div>
                <div class="mb-2">
                    <span class="text-slate-500 dark:text-slate-400 text-xs">Approved At:</span>
                    <span class="text-slate-900 dark:text-white text-sm">{{ $expense->approved_at ? \Illuminate\Support\Carbon::parse($expense->approved_at)->format('M d, Y h:i A') : '-' }}</span>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection