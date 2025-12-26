@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Poll Details</h2>
    <div class="mb-3">
        <strong>Question:</strong> {{ $poll->question }}
    </div>
    <div class="mb-3">
        <strong>Expires At:</strong> {{ $poll->expires_at ? $poll->expires_at->format('Y-m-d H:i') : 'No Expiry' }}
    </div>
    <div class="mb-3">
        <strong>Options:</strong>
        <ul>
            @foreach($poll->options as $option)
                <li>
                    {{ $option->option_text }}
                    <span class="badge bg-info">Votes: {{ $option->votes->count() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <a href="{{ route('admin.polls.index') }}" class="btn btn-secondary">Back to Polls</a>
</div>
@endsection
