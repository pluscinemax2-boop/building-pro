<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Complaints - Resident</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="min-h-screen">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">My Complaints</h1>
                <p class="text-sm text-gray-500">Track the status of all your complaints</p>
            </div>
            <a href="/resident/complaints/create" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                <i class="fas fa-plus"></i><span>File New Complaint</span>
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filter -->
        <div class="mb-6">
            <select class="bg-white px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option>All Complaints</option>
                <option>Open</option>
                <option>In Progress</option>
                <option>Resolved</option>
            </select>
        </div>

        <!-- Complaints List -->
        <div class="space-y-4">
            <!-- No Complaints Message -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No complaints filed</h3>
                <p class="text-gray-600 mb-6">You haven't filed any complaints yet</p>
                <a href="/resident/complaints/create" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg inline-flex items-center space-x-2">
                    <i class="fas fa-plus"></i><span>File Your First Complaint</span>
                </a>
            </div>
        </div>
    </main>
</div>
</body>
</html>
