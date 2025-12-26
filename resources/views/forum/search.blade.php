@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Search Forums</h2>
    <form method="GET" action="{{ route('forum.search') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search threads or replies..." value="{{ request('q') }}" required>
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>
    @if(isset($q))
        <h5>Results for "{{ $q }}"</h5>
        <div class="mb-3">
            <strong>Threads:</strong>
            <ul class="list-group mb-2">
                @forelse($threads as $thread)
                    <li class="list-group-item">
                        <a href="{{ route('forum.thread', $thread->id) }}">{{ $thread->title }}</a>
                        <div class="small text-muted">by {{ $thread->user->name }} in {{ $thread->category->name }}</div>
                    </li>
                @empty
                    <li class="list-group-item">No threads found.</li>
                @endforelse
            </ul>
        </div>
        <div>
            <strong>Replies:</strong>
            <ul class="list-group">
                @forelse($replies as $reply)
                    <li class="list-group-item">
                        <div>{{ $reply->body }}</div>
                        <div class="small text-muted">by {{ $reply->user->name }} in <a href="{{ route('forum.thread', $reply->thread->id) }}">{{ $reply->thread->title }}</a></div>
                    </li>
                @empty
                    <li class="list-group-item">No replies found.</li>
                @endforelse
            </ul>
        </div>
    @endif
</div>
@endsection
