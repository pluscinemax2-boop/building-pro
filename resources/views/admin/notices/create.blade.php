<h2>Add Notice</h2>
<form action="{{ route('admin.notices.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Title" required><br><br>
    <textarea name="content" placeholder="Content" required></textarea><br><br>
    <input type="date" name="start_date"><br><br>
    <input type="date" name="end_date"><br><br>
    <label><input type="checkbox" name="is_active" checked> Active</label><br><br>
    <button type="submit">Post Notice</button>
</form>
<br>
<a href="{{ route('admin.notices.index') }}">⬅ Back</a>
