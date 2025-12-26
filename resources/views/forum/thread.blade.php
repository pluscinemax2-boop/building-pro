@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $thread->title }}</h2>
    <div class="mb-2">
        <span class="text-muted">by {{ $thread->user->name }} in <a href="{{ route('forum.category', $thread->category->id) }}">{{ $thread->category->name }}</a></span>
        <span class="text-muted float-end">{{ $thread->created_at->diffForHumans() }}</span>
    </div>
    <div class="mb-4">{{ $thread->body }}</div>
    <h5>Replies</h5>
    <ul class="list-group mb-3">
        @foreach($thread->replies as $reply)
            <li class="list-group-item">
                <div>{{ $reply->body }}</div>
                <div class="small text-muted">by {{ $reply->user->name }} | {{ $reply->created_at->diffForHumans() }}</div>
            </li>
        @endforeach
    </ul>
    @auth
    <form method="POST" action="{{ route('forum.reply', $thread->id) }}">
        @csrf
        <div class="mb-3">
            <textarea name="body" class="form-control" rows="3" placeholder="Write a reply..." required></textarea>
            @error('body')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Post Reply</button>
    </form>
    @endauth
</div>
@endsection
