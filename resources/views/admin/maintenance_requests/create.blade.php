<h2>Add Maintenance Request</h2>
<form action="{{ route('admin.maintenance_requests.store') }}" method="POST">
    @csrf
    <select name="flat_id" required>
        <option value="">-- Select Flat --</option>
        @foreach($flats as $flat)
            <option value="{{ $flat->id }}">{{ $flat->flat_number }}</option>
        @endforeach
    </select><br><br>
    <select name="resident_id">
        <option value="">-- Select Resident --</option>
        @foreach($residents as $resident)
            <option value="{{ $resident->id }}">{{ $resident->name }}</option>
        @endforeach
    </select><br><br>
    <input type="text" name="title" placeholder="Title" required><br><br>
    <textarea name="description" placeholder="Description"></textarea><br><br>
    <select name="status">
        <option value="pending">Pending</option>
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>
        <option value="cancelled">Cancelled</option>
    </select><br><br>
    <select name="contractor_id">
        <option value="">-- Assign Contractor --</option>
        @foreach($contractors as $contractor)
            <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
        @endforeach
    </select><br><br>
    <input type="date" name="requested_date" required><br><br>
    <input type="date" name="completed_date"><br><br>
    <button type="submit">Save Request</button>
</form>
<br>
<a href="{{ route('admin.maintenance_requests.index') }}">⬅ Back</a>
