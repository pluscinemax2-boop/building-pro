<h2>Edit Contractor</h2>
<form action="{{ route('admin.contractors.update', $contractor->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{ $contractor->name }}" required><br><br>
    <input type="text" name="phone" value="{{ $contractor->phone }}"><br><br>
    <input type="email" name="email" value="{{ $contractor->email }}"><br><br>
    <input type="text" name="specialization" value="{{ $contractor->specialization }}"><br><br>
    <select name="status">
        <option value="active" {{ $contractor->status == 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ $contractor->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select><br><br>
    <button type="submit">Update Contractor</button>
</form>
<br>
<a href="{{ route('admin.contractors.index') }}">⬅ Back</a>
