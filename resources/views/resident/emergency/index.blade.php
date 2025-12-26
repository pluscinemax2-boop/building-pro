<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Alerts - Resident</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="min-h-screen">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Emergency Alerts & Notifications</h1>
                <p class="text-sm text-gray-500">Important building announcements and alerts</p>
            </div>
            <a href="/resident/emergency/report" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                <i class="fas fa-siren"></i><span>Report Emergency</span>
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alert Boxes -->
        @if(isset($alerts) && count($alerts) > 0)
            @foreach($alerts as $alert)
            <div class="mb-6 p-6 bg-red-50 border-l-4 border-red-500 rounded-lg">
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-siren text-red-600"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">{{ $alert->title ?? 'Emergency Alert' }}</h3>
                        <p class="text-gray-700 mt-2">{{ $alert->message }}</p>
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-clock mr-1"></i>{{ $alert->created_at->diffForHumans() ?? 'Just now' }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-bell text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No active alerts</h3>
            <p class="text-gray-600">All is well in your building. Important alerts will appear here.</p>
        </div>
        @endif

        <!-- Important Contacts -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-bold text-blue-900 mb-4"><i class="fas fa-phone-alt mr-2"></i>Emergency Contacts</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg p-4">
                    <p class="text-sm text-gray-600">Building Management</p>
                    <p class="text-xl font-bold text-gray-900 mt-1">+91-XXXXXXXXXX</p>
                </div>
                <div class="bg-white rounded-lg p-4">
                    <p class="text-sm text-gray-600">Security</p>
                    <p class="text-xl font-bold text-gray-900 mt-1">+91-XXXXXXXXXX</p>
                </div>
                <div class="bg-white rounded-lg p-4">
                    <p class="text-sm text-gray-600">Maintenance</p>
                    <p class="text-xl font-bold text-gray-900 mt-1">+91-XXXXXXXXXX</p>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
