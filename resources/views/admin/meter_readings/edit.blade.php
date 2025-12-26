<h2>Edit Meter Reading for Flat {{ $flat->flat_number }}</h2>

<form action="{{ route('admin.meter_readings.update', [$flat->id, $meterReading->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="date" name="reading_date" value="{{ $meterReading->reading_date }}" required><br><br>
    <input type="number" step="0.01" name="reading_value" value="{{ $meterReading->reading_value }}" required><br><br>
    <input type="text" name="unit" value="{{ $meterReading->unit }}" required><br><br>
    <select name="type">
        <option value="electricity" {{ $meterReading->type == 'electricity' ? 'selected' : '' }}>Electricity</option>
        <option value="water" {{ $meterReading->type == 'water' ? 'selected' : '' }}>Water</option>
        <option value="gas" {{ $meterReading->type == 'gas' ? 'selected' : '' }}>Gas</option>
    </select><br><br>
    <button type="submit">Update Reading</button>
</form>
<br>
<a href="{{ route('admin.meter_readings.index', $flat->id) }}">⬅ Back</a>
