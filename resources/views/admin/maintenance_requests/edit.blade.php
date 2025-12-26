<h2>Edit Maintenance Request</h2>
<form action="{{ route('admin.maintenance_requests.update', $requestItem->id) }}" method="POST">
    @csrf
    @method('PUT')
    <select name="flat_id" required>
        <option value="">-- Select Flat --</option>
        @foreach($flats as $flat)
            <option value="{{ $flat->id }}" {{ $requestItem->flat_id == $flat->id ? 'selected' : '' }}>{{ $flat->flat_number }}</option>
        @endforeach
    </select><br><br>
    <select name="resident_id">
        <option value="">-- Select Resident --</option>
        @foreach($residents as $resident)
            <option value="{{ $resident->id }}" {{ $requestItem->resident_id == $resident->id ? 'selected' : '' }}>{{ $resident->name }}</option>
        @endforeach
    </select><br><br>
    <input type="text" name="title" value="{{ $requestItem->title }}" required><br><br>
    <textarea name="description">{{ $requestItem->description }}</textarea><br><br>
    <select name="status">
        <option value="pending" {{ $requestItem->status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="in_progress" {{ $requestItem->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
        <option value="completed" {{ $requestItem->status == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ $requestItem->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select><br><br>
    <select name="contractor_id">
        <option value="">-- Assign Contractor --</option>
        @foreach($contractors as $contractor)
            <option value="{{ $contractor->id }}" {{ $requestItem->contractor_id == $contractor->id ? 'selected' : '' }}>{{ $contractor->name }}</option>
        @endforeach
    </select><br><br>
    <input type="date" name="requested_date" value="{{ $requestItem->requested_date }}" required><br><br>
    <input type="date" name="completed_date" value="{{ $requestItem->completed_date }}"><br><br>
    <button type="submit">Update Request</button>
</form>
<br>
<a href="{{ route('admin.maintenance_requests.index') }}">⬅ Back</a>
