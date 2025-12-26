<h2>Edit Notice</h2>
<form action="{{ route('admin.notices.update', $notice->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="title" value="{{ $notice->title }}" required><br><br>
    <textarea name="content" required>{{ $notice->content }}</textarea><br><br>
    <input type="date" name="start_date" value="{{ $notice->start_date }}"><br><br>
    <input type="date" name="end_date" value="{{ $notice->end_date }}"><br><br>
    <label><input type="checkbox" name="is_active" {{ $notice->is_active ? 'checked' : '' }}> Active</label><br><br>
    <button type="submit">Update Notice</button>
</form>
<br>
<a href="{{ route('admin.notices.index') }}">⬅ Back</a>
