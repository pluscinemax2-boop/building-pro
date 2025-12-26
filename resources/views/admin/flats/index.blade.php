<h2>Flats of {{ $building->name }}</h2>

<a href="{{ url('admin/buildings/'.$building->id.'/flats/create') }}">+ Add Flat</a>
<br><br>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Flat No</th>
        <th>Floor</th>
        <th>Type</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($flats as $flat)
    <tr>
        <td>{{ $flat->id }}</td>
        <td>{{ $flat->flat_number }}</td>
        <td>{{ $flat->floor }}</td>
        <td>{{ $flat->type }}</td>
        <td>{{ $flat->status }}</td>
        <td>
            <a href="{{ url('admin/buildings/'.$building->id.'/flats/'.$flat->id.'/edit') }}">Edit</a>

            <form action="{{ url('admin/buildings/'.$building->id.'/flats/'.$flat->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
        <td>
            @if($flat->resident)
            <a href="{{ url('admin/resident/'.$flat->resident->id.'/edit') }}">Edit Resident</a>

                <form action="{{ url('admin/resident/'.$flat->resident->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Remove Resident</button>
                </form>
        @else
            <a href="{{ url('admin/flats/'.$flat->id.'/resident/create') }}">Assign Resident</a>
        @endif
        </td> 
        <td>
            <a href="{{ url('/admin/flats/'.$flat->id.'/complaints') }}">Complaints</a>
        </td>   
    </tr>
    @endforeach
</table>

<br>
<a href="{{ url('admin/buildings') }}">⬅ Back to Buildings</a>
