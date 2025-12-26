<h2>Contractors</h2>
<a href="{{ route('admin.contractors.create') }}">+ Add Contractor</a>
<br><br>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Specialization</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    @foreach($contractors as $contractor)
    <tr>
        <td>{{ $contractor->id }}</td>
        <td>{{ $contractor->name }}</td>
        <td>{{ $contractor->phone }}</td>
        <td>{{ $contractor->email }}</td>
        <td>{{ $contractor->specialization }}</td>
        <td>{{ ucfirst($contractor->status) }}</td>
        <td>
            <a href="{{ route('admin.contractors.edit', $contractor->id) }}">Edit</a>
            <form action="{{ route('admin.contractors.destroy', $contractor->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
