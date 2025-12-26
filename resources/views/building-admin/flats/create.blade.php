<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flat - Building Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="min-h-screen py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Add New Flat</h1>
                <p class="text-gray-600 text-sm mt-2">Register a new apartment unit</p>
            </div>

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-700 font-medium">Please correct the following errors:</p>
                <ul class="text-red-600 text-sm mt-2 space-y-1">
                    @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="/building-admin/flats" class="space-y-6">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Flat Number *</label>
                        <input type="text" name="flat_number" value="{{ old('flat_number') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="101">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Floor Number *</label>
                        <input type="number" name="floor_number" value="{{ old('floor_number') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="1">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Building</label>
                    <input type="hidden" name="building_id" value="{{ $building->id }}">
                    <div class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-100 text-gray-700">{{ $building->name ?? 'N/A' }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">BHK Type *</label>
                    <select name="bhk" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Select BHK</option>
                        <option value="1BHK">1 BHK</option>
                        <option value="2BHK">2 BHK</option>
                        <option value="3BHK">3 BHK</option>
                        <option value="4BHK">4 BHK</option>
                        <option value="5BHK">5 BHK</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Area (sq ft)</label>
                        <input type="number" name="area" value="{{ old('area') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="1200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Price (Optional)</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="50,00,000">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="vacant">Vacant</option>
                        <option value="occupied">Occupied</option>
                        <option value="maintenance">Under Maintenance</option>
                    </select>
                </div>

                <div class="flex space-x-4 pt-6 border-t">
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i>Add Flat
                    </button>
                    <a href="/building-admin/flats" class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-3 rounded-lg text-center transition">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
