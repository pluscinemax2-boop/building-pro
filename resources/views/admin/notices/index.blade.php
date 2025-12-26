<h2>Notice Board</h2>
<a href="{{ route('admin.notices.create') }}">+ Add Notice</a>
<br><br>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
<table border="1" cellpadding="10">
    <tr>
        <th>Title</th>
        <th>Content</th>
        <th>Start</th>
        <th>End</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    @foreach($notices as $notice)
    <tr>
        <td>{{ $notice->title }}</td>
        <td>{{ $notice->content }}</td>
        <td>{{ $notice->start_date }}</td>
        <td>{{ $notice->end_date }}</td>
        <td>
            @if($notice->isExpired())
                <span style="color:red;">Expired</span>
            @elseif(!$notice->is_active)
                <span style="color:gray;">Inactive</span>
            @else
                <span style="color:green;">Active</span>
            @endif
        </td>
        <td>
            <a href="{{ route('admin.notices.edit', $notice->id) }}">Edit</a>
            <form action="{{ route('admin.notices.destroy', $notice->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
