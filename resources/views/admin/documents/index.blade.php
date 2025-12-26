<h2>Documents</h2>
<a href="{{ route('admin.documents.create') }}">+ Upload Document</a>
<br><br>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Size</th>
        <th>Access</th>
        <th>Version</th>
        <th>Uploaded By</th>
        <th>Action</th>
    </tr>
    @foreach($documents as $doc)
    <tr>
        <td>{{ $doc->name }}</td>
        <td>{{ $doc->mime_type }}</td>
        <td>{{ number_format($doc->size/1024, 2) }} KB</td>
        <td>{{ ucfirst($doc->access) }}</td>
        <td>{{ $doc->version }}</td>
        <td>{{ $doc->uploader ? $doc->uploader->name : '-' }}</td>
        <td>
            <a href="{{ route('admin.documents.download', $doc->id) }}">Download</a>
            <a href="{{ route('admin.documents.newVersion', $doc->id) }}">New Version</a>
        </td>
    </tr>
    @endforeach
</table>
