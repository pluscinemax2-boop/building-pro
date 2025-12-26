<h2>Edit Flat - {{ $building->name }}</h2>

<form action="{{ url('admin/buildings/'.$building->id.'/flats/'.$flat->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="flat_number" value="{{ $flat->flat_number }}" required><br><br>
    <input type="number" name="floor" value="{{ $flat->floor }}"><br><br>
    <input type="text" name="type" value="{{ $flat->type }}"><br><br>

    <select name="status">
        <option value="Available" {{ $flat->status == 'Available' ? 'selected' : '' }}>Available</option>
        <option value="Occupied" {{ $flat->status == 'Occupied' ? 'selected' : '' }}>Occupied</option>
    </select><br><br>

    <button type="submit">Update Flat</button>
</form>

<br>
<a href="{{ url('admin/buildings/'.$building->id.'/flats') }}">⬅ Back</a>
