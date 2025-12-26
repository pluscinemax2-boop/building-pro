<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Logs - Building Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="min-h-screen">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Security & Activity Logs</h1>
                <p class="text-sm text-gray-500">Monitor system activity and security events</p>
            </div>
            <div class="flex items-center space-x-4">
                <select class="bg-gray-100 px-4 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>All Events</option>
                    <option>Login</option>
                    <option>Logout</option>
                    <option>Create</option>
                    <option>Edit</option>
                    <option>Delete</option>
                </select>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Total Events</p><h3 class="text-3xl font-bold text-gray-900 mt-2">0</h3></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Today</p><h3 class="text-3xl font-bold text-blue-600 mt-2">0</h3></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">This Week</p><h3 class="text-3xl font-bold text-purple-600 mt-2">0</h3></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Warnings</p><h3 class="text-3xl font-bold text-red-600 mt-2">0</h3></div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr class="hover:bg-gray-50">
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500"><i class="fas fa-shield-alt text-4xl text-gray-300 mb-4 block"></i>No logs found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
