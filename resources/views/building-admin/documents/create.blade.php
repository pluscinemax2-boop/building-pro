@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Create Document</h1>
    <form action="{{ route('building-admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white dark:bg-gray-900 p-6 rounded shadow">
        @csrf
        <div>
            <label class="block font-medium mb-1">Title</label>
            <input type="text" name="title" class="form-input w-full" required>
        </div>
        <div>
            <label class="block font-medium mb-1">Description</label>
            <textarea name="description" class="form-input w-full" rows="3"></textarea>
        </div>
        <div>
            <label class="block font-medium mb-1">File</label>
            <input type="file" name="file" class="form-input w-full" required>
        </div>
        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create</button>
            <a href="{{ route('building-admin.documents.index') }}" class="ml-4 text-gray-600 hover:text-gray-900">Cancel</a>
        </div>
    </form>
</div>
@endsection
