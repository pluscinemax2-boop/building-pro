@extends('building-admin.layout')

@section('content')
<div class="max-w-md mx-auto py-8 px-4">
    <div class="bg-white dark:bg-background-dark rounded-xl shadow p-6">
        <h2 class="text-xl font-bold mb-4 text-center text-text-primary dark:text-white">Add New Complaint</h2>
        <form method="POST" action="{{ route('building-admin.complaints.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-text-primary dark:text-white">Flat</label>
                <select name="flat_id" class="form-select w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:text-white" required>
                    <option value="">Select Flat</option>
                    @foreach($flats as $flat)
                        <option value="{{ $flat->id }}">{{ $flat->flat_number }} (Floor {{ $flat->floor }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-text-primary dark:text-white">Resident</label>
                <select name="resident_id" class="form-select w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:text-white" required>
                    <option value="">Select Resident</option>
                    @foreach($residents as $resident)
                        <option value="{{ $resident->id }}">{{ $resident->name }} (Flat {{ $resident->flat->flat_number ?? '-' }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-text-primary dark:text-white">Category</label>
                <select name="category" class="form-select w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:text-white">
                    <option value="Maintenance">Maintenance</option>
                    <option value="Security">Security</option>
                    <option value="Cleanliness">Cleanliness</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-text-primary dark:text-white">Priority</label>
                <select name="priority" class="form-select w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:text-white" required>
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-text-primary dark:text-white">Description</label>
                <textarea name="description" class="form-input w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:text-white" rows="3" placeholder="Describe the issue..." required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-text-primary dark:text-white">Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-600" />
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('building-admin.complaints.index') }}" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white font-semibold">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white font-semibold">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
