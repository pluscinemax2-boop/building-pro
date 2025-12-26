<h2>Add Meter Reading for Flat {{ $flat->flat_number }}</h2>

<form action="{{ route('admin.meter_readings.store', $flat->id) }}" method="POST">
    @csrf
    <input type="date" name="reading_date" required><br><br>
    <input type="number" step="0.01" name="reading_value" placeholder="Reading Value" required><br><br>
    <input type="text" name="unit" value="kWh" required><br><br>
    <select name="type">
        <option value="electricity">Electricity</option>
        <option value="water">Water</option>
        <option value="gas">Gas</option>
    </select><br><br>
    <button type="submit">Save Reading</button>
</form>
<br>
<a href="{{ route('admin.meter_readings.index', $flat->id) }}">⬅ Back</a>
