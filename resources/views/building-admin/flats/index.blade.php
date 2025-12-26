<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Flats - Building Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-primary { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    </style>
</head>
<body class="bg-gray-50">
<div class="min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manage Flats</h1>
                <p class="text-sm text-gray-500">Manage all apartment units in your building</p>
            </div>
            <div class="flex items-center space-x-4">
                <input type="text" placeholder="Search flats..." class="bg-gray-100 px-4 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 w-64">
                <a href="/building-admin/flats/create" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                    <i class="fas fa-plus"></i><span>Add Flat</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 flex items-center">
            <i class="fas fa-check-circle mr-3"></i>{{ session('success') }}
        </div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            @php
                $totalFlats = $flats->count();
                $occupied = $flats->where('status', 'occupied')->count();
                $vacant = $flats->where('status', 'vacant')->count();
                $occupancyRate = $totalFlats > 0 ? round(($occupied / $totalFlats) * 100) : 0;
            @endphp
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-gray-500 text-sm">Total Flats</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalFlats }}</h3>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-gray-500 text-sm">Occupied</p>
                <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $occupied }}</h3>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-gray-500 text-sm">Vacant</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $vacant }}</h3>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-gray-500 text-sm">Occupancy Rate</p>
                <h3 class="text-3xl font-bold text-purple-600 mt-2">{{ $occupancyRate }}%</h3>
            </div>
        </div>

        <!-- Flats Grid -->
        @if($flats->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($flats as $flat)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Flat No. {{ $flat->flat_number }}</h3>
                        <p class="text-sm text-gray-600">Floor {{ $flat->floor }}</p>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">{{ ucfirst($flat->status) }}</span>
                </div>
                <div class="border-t pt-4 space-y-2 text-sm">
                    <p><span class="font-medium text-gray-900">BHK:</span> <span class="text-gray-600">{{ $flat->type }}</span></p>
                    <!-- Add more fields as needed -->
                </div>
                <div class="flex space-x-2 mt-4 pt-4 border-t">
                    <a href="/building-admin/flats/{{ $flat->id }}/edit" class="flex-1 text-center px-3 py-2 bg-purple-100 text-purple-600 rounded hover:bg-purple-200 text-sm font-medium">Edit</a>
                    <form action="/building-admin/flats/{{ $flat->id }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this flat?')" class="w-full px-3 py-2 bg-red-100 text-red-600 rounded hover:bg-red-200 text-sm font-medium">Delete</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-home text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No flats found</h3>
            <p class="text-gray-600 mb-6">Start by adding your first flat</p>
            <a href="/building-admin/flats/create" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg inline-flex items-center space-x-2">
                <i class="fas fa-plus"></i><span>Add Flat</span>
            </a>
        </div>
        @endif
    </main>
</div>
</body>
</html>
