<h2>Edit Property</h2>

<form action="{{ route('admin.properties.update', $property->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{ $property->name }}" required><br><br>
    <input type="text" name="address" value="{{ $property->address }}" required><br><br>
    <input type="text" name="type" value="{{ $property->type }}"><br><br>
    <input type="number" name="total_floors" value="{{ $property->total_floors }}"><br><br>
    <input type="number" name="total_flats" value="{{ $property->total_flats }}"><br><br>
    <select name="building_id">
        <option value="">-- Select Building --</option>
        @foreach($buildings as $building)
            <option value="{{ $building->id }}" {{ $property->building_id == $building->id ? 'selected' : '' }}>{{ $building->name }}</option>
        @endforeach
    </select><br><br>
    <button type="submit">Update Property</button>
</form>
<br>
<a href="{{ route('admin.properties.index') }}">⬅ Back</a>
