<h2>Security Activity Logs</h2>

<table border="1" cellpadding="10">
<tr>
<th>ID</th>
<th>User ID</th>
<th>Role</th>
<th>Action</th>
<th>IP</th>
<th>Date</th>
</tr>

@foreach($logs as $log)
<tr>
<td>{{ $log->id }}</td>
<td>{{ $log->user_id }}</td>
<td>{{ $log->role }}</td>
<td>{{ $log->action }}</td>
<td>{{ $log->ip_address }}</td>
<td>{{ $log->created_at }}</td>
</tr>
@endforeach

</table>
