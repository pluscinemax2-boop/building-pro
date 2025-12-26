<h2>Add Flat in {{ $building->name }}</h2>

<form action="{{ url('admin/buildings/'.$building->id.'/flats') }}" method="POST">
    @csrf

    <input type="text" name="flat_number" placeholder="Flat Number" required><br><br>
    <input type="number" name="floor" placeholder="Floor"><br><br>
    <input type="text" name="type" placeholder="Type (1BHK, 2BHK, Shop)"><br><br>

    <select name="status">
        <option value="Available">Available</option>
        <option value="Occupied">Occupied</option>
    </select><br><br>

    <button type="submit">Save Flat</button>
</form>

<br>
<a href="{{ url('admin/buildings/'.$building->id.'/flats') }}">⬅ Back</a>
