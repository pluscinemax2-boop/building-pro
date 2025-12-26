<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Building</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="bg-gray-50">
<div class="min-h-screen flex items-center justify-center py-12 px-4 bg-gradient-to-br from-purple-100 via-white to-purple-200">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-3xl shadow-2xl p-10 border border-purple-100">
            <div class="mb-8 flex items-center space-x-4">
                <div class="w-14 h-14 rounded-full gradient-primary flex items-center justify-center shadow-lg">
                    <i class="fas fa-building text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-purple-800 tracking-tight">Add New Building</h1>
                    <p class="text-gray-500 text-sm mt-1">Enter building details below</p>
                </div>
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

            <form action="{{ url('admin/buildings') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Building Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Address</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('address') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Total Floors</label>
                        <input type="number" name="total_floors" value="{{ old('total_floors') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Total Flats</label>
                        <input type="number" name="total_flats" value="{{ old('total_flats') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>

                <div class="flex space-x-4 pt-6 border-t">
                    <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-lg transition">
                        <i class="fas fa-plus mr-2"></i>Add Building
                    </button>
                    <a href="{{ url('admin/building-management') }}" class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-3 rounded-lg text-center transition">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
