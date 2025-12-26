@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Start New Thread in {{ $category->name }}</h2>
    <form method="POST" action="{{ route('forum.store_thread', $category->id) }}">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea name="body" id="body" class="form-control" rows="5" required></textarea>
            @error('body')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Create Thread</button>
        <a href="{{ route('forum.category', $category->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
