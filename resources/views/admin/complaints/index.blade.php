<h2>Complaints - Flat {{ $flat->flat_number }}</h2>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Resident</th>
    <th>Status</th>
    <th>Action</th>
</tr>

@foreach($complaints as $c)
<tr>
    <td>{{ $c->id }}</td>
    <td>{{ $c->title }}</td>
    <td>{{ $c->resident->name ?? 'N/A' }}</td>
    <td>{{ $c->status }}</td>
    <td>
        <form action="{{ url('/admin/complaints/'.$c->id.'/status') }}" method="POST" style="display:inline;">
            @csrf
            <select name="status">
                <option value="Open" {{ $c->status=='Open'?'selected':'' }}>Open</option>
                <option value="In Progress" {{ $c->status=='In Progress'?'selected':'' }}>In Progress</option>
                <option value="Resolved" {{ $c->status=='Resolved'?'selected':'' }}>Resolved</option>
            </select>
            <button type="submit">Update</button>
        </form>

        <form action="{{ url('/admin/complaints/'.$c->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button>Delete</button>
        </form>
    </td>
</tr>
@endforeach
</table>
