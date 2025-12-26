<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Building Admin Dashboard - Stitch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-primary { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .gradient-info { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
        .feature-icon { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
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
                        <h1 class="text-xl font-bold text-gray-900">Stitch Building Management</h1>
                        <p class="text-xs text-gray-500">Building Admin Dashboard</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Building Admin</p>
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

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                {{ session('success') }}
            </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Building Info Card -->
                <div class="card-hover bg-white rounded-xl shadow p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Building Name</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ Auth::user()->building->name ?? 'N/A' }}</h3>
                            <p class="text-sm text-gray-600 mt-2">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ Auth::user()->building->address ?? 'Address not set' }}
                            </p>
                        </div>
                        <div class="feature-icon bg-blue-100">
                            <i class="fas fa-building text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Subscription Info Card -->
                <div class="card-hover bg-white rounded-xl shadow p-6">
                    @php $subscription = Auth::user()->building->activeSubscription; @endphp
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Active Plan</p>
                            @if($subscription)
                                <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $subscription->plan->name }}</h3>
                                <div class="mt-2 flex items-center space-x-2">
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i>Active
                                    </span>
                                    <span class="text-xs text-gray-600">Until {{ $subscription->end_date->format('d M Y') }}</span>
                                </div>
                            @else
                                <p class="text-2xl font-bold text-red-600 mt-2">No Active Plan</p>
                                <a href="/building-admin/subscription" class="text-xs text-purple-600 hover:text-purple-700 font-bold mt-2 inline-block">Activate Plan →</a>
                            @endif
                        </div>
                        <div class="feature-icon gradient-primary">
                            <i class="fas fa-crown text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card-hover bg-white rounded-xl shadow p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Building Stats</p>
                            <div class="mt-3 space-y-2">
                                <p class="text-sm">
                                    <span class="font-bold text-gray-900">{{ Auth::user()->building->total_flats ?? 0 }}</span>
                                    <span class="text-gray-600">Total Flats</span>
                                </p>
                                <p class="text-sm">
                                    <span class="font-bold text-gray-900">{{ \App\Models\Resident::count() }}</span>
                                    <span class="text-gray-600">Residents</span>
                                </p>
                            </div>
                        </div>
                        <div class="feature-icon gradient-warning">
                            <i class="fas fa-chart-bar text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="/building-admin/flats" class="p-4 bg-white rounded-lg shadow hover:shadow-lg transition text-center group">
                        <div class="feature-icon bg-purple-100 mx-auto mb-2 group-hover:bg-purple-200 transition">
                            <i class="fas fa-home text-purple-600 text-lg"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">Manage Flats</p>
                    </a>
                    <a href="/building-admin/residents" class="p-4 bg-white rounded-lg shadow hover:shadow-lg transition text-center group">
                        <div class="feature-icon bg-green-100 mx-auto mb-2 group-hover:bg-green-200 transition">
                            <i class="fas fa-users text-green-600 text-lg"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">Manage Residents</p>
                    </a>
                    <a href="/building-admin/complaints" class="p-4 bg-white rounded-lg shadow hover:shadow-lg transition text-center group">
                        <div class="feature-icon bg-red-100 mx-auto mb-2 group-hover:bg-red-200 transition">
                            <i class="fas fa-exclamation-circle text-red-600 text-lg"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">Complaints</p>
                    </a>
                    <a href="/building-admin/emergency" class="p-4 bg-white rounded-lg shadow hover:shadow-lg transition text-center group">
                        <div class="feature-icon bg-orange-100 mx-auto mb-2 group-hover:bg-orange-200 transition">
                            <i class="fas fa-bell text-orange-600 text-lg"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">Emergency Alerts</p>
                    </a>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Available Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php
                    $features = [
                        ['icon' => 'fa-building', 'color' => 'blue', 'title' => 'Building Management', 'desc' => 'Update building info and settings'],
                        ['icon' => 'fa-home', 'color' => 'green', 'title' => 'Flat Management', 'desc' => 'Add and manage apartment units'],
                        ['icon' => 'fa-users', 'color' => 'purple', 'title' => 'Resident Management', 'desc' => 'Assign residents to flats'],
                        ['icon' => 'fa-clipboard-list', 'color' => 'red', 'title' => 'Complaint Tracking', 'desc' => 'Track and resolve complaints'],
                        ['icon' => 'fa-siren', 'color' => 'orange', 'title' => 'Emergency Alerts', 'desc' => 'Send emergency notifications'],
                        ['icon' => 'fa-shield-alt', 'color' => 'indigo', 'title' => 'Security & Logs', 'desc' => 'Monitor activity and security'],
                    ];
                    @endphp
                    @foreach($features as $feature)
                    <div class="card-hover bg-white rounded-lg shadow p-6 border-l-4 border-{{ $feature['color'] }}-500">
                        <div class="flex items-start space-x-4">
                            <div class="feature-icon bg-{{ $feature['color'] }}-100 flex-shrink-0">
                                <i class="fas {{ $feature['icon'] }} text-{{ $feature['color'] }}-600 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $feature['title'] }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $feature['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Subscription Upsell (if no active subscription) -->
            @if(!Auth::user()->building->activeSubscription)
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl shadow-lg p-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Unlock All Features</h3>
                        <p class="text-purple-100">Activate a subscription plan to access all premium features</p>
                    </div>
                    <a href="/building-admin/subscription" class="bg-white text-purple-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                        View Plans
                    </a>
                </div>
            </div>
            @endif
        </main>
    </div>
</body>
</html>
