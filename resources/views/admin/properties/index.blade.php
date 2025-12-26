<h2>Properties</h2>

<a href="{{ route('admin.properties.create') }}">+ Add Property</a>
<br><br>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>Type</th>
        <th>Total Floors</th>
        <th>Total Flats</th>
        <th>Building</th>
        <th>Action</th>
    </tr>
    @foreach($properties as $property)
    <tr>
        <td>{{ $property->id }}</td>
        <td>{{ $property->name }}</td>
        <td>{{ $property->address }}</td>
        <td>{{ $property->type }}</td>
        <td>{{ $property->total_floors }}</td>
        <td>{{ $property->total_flats }}</td>
        <td>{{ $property->building ? $property->building->name : '-' }}</td>
        <td>
            <a href="{{ route('admin.properties.edit', $property->id) }}">Edit</a>
            <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
