@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Create Poll</h2>
    <form method="POST" action="{{ route('admin.polls.store') }}">
        @csrf
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <input type="text" name="question" id="question" class="form-control" value="{{ old('question') }}" required>
            @error('question')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Options</label>
            <div id="options-list">
                <input type="text" name="options[]" class="form-control mb-2" placeholder="Option 1" required>
                <input type="text" name="options[]" class="form-control mb-2" placeholder="Option 2" required>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="addOption()">Add Option</button>
            @error('options')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            @error('options.*')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="expires_at" class="form-label">Expires At (optional)</label>
            <input type="datetime-local" name="expires_at" id="expires_at" class="form-control" value="{{ old('expires_at') }}">
            @error('expires_at')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Create Poll</button>
        <a href="{{ route('admin.polls.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script>
function addOption() {
    const optionsList = document.getElementById('options-list');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.className = 'form-control mb-2';
    input.placeholder = 'Option';
    input.required = true;
    optionsList.appendChild(input);
}
</script>
@endsection
