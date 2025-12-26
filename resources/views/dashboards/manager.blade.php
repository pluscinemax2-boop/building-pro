<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - Stitch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-primary { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
    </style>
</head>
<body class="bg-gray-50">
<div class="min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center text-white font-bold">S</div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Stitch</h1>
                    <p class="text-xs text-gray-500">Manager Dashboard</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Manager' }}</p>
                    <p class="text-xs text-gray-500">Building Manager</p>
                </div>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm font-medium">Open Complaints</p>
                <h3 class="text-4xl font-bold text-gray-900 mt-2">0</h3>
                <p class="text-xs text-red-600 mt-2"><i class="fas fa-arrow-up"></i> Needs attention</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm font-medium">In Progress</p>
                <h3 class="text-4xl font-bold text-blue-600 mt-2">0</h3>
                <p class="text-xs text-gray-600 mt-2">Being resolved</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm font-medium">Resolved This Month</p>
                <h3 class="text-4xl font-bold text-green-600 mt-2">0</h3>
                <p class="text-xs text-gray-600 mt-2">Successfully closed</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm font-medium">Avg Resolution Time</p>
                <h3 class="text-4xl font-bold text-purple-600 mt-2">-</h3>
                <p class="text-xs text-gray-600 mt-2">Hours per complaint</p>
            </div>
        </div>

        <!-- Main Actions -->
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="/manager/complaints" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition text-center group">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-red-200 transition">
                        <i class="fas fa-clipboard-list text-red-600 text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Manage Complaints</h3>
                    <p class="text-sm text-gray-600 mt-1">Track and resolve resident issues</p>
                </a>
                <a href="/manager/emergency" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition text-center group">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-orange-200 transition">
                        <i class="fas fa-siren text-orange-600 text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Emergency Alerts</h3>
                    <p class="text-sm text-gray-600 mt-1">Send emergency notifications</p>
                </a>
                <a href="/manager/reports" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition text-center group">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-200 transition">
                        <i class="fas fa-file-chart-line text-blue-600 text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">View Reports</h3>
                    <p class="text-sm text-gray-600 mt-1">Building activity and analytics</p>
                </a>
            </div>
        </div>

        <!-- Recent Complaints -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-bold text-gray-900">Recent Complaints</h3>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">From</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr class="hover:bg-gray-50">
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No complaints to display</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>