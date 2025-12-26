@extends('building-admin.layout')

@section('content')
<div class="min-h-screen bg-background-light dark:bg-background-dark pb-24">
    <header class="sticky top-0 z-50 bg-white dark:bg-surface-dark/95 backdrop-blur-sm border-b border-border dark:border-gray-800">
        <div class="flex items-center px-4 py-3 relative">
            <a href="{{ url()->previous() }}" class="flex items-center justify-center h-10 w-10 rounded-full hover:bg-background-light dark:hover:bg-gray-800 transition-colors text-text-main dark:text-white mr-2 z-10">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div class="flex-1 flex justify-center absolute left-0 right-0 pointer-events-none">
                <h1 class="text-text-main dark:text-white text-xl font-bold tracking-tight text-center pointer-events-auto">Edit Flat</h1>
            </div>
        </div>
    </header>
    <main class="w-full max-w-md mx-auto flex flex-col gap-4 p-4">
        <form method="POST" action="/building-admin/flats/{{ $flat->id }}" class="bg-white dark:bg-surface-dark rounded-xl p-6 shadow-card border border-border dark:border-gray-700 flex flex-col gap-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-text-main dark:text-white mb-1">Flat Number</label>
                <input type="text" name="flat_number" value="{{ old('flat_number', $flat->flat_number) }}" class="w-full rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-text-main dark:text-white mb-1">Floor Number</label>
                <input type="number" name="floor_number" value="{{ old('floor_number', $flat->floor) }}" class="w-full rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-text-main dark:text-white mb-1">Building</label>
                <input type="hidden" name="building_id" value="{{ $flat->building_id }}">
                <div class="w-full rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-gray-100 dark:bg-gray-800 text-text-main dark:text-white">{{ $flat->building->name ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="block text-sm font-medium text-text-main dark:text-white mb-1">BHK Type</label>
                <select name="bhk" class="w-full rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" required>
                    <option value="">Select BHK</option>
                    <option value="1BHK" {{ old('bhk', $flat->type) == '1BHK' ? 'selected' : '' }}>1 BHK</option>
                    <option value="2BHK" {{ old('bhk', $flat->type) == '2BHK' ? 'selected' : '' }}>2 BHK</option>
                    <option value="3BHK" {{ old('bhk', $flat->type) == '3BHK' ? 'selected' : '' }}>3 BHK</option>
                    <option value="4BHK" {{ old('bhk', $flat->type) == '4BHK' ? 'selected' : '' }}>4 BHK</option>
                    <option value="5BHK" {{ old('bhk', $flat->type) == '5BHK' ? 'selected' : '' }}>5 BHK</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-text-main dark:text-white mb-1">Area (sq ft)</label>
                <input type="number" name="area" value="{{ old('area', $flat->area ?? '') }}" class="w-full rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" placeholder="1200">
            </div>
            <div>
                <label class="block text-sm font-medium text-text-main dark:text-white mb-1">Price (Optional)</label>
                <input type="number" name="price" value="{{ old('price', $flat->price ?? '') }}" class="w-full rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none" placeholder="50,00,000">
            </div>
            <div>
                <label class="block text-sm font-medium text-text-main dark:text-white mb-1">Status</label>
                <select name="status" class="w-full rounded-lg border border-border dark:border-gray-700 px-4 py-3 bg-white dark:bg-surface-dark text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none">
                    <option value="vacant" {{ old('status', $flat->status) == 'vacant' ? 'selected' : '' }}>Vacant</option>
                    <option value="occupied" {{ old('status', $flat->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="maintenance" {{ old('status', $flat->status) == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-primary hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-bold">Update Flat</button>
            </div>
        </form>
    </main>
</div>
@endsection
