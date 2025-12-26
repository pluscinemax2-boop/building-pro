<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Dashboard - Stitch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-primary { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
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
                    <p class="text-xs text-gray-500">Resident Portal</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Resident' }}</p>
                    <p class="text-xs text-gray-500">Resident</p>
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
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-lg shadow-lg p-8 text-white mb-8">
            <h1 class="text-3xl font-bold">Welcome back, {{ Auth::user()->name ?? 'Resident' }}!</h1>
            <p class="text-orange-100 mt-2">Your apartment is safe and secure. Report any issues or emergencies below.</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm font-medium">My Complaints</p>
                <h3 class="text-4xl font-bold text-gray-900 mt-2">0</h3>
                <p class="text-xs text-gray-600 mt-2">Total filed complaints</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm font-medium">Open Issues</p>
                <h3 class="text-4xl font-bold text-red-600 mt-2">0</h3>
                <p class="text-xs text-gray-600 mt-2">Awaiting resolution</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm font-medium">Resolved</p>
                <h3 class="text-4xl font-bold text-green-600 mt-2">0</h3>
                <p class="text-xs text-gray-600 mt-2">Completed this month</p>
            </div>
        </div>

        <!-- Main Actions -->
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">What would you like to do?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="/resident/complaints/create" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition border-l-4 border-red-500 group">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-red-200 transition">
                            <i class="fas fa-edit text-red-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">File a Complaint</h3>
                            <p class="text-sm text-gray-600 mt-1">Report maintenance, noise, or any issue in your apartment</p>
                        </div>
                    </div>
                </a>
                <a href="/resident/complaints" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition border-l-4 border-blue-500 group">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-200 transition">
                            <i class="fas fa-list text-blue-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">View My Complaints</h3>
                            <p class="text-sm text-gray-600 mt-1">Check status and updates on your filed complaints</p>
                        </div>
                    </div>
                </a>
                <a href="/resident/emergency" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition border-l-4 border-orange-500 group">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-orange-200 transition">
                            <i class="fas fa-siren text-orange-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Emergency Alert</h3>
                            <p class="text-sm text-gray-600 mt-1">Report any urgent or emergency situation</p>
                        </div>
                    </div>
                </a>
                <a href="/resident/building-info" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition border-l-4 border-green-500 group">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-green-200 transition">
                            <i class="fas fa-info-circle text-green-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Building Information</h3>
                            <p class="text-sm text-gray-600 mt-1">View building details and contact information</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Complaints -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">My Recent Complaints</h3>
                <a href="/resident/complaints" class="text-purple-600 hover:text-purple-700 text-sm font-medium">View All →</a>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr class="hover:bg-gray-50">
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500"><i class="fas fa-inbox text-4xl text-gray-300 mb-4 block"></i>No complaints yet</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
