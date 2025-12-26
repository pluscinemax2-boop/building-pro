<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Emergency Alert - Building Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="min-h-screen py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Send Emergency Alert</h1>
                <p class="text-gray-600 text-sm mt-2">Notify all residents about urgent situations</p>
            </div>

            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <i class="fas fa-warning text-red-600 mr-2"></i>
                <span class="text-red-700">Emergency alerts will be sent to all residents immediately</span>
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

            <form method="POST" action="/building-admin/emergency" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Alert Category *</label>
                    <select name="category" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="">Select a category</option>
                        <option value="fire">Fire Alert</option>
                        <option value="medical">Medical Emergency</option>
                        <option value="security">Security Alert</option>
                        <option value="water">Water Supply Issue</option>
                        <option value="power">Power Outage</option>
                        <option value="maintenance">Maintenance Alert</option>
                        <option value="other">Other Emergency</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Brief alert title">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Message *</label>
                    <textarea name="message" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Detailed alert message">{{ old('message') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Send To</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="send_to[]" value="all" checked class="w-4 h-4 rounded focus:ring-red-500">
                            <span class="ml-2 text-gray-900">All Residents</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="send_to[]" value="building_admin" class="w-4 h-4 rounded focus:ring-red-500">
                            <span class="ml-2 text-gray-900">Building Admin</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="send_to[]" value="manager" class="w-4 h-4 rounded focus:ring-red-500">
                            <span class="ml-2 text-gray-900">Manager</span>
                        </label>
                    </div>
                </div>

                <div class="flex space-x-4 pt-6 border-t">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition">
                        <i class="fas fa-bell mr-2"></i>Send Alert
                    </button>
                    <a href="/building-admin/emergency" class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-3 rounded-lg text-center transition">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
