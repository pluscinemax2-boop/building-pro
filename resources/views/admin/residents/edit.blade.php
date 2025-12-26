<h2>Edit Resident</h2>

<form action="{{ url('admin/resident/'.$resident->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $resident->name }}" required><br><br>
    <input type="email" name="email" value="{{ $resident->email }}"><br><br>
    <input type="text" name="phone" value="{{ $resident->phone }}"><br><br>

    <button type="submit">Update Resident</button>
</form>
