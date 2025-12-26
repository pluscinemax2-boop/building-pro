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
