<h2>Upload Document</h2>
<form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Document Name" required><br><br>
    <input type="file" name="file" required><br><br>
    <select name="access">
        <option value="private">Private</option>
        <option value="public">Public</option>
        <option value="restricted">Restricted</option>
    </select><br><br>
    <button type="submit">Upload</button>
</form>
<br>
<a href="{{ route('admin.documents.index') }}">⬅ Back</a>
