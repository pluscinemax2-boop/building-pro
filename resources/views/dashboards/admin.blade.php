<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Stitch Building Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .gradient-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .sidebar-active { background-color: #f3f4f6; border-left: 4px solid #667eea; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6 border-b">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center text-white font-bold text-lg">S</div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">Stitch</h1>
                        <p class="text-xs text-gray-500">Building Management</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="mt-8 px-4 space-y-2">
                <a href="/admin/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->is('admin/dashboard') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-chart-line text-purple-600"></i>
                    <span class="font-medium text-gray-900">Dashboard</span>
                </a>
                <a href="/admin/buildings" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->is('admin/buildings*') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-building"></i>
                    <span>Buildings</span>
                </a>
                <a href="/admin/users" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->is('admin/users*') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <a href="/admin/subscriptions" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->is('admin/subscriptions*') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-credit-card"></i>
                    <span>Subscriptions</span>
                </a>
                <a href="/admin/reports" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->is('admin/reports*') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-file-chart-line"></i>
                    <span>Reports</span>
                </a>
                <a href="/admin/security-logs" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->is('admin/security-logs*') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-shield-alt"></i>
                    <span>Security Logs</span>
                </a>
                <a href="/admin/settings" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->is('admin/settings*') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="absolute bottom-4 left-4 right-4">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600 transition">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="px-8 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
                        <p class="text-sm text-gray-500 mt-1">Welcome back, {{ Auth::user()->name }}</p>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="bg-gray-100 px-4 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <button class="relative p-2 text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1 -translate-y-1 gradient-danger rounded-full">5</span>
                        </button>
                        <div class="flex items-center space-x-3 border-l pl-6">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->role->name }}</p>
                            </div>
                            <div class="w-10 h-10 bg-purple-200 rounded-full flex items-center justify-center">
                                <span class="font-bold text-purple-600">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-8">
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    {{ session('success') }}
                </div>
                @endif

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total Buildings -->
                    <div class="card-hover bg-white rounded-xl shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Total Buildings</p>
                                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Building::count() }}</h3>
                                <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up"></i> 12% from last month</p>
                            </div>
                            <div class="w-12 h-12 gradient-primary rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Users -->
                    <div class="card-hover bg-white rounded-xl shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Total Users</p>
                                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\User::count() }}</h3>
                                <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up"></i> 8% from last month</p>
                            </div>
                            <div class="w-12 h-12 gradient-success rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Active Subscriptions -->
                    <div class="card-hover bg-white rounded-xl shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Active Subscriptions</p>
                                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Subscription::where('status', 'active')->count() }}</h3>
                                <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up"></i> 5% from last month</p>
                            </div>
                            <div class="w-12 h-12 gradient-warning rounded-lg flex items-center justify-center">
                                <i class="fas fa-credit-card text-white text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Revenue -->
                    <div class="card-hover bg-white rounded-xl shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Monthly Revenue</p>
                                <h3 class="text-3xl font-bold text-gray-900 mt-2">₹{{ number_format(\App\Models\Subscription::where('status', 'active')->sum('total_amount'), 0) }}</h3>
                                <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up"></i> 15% from last month</p>
                            </div>
                            <div class="w-12 h-12 gradient-danger rounded-lg flex items-center justify-center">
                                <i class="fas fa-indian-rupee-sign text-white text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Building Growth Chart -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Building Growth</h3>
                        <div class="h-64 bg-white rounded-lg flex flex-col items-center justify-center">
                            <canvas id="paymentsChart" class="w-full h-64"></canvas>
                            <div id="apexComplaintsChart" class="w-full h-64 mt-6"></div>
                        </div>
                    </main>
                    <!-- Chart.js & ApexCharts Scripts -->
                    <script src="/node_modules/chart.js/dist/chart.umd.js"></script>
                    <script src="/node_modules/apexcharts/dist/apexcharts.min.js"></script>
                    <script>
                    fetch('/analytics/dashboard')
                        .then(res => res.json())
                        .then(data => {
                            // Chart.js Payments Line Chart
                            const ctx = document.getElementById('paymentsChart').getContext('2d');
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: data.payments.map(p => p.date),
                                    datasets: [{
                                        label: 'Payments',
                                        data: data.payments.map(p => p.total),
                                        borderColor: '#7c3aed',
                                        backgroundColor: 'rgba(124,58,237,0.1)',
                                        fill: true,
                                    }]
                                },
                                options: { responsive: true, plugins: { legend: { display: false } } }
                            });
                            // ApexCharts Complaints Bar Chart
                            new ApexCharts(document.querySelector('#apexComplaintsChart'), {
                                chart: { type: 'bar', height: 250 },
                                series: [{ name: 'Complaints', data: data.complaints.map(c => c.count) }],
                                xaxis: { categories: data.complaints.map(c => c.date) },
                                colors: ['#f59e42']
                            }).render();
                        });
                    </script>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-building text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">New building registered</p>
                                    <p class="text-xs text-gray-500">2 hours ago</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-credit-card text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Subscription activated</p>
                                    <p class="text-xs text-gray-500">4 hours ago</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-plus text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">New user registered</p>
                                    <p class="text-xs text-gray-500">6 hours ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest Buildings Table -->
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-bold text-gray-900">Latest Buildings</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Building Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscription</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse(\App\Models\Building::latest()->take(5)->get() as $building)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $building->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $building->admin->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php $sub = $building->activeSubscription; @endphp
                                        @if($sub)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $sub->plan->name }}
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                None
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $building->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($building->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="/admin/buildings/{{ $building->id }}/edit" class="text-purple-600 hover:text-purple-900 mr-3">Edit</a>
                                        <a href="/admin/buildings/{{ $building->id }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        <p>No buildings found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
