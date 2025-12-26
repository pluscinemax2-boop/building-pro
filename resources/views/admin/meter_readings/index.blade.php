<h2>Meter Readings for Flat {{ $flat->flat_number }}</h2>

<a href="{{ route('admin.meter_readings.create', $flat->id) }}">+ Add Meter Reading</a>
<br><br>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
<table border="1" cellpadding="10">
    <tr>
        <th>Date</th>
        <th>Value</th>
        <th>Unit</th>
        <th>Type</th>
        <th>Action</th>
    </tr>
    @foreach($meterReadings as $reading)
    <tr>
        <td>{{ $reading->reading_date }}</td>
        <td>{{ $reading->reading_value }}</td>
        <td>{{ $reading->unit }}</td>
        <td>{{ $reading->type }}</td>
        <td>
            <a href="{{ route('admin.meter_readings.edit', [$flat->id, $reading->id]) }}">Edit</a>
            <form action="{{ route('admin.meter_readings.destroy', [$flat->id, $reading->id]) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
<br>
<a href="{{ url('admin/buildings/'.$flat->building_id.'/flats') }}">⬅ Back to Flats</a>
