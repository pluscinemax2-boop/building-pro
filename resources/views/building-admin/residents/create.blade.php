<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Resident - Building Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="min-h-screen py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Add New Resident</h1>
                <p class="text-gray-600 text-sm mt-2">Register a resident in your building</p>
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

            <form method="POST" action="/building-admin/residents" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Select Flat *</label>
                    <select name="flat_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Choose a flat</option>
                        @foreach($flats as $flat)
                            <option value="{{ $flat->id }}" {{ old('flat_id') == $flat->id ? 'selected' : '' }}>Flat {{ $flat->flat_number }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="john@example.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Mobile Number *</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="+91-9876543210">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Occupancy Date</label>
                    <input type="date" name="occupancy_date" value="{{ old('occupancy_date') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex space-x-4 pt-6 border-t">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i>Add Resident
                    </button>
                    <a href="/building-admin/residents" class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-3 rounded-lg text-center transition">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
