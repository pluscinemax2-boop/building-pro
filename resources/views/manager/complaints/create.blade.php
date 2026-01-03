@extends('manager.layout')

@section('title', 'Create Complaint - Manager')

@section('content')
<div class="p-4">
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('manager.complaints.index') }}" class="flex items-center justify-center size-10 rounded-full bg-gray-100 dark:bg-gray-800 text-[#111418] dark:text-white">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold text-[#111418] dark:text-white">Create Complaint</h1>
        <div class="w-10"></div> <!-- Spacer for alignment -->
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
        <form method="POST" action="{{ route('manager.complaints.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-[#111418] dark:text-white">Flat</label>
                <select name="flat_id" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111418] dark:text-white p-2" required>
                    <option value="">Select Flat</option>
                    @foreach($flats as $flat)
                        <option value="{{ $flat->id }}">{{ $flat->flat_number }} (Floor {{ $flat->floor }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-[#111418] dark:text-white">Resident</label>
                <select name="resident_id" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111418] dark:text-white p-2" required>
                    <option value="">Select Resident</option>
                    @foreach($residents as $resident)
                        <option value="{{ $resident->id }}">{{ $resident->name }} (Flat {{ $resident->flat->flat_number ?? '-' }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-[#111418] dark:text-white">Priority</label>
                <select name="priority" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111418] dark:text-white p-2" required>
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-[#111418] dark:text-white">Description</label>
                <textarea name="description" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111418] dark:text-white p-2" rows="3" placeholder="Describe the issue..." required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-[#111418] dark:text-white">Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-600" />
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('manager.complaints.index') }}" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white font-semibold">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white font-semibold">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection