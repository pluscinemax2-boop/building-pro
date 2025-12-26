@extends('building-admin.layout')

@section('content')
<div class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display min-h-screen flex flex-col antialiased selection:bg-primary/20">
    <header class="sticky top-0 z-50 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4 py-3 flex items-center justify-between shadow-sm">
        <a href="{{ route('building-admin.expenses.index') }}" class="p-2 -ml-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-slate-600 dark:text-slate-300">
            <span class="material-symbols-outlined text-[24px]">arrow_back</span>
        </a>
        <h1 class="text-lg font-bold text-slate-900 dark:text-white flex-1 text-center pr-2">Edit Expense</h1>
        <span class="w-8"></span>
    </header>
    <main class="flex-1 flex flex-col pb-24 max-w-lg mx-auto w-full">
        <form action="{{ route('building-admin.expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-xl shadow mt-8">
            @csrf
            @method('PUT')
            <div>
                            <div>
                                <label class="block font-medium mb-1">Vendor</label>
                                <input type="text" name="vendor" class="form-input w-full bg-background-light dark:bg-background-dark border-slate-200 dark:border-slate-700" placeholder="e.g. Vendor Name" value="{{ old('vendor', $expense->vendor) }}">
                            </div>
                <label class="block font-medium mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" class="form-input w-full bg-background-light dark:bg-background-dark border-slate-200 dark:border-slate-700" placeholder="e.g. Lift Repair" required value="{{ old('title', $expense->title) }}">
            </div>
            <div>
                <label class="block font-medium mb-1">Category <span class="text-red-500">*</span></label>
                <select name="category_id" class="form-select w-full bg-background-light dark:bg-background-dark border-slate-200 dark:border-slate-700" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $expense->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium mb-1">Amount <span class="text-red-500">*</span></label>
                <input type="number" name="amount" class="form-input w-full bg-background-light dark:bg-background-dark border-slate-200 dark:border-slate-700" step="0.01" min="0" required value="{{ old('amount', $expense->amount) }}">
            </div>
            <div>
                <label class="block font-medium mb-1">Expense Date <span class="text-red-500">*</span></label>
                <input type="date" name="expense_date" class="form-input w-full bg-background-light dark:bg-background-dark border-slate-200 dark:border-slate-700" required value="{{ old('expense_date', $expense->expense_date ? \Illuminate\Support\Carbon::parse($expense->expense_date)->format('Y-m-d') : '') }}">
            </div>
            <div>
                <label class="block font-medium mb-1">Description</label>
                <textarea name="description" class="form-textarea w-full bg-background-light dark:bg-background-dark border-slate-200 dark:border-slate-700" rows="3" placeholder="Optional">{{ old('description', $expense->description) }}</textarea>
            </div>
            <div>
                <label class="block font-medium mb-1">Bill / Receipt Upload (PDF / Image)</label>
                <input type="file" name="bill" class="form-input w-full bg-background-light dark:bg-background-dark border-slate-200 dark:border-slate-700" accept=".pdf,image/*">
                @if($expense->file)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $expense->file->file_path) }}" target="_blank" class="text-primary underline">View Current Bill/Receipt</a>
                    </div>
                @endif
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('building-admin.expenses.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold hover:bg-slate-200 dark:hover:bg-slate-600 transition">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white font-semibold hover:bg-primary/90 transition">Update</button>
            </div>
        </form>
    </main>
</div>
@endsection
