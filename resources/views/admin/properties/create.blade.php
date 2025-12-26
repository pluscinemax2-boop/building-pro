<h2>Add Property</h2>

<form action="{{ route('admin.properties.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Property Name" required><br><br>
    <input type="text" name="address" placeholder="Address" required><br><br>
    <input type="text" name="type" placeholder="Type (Apartment, Villa, etc.)"><br><br>
    <input type="number" name="total_floors" placeholder="Total Floors"><br><br>
    <input type="number" name="total_flats" placeholder="Total Flats"><br><br>
    <select name="building_id">
        <option value="">-- Select Building --</option>
        @foreach($buildings as $building)
            <option value="{{ $building->id }}">{{ $building->name }}</option>
        @endforeach
    </select><br><br>
    <button type="submit">Save Property</button>
</form>
<br>
<a href="{{ route('admin.properties.index') }}">⬅ Back</a>
