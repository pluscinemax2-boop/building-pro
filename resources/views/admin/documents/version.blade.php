<h2>Upload New Version for {{ $document->name }}</h2>
<form action="{{ route('admin.documents.storeVersion', $document->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required><br><br>
    <button type="submit">Upload New Version</button>
</form>
<br>
<a href="{{ route('admin.documents.index') }}">⬅ Back</a>
