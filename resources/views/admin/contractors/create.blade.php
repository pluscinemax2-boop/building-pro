<h2>Add Contractor</h2>
<form action="{{ route('admin.contractors.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="text" name="phone" placeholder="Phone"><br><br>
    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="text" name="specialization" placeholder="Specialization"><br><br>
    <select name="status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select><br><br>
    <button type="submit">Save Contractor</button>
</form>
<br>
<a href="{{ route('admin.contractors.index') }}">⬅ Back</a>
