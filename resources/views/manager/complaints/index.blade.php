<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints - Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="min-h-screen">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">All Complaints</h1>
                <p class="text-sm text-gray-500">Manage complaints across all buildings</p>
            </div>
            <div class="flex items-center space-x-4">
                <select class="bg-gray-100 px-4 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>All Status</option>
                    <option>Open</option>
                    <option>In Progress</option>
                    <option>Resolved</option>
                </select>
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
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Total Complaints</p><h3 class="text-3xl font-bold text-gray-900 mt-2">{{ count($complaints) ?? 0 }}</h3></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Open</p><h3 class="text-3xl font-bold text-red-600 mt-2">0</h3></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">In Progress</p><h3 class="text-3xl font-bold text-orange-600 mt-2">0</h3></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Resolved</p><h3 class="text-3xl font-bold text-green-600 mt-2">0</h3></div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Building</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Flat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Resident</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($complaints as $c)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $c->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $c->building->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $c->flat->flat_number ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $c->resident->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $c->title }}</td>
                        <td class="px-6 py-4 text-sm">
                            <form action="{{ url('/manager/complaints/'.$c->id.'/status') }}" method="POST" class="inline">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-xs font-semibold rounded-full px-3 py-1 {{ $c->status === 'Open' ? 'bg-red-100 text-red-800' : ($c->status === 'In Progress' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                                    <option value="Open" {{ $c->status === 'Open' ? 'selected' : '' }}>Open</option>
                                    <option value="In Progress" {{ $c->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Resolved" {{ $c->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $c->created_at->format('d M Y') ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm"><a href="#" class="text-blue-600 hover:underline">View</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500"><i class="fas fa-inbox text-4xl text-gray-300 mb-4 block"></i>No complaints to display</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
