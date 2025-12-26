<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buildings - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="bg-gray-50">
<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg overflow-y-auto">
        <div class="p-6 border-b">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center text-white font-bold">S</div>
                <div><h1 class="font-bold text-gray-900">Stitch</h1></div>
            </div>
        </div>
        <nav class="mt-8 px-4 space-y-2">
            <a href="/admin/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100">
                <i class="fas fa-chart-line"></i><span>Dashboard</span>
            </a>
            <a href="/admin/buildings" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-gray-100 border-l-4 border-purple-600">
                <i class="fas fa-building text-purple-600"></i><span class="font-medium">Buildings</span>
            </a>
            <a href="/admin/users" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100">
                <i class="fas fa-users"></i><span>Users</span>
            </a>
            <a href="/admin/subscriptions" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100">
                <i class="fas fa-credit-card"></i><span>Subscriptions</span>
            </a>
        </nav>
        <div class="absolute bottom-4 left-4 right-4">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-600 hover:text-red-600">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <header class="bg-white shadow-sm border-b sticky top-0 z-40">
            <div class="px-8 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Buildings Management</h2>
                    <p class="text-sm text-gray-500">Manage all registered buildings</p>
                </div>
                <div class="flex items-center space-x-4">
                    <input type="text" placeholder="Search..." class="bg-gray-100 px-4 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 w-64">
                    <a href="{{ url('admin/buildings/create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                        <i class="fas fa-plus"></i><span>Add Building</span>
                    </a>
                </div>
            </div>
        </header>

        <main class="p-8">
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 flex items-center">
                <i class="fas fa-check-circle mr-3"></i>{{ session('success') }}
            </div>
            @endif

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Total Buildings</p><h3 class="text-3xl font-bold text-gray-900 mt-2">{{ count($buildings) ?? 0 }}</h3></div>
                <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Active</p><h3 class="text-3xl font-bold text-green-600 mt-2">{{ $buildings->where('status', 'active')->count() ?? 0 }}</h3></div>
                <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Inactive</p><h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $buildings->where('status', 'inactive')->count() ?? 0 }}</h3></div>
                <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">With Subscriptions</p><h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $buildings->filter(fn($b) => $b->activeSubscription)->count() ?? 0 }}</h3></div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Building</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Admin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Flats</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subscription</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($buildings as $building)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $building->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $building->admin->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $building->address ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $building->total_flats ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($building->activeSubscription)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">{{ $building->activeSubscription->plan->name }}</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">None</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 {{ $building->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full text-xs font-semibold">{{ ucfirst($building->status) }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ url('admin/buildings/'.$building->id.'/edit') }}" class="text-purple-600 hover:underline">Edit</a>
                                <form action="{{ url('admin/buildings/'.$building->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500"><i class="fas fa-inbox text-4xl text-gray-300 mb-4 block"></i>No buildings found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
</body>
</html>
