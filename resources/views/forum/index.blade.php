@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Community Forums</h2>
    <ul class="list-group mt-4">
        @foreach($categories as $category)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('forum.category', $category->id) }}">{{ $category->name }}</a>
                <span class="badge bg-primary rounded-pill">{{ $category->threads_count }} threads</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection
