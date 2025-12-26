@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $category->name }}</h2>
    <p>{{ $category->description }}</p>
    <a href="{{ route('forum.create_thread', $category->id) }}" class="btn btn-primary mb-3">Start New Thread</a>
    <ul class="list-group">
        @foreach($category->threads as $thread)
            <li class="list-group-item">
                <a href="{{ route('forum.thread', $thread->id) }}">{{ $thread->title }}</a>
                <div class="small text-muted">by {{ $thread->user->name }} | {{ $thread->created_at->diffForHumans() }}</div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
