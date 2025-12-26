<h2>Emergency Alerts</h2>

<a href="{{ url('/admin/emergency/create') }}">+ Send New Alert</a>
<br><br>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
<tr>
<th>ID</th><th>Title</th><th>Type</th><th>Action</th>
</tr>

@foreach($alerts as $a)
<tr>
<td>{{ $a->id }}</td>
<td>{{ $a->title }}</td>
<td>{{ $a->type }}</td>
<td>
<form action="{{ url('/admin/emergency/'.$a->id) }}" method="POST">
@csrf @method('DELETE')
<button>Delete</button>
</form>
</td>
</tr>
@endforeach
</table>
