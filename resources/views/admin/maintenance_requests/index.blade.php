<h2>Maintenance Requests</h2>
<a href="{{ route('admin.maintenance_requests.create') }}">+ Add Request</a>
<br><br>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Flat</th>
        <th>Resident</th>
        <th>Title</th>
        <th>Status</th>
        <th>Contractor</th>
        <th>Requested</th>
        <th>Completed</th>
        <th>Action</th>
    </tr>
    @foreach($requests as $req)
    <tr>
        <td>{{ $req->id }}</td>
        <td>{{ $req->flat ? $req->flat->flat_number : '-' }}</td>
        <td>{{ $req->resident ? $req->resident->name : '-' }}</td>
        <td>{{ $req->title }}</td>
        <td>{{ ucfirst($req->status) }}</td>
        <td>{{ $req->contractor ? $req->contractor->name : '-' }}</td>
        <td>{{ $req->requested_date }}</td>
        <td>{{ $req->completed_date ?? '-' }}</td>
        <td>
            <a href="{{ route('admin.maintenance_requests.edit', $req->id) }}">Edit</a>
            <form action="{{ route('admin.maintenance_requests.destroy', $req->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
            <form action="{{ route('admin.maintenance_requests.changeStatus', $req->id) }}" method="POST" style="display:inline;">
                @csrf
                <select name="status" onchange="this.form.submit()">
                    <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $req->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $req->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $req->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
        </td>
    </tr>
    @endforeach
</table>
