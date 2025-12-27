@extends('building-admin.layout')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-background-light dark:bg-background-dark">
    <div class="max-w-xl w-full bg-white dark:bg-surface-dark rounded-xl shadow-md p-8 border border-border dark:border-gray-800">
        <h1 class="text-2xl font-bold text-text-main dark:text-white mb-4">Edit Notice</h1>
        <form method="POST" action="{{ route('building-admin.notices.update', $notice->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!--
            <div class="mb-4">
                <label class="block text-xs font-medium mb-1 text-text-main dark:text-white">Image (optional, max 10MB)</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded border border-border dark:border-gray-700 px-2 py-1 text-sm bg-white dark:bg-surface-dark text-text-main dark:text-white" maxlength="10485760">
                @if($notice->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $notice->image) }}" alt="Notice Image" class="w-32 h-32 object-cover rounded">
                    </div>
                @elseif(isset($notice->image_url))
                    <div class="mt-2">
                        <img src="{{ $notice->image_url }}" alt="Notice Image" class="w-32 h-32 object-cover rounded">
                    </div>
                @endif
            </div>
            -->
            <div class="mb-4 text-left">
                <label class="block text-sm font-medium mb-1 text-text-main dark:text-white">Title</label>
                <input type="text" name="title" value="{{ old('title', $notice->title) }}" class="w-full rounded border border-border dark:border-gray-700 px-3 py-2 text-sm bg-white dark:bg-surface-dark text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/20" required>
            </div>
            <div class="mb-4 text-left">
                <label class="block text-sm font-medium mb-1 text-text-main dark:text-white">Body</label>
                <textarea name="body" rows="5" class="w-full rounded border border-border dark:border-gray-700 px-3 py-2 text-sm bg-white dark:bg-surface-dark text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/20" required>{{ old('body', $notice->body) }}</textarea>
            </div>
            <div class="mb-4 flex gap-4">
                <div class="flex-1">
                    <label class="block text-xs font-medium mb-1 text-text-main dark:text-white">Visible From</label>
                    <input type="date" name="visible_from" value="{{ old('visible_from', $notice->visible_from ? (\Illuminate\Support\Carbon::parse($notice->visible_from)->format('Y-m-d')) : '') }}" class="w-full rounded border border-border dark:border-gray-700 px-2 py-1 text-sm bg-white dark:bg-surface-dark text-text-main dark:text-white" required>
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-medium mb-1 text-text-main dark:text-white">Visible To</label>
                    <input type="date" name="visible_to" value="{{ old('visible_to', $notice->visible_to ? (\Illuminate\Support\Carbon::parse($notice->visible_to)->format('Y-m-d')) : '') }}" class="w-full rounded border border-border dark:border-gray-700 px-2 py-1 text-sm bg-white dark:bg-surface-dark text-text-main dark:text-white" required>
                </div>
            </div>
            <button type="submit" class="w-full rounded-full bg-primary text-white font-semibold py-2.5 mt-2 hover:bg-primary/90 transition-colors">Update Notice</button>
        </form>
    </div>
</div>
@endsection
