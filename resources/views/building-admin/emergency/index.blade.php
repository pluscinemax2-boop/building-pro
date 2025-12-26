<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Alerts - Building Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="min-h-screen">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Emergency Alerts</h1>
                <p class="text-sm text-gray-500">Send and manage emergency notifications</p>
            </div>
            <a href="/building-admin/emergency/create" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                <i class="fas fa-plus"></i><span>Send Alert</span>
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Total Alerts</p><h3 class="text-3xl font-bold text-gray-900 mt-2">0</h3></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">This Month</p><h3 class="text-3xl font-bold text-red-600 mt-2">0</h3></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Today</p><h3 class="text-3xl font-bold text-orange-600 mt-2">0</h3></div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alert ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sent By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recipients</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr class="hover:bg-gray-50">
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500"><i class="fas fa-bell text-4xl text-gray-300 mb-4 block"></i>No alerts found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
