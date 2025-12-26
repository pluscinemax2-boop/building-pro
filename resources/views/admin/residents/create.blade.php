<h2>Assign Resident to Flat {{ $flat->flat_number }}</h2>

<form action="{{ url('admin/flats/'.$flat->id.'/resident') }}" method="POST">
    @csrf

    <input type="hidden" name="building_id" value="{{ $flat->building_id }}">

    <input type="text" name="name" placeholder="Resident Name" required><br><br>
    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="text" name="phone" placeholder="Phone"><br><br>

    <button type="submit">Assign Resident</button>
</form>

<br>
<a href="{{ url('admin/buildings/'.$flat->building_id.'/flats') }}">⬅ Back</a>
