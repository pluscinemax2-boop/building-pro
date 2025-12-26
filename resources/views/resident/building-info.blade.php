<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Building Information - Resident</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="min-h-screen">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-2xl font-bold text-gray-900">Building Information</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Building Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Building Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4"><i class="fas fa-building mr-2"></i>Building Details</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Building Name</p>
                        <p class="text-lg font-semibold text-gray-900">Golden Heights</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Address</p>
                        <p class="text-lg font-semibold text-gray-900">123 Main Street, City</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Flats</p>
                        <p class="text-lg font-semibold text-gray-900">50</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Occupancy Rate</p>
                        <p class="text-lg font-semibold text-green-600">92%</p>
                    </div>
                </div>
            </div>

            <!-- Quick Contacts -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4"><i class="fas fa-phone-alt mr-2"></i>Important Contacts</h2>
                <div class="space-y-4">
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-600">Building Admin</p>
                        <p class="text-lg font-semibold text-gray-900">+91-9876543210</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <p class="text-sm text-gray-600">24/7 Security</p>
                        <p class="text-lg font-semibold text-gray-900">+91-9876543210</p>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-lg">
                        <p class="text-sm text-gray-600">Maintenance</p>
                        <p class="text-lg font-semibold text-gray-900">+91-9876543210</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Amenities -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4"><i class="fas fa-star mr-2"></i>Building Amenities</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-pool text-blue-600 text-xl"></i>
                    <span class="font-medium text-gray-900">Swimming Pool</span>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-dumbbell text-red-600 text-xl"></i>
                    <span class="font-medium text-gray-900">Gym & Fitness</span>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-children text-green-600 text-xl"></i>
                    <span class="font-medium text-gray-900">Kids Play Area</span>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-utensils text-orange-600 text-xl"></i>
                    <span class="font-medium text-gray-900">Community Hall</span>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-car text-purple-600 text-xl"></i>
                    <span class="font-medium text-gray-900">Parking</span>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-wifi text-indigo-600 text-xl"></i>
                    <span class="font-medium text-gray-900">High Speed WiFi</span>
                </div>
            </div>
        </div>

        <!-- Building Rules -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4"><i class="fas fa-rules mr-2"></i>Building Rules & Guidelines</h2>
            <ul class="space-y-3 text-gray-700">
                <li class="flex items-start"><i class="fas fa-check text-green-600 mr-3 mt-1"></i><span>Maintenance fee must be paid by the 5th of each month</span></li>
                <li class="flex items-start"><i class="fas fa-check text-green-600 mr-3 mt-1"></i><span>Quiet hours are from 10 PM to 7 AM</span></li>
                <li class="flex items-start"><i class="fas fa-check text-green-600 mr-3 mt-1"></i><span>No loud music or parties without prior permission</span></li>
                <li class="flex items-start"><i class="fas fa-check text-green-600 mr-3 mt-1"></i><span>Common areas must be kept clean</span></li>
                <li class="flex items-start"><i class="fas fa-check text-green-600 mr-3 mt-1"></i><span>Visitors must be registered at the gate</span></li>
                <li class="flex items-start"><i class="fas fa-check text-green-600 mr-3 mt-1"></i><span>Pet ownership requires prior approval</span></li>
            </ul>
        </div>
    </main>
</div>
</body>
</html>
