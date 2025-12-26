<h2>Add Expense</h2>
<form action="{{ route('admin.expenses.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Title" required><br><br>
    <input type="number" step="0.01" name="amount" placeholder="Amount" required><br><br>
    <select name="category_id" required>
        <option value="">-- Select Category --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select><br><br>
    <input type="date" name="expense_date" required><br><br>
    <textarea name="description" placeholder="Description"></textarea><br><br>
    <button type="submit">Submit Expense</button>
</form>
<br>
<a href="{{ route('admin.expenses.index') }}">⬅ Back</a>
