@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Polls</h2>
        <a href="{{ route('admin.polls.create') }}" class="btn btn-primary">Create Poll</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Question</th>
                <th>Options</th>
                <th>Expires At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($polls as $poll)
                <tr>
                    <td>{{ $poll->question }}</td>
                    <td>
                        <ul>
                        @foreach($poll->options as $option)
                            <li>{{ $option->option_text }}</li>
                        @endforeach
                        </ul>
                    </td>
                    <td>{{ $poll->expires_at ? $poll->expires_at->format('Y-m-d H:i') : 'No Expiry' }}</td>
                    <td>
                        <a href="{{ route('admin.polls.show', $poll->id) }}" class="btn btn-sm btn-info">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $polls->links() }}
</div>
@endsection
