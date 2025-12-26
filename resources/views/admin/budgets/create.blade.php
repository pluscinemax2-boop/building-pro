<h2>Add Budget</h2>
<form action="{{ route('admin.budgets.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Title" required><br><br>
    <input type="number" step="0.01" name="amount" placeholder="Amount" required><br><br>
    <select name="category_id" required>
        <option value="">-- Select Category --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select><br><br>
    <input type="date" name="start_date" required><br><br>
    <input type="date" name="end_date" required><br><br>
    <button type="submit">Create Budget</button>
</form>
<br>
<a href="{{ route('admin.budgets.index') }}">⬅ Back</a>
