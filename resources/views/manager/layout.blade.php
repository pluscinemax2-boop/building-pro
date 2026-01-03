<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manager Dashboard')</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Theme Configuration -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        /* Custom scrollbar hiding for cleaner mobile look */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        /* Smooth switch transition */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #137fec;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #137fec;
        }
        body {
            min-height: max(884px, 100dvh);
        }
        .pb-safe-bottom {
            padding-bottom: env(safe-area-inset-bottom, 20px);
        }
        .pt-safe-top {
            padding-top: env(safe-area-inset-top, 0px);
        }
        /* Action Sheet styles */
        .action-sheet {
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }
        .action-sheet.active {
            transform: translateY(0);
        }
        /* More menu styles */
        .more-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        .more-menu.active {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#111418] dark:text-white font-display">
    <div class="relative flex h-full min-h-screen w-full flex-col overflow-x-hidden pb-24">
        <!-- Header Section -->
        @if(request()->routeIs('manager.activities') || request()->routeIs('manager.notifications') || request()->routeIs('manager.profile') || request()->routeIs('manager.documents.*') || request()->routeIs('manager.notices.*') || request()->routeIs('manager.reports.*') || request()->routeIs('manager.complaints.*'))
        <!-- Custom header for pages with back button -->
        <div class="flex items-center bg-white dark:bg-gray-800 p-4 pb-4 justify-between sticky top-0 z-20 shadow-sm">
            <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('manager.dashboard') }}" class="flex items-center justify-center size-10 rounded-full bg-gray-100 dark:bg-gray-800 text-[#111418] dark:text-white">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-xl font-bold text-[#111418] dark:text-white">
                @if(request()->routeIs('manager.activities'))
                    Recent Activities
                @elseif(request()->routeIs('manager.notifications'))
                    Notifications
                @elseif(request()->routeIs('manager.profile'))
                    Profile
                @elseif(request()->routeIs('manager.documents.*'))
                    Documents
                @elseif(request()->routeIs('manager.notices.*'))
                    Notices
                @elseif(request()->routeIs('manager.reports.*'))
                    Reports
                @elseif(request()->routeIs('manager.complaints.*'))
                    Complaints
                @endif
            </h1>
            <div class="w-10"></div> <!-- Spacer for alignment -->
        </div>
        @else
        <div class="flex items-center bg-white dark:bg-gray-800 p-4 pb-4 justify-between sticky top-0 z-20 shadow-sm">
            <a href="{{ route('manager.profile.index') }}" class="flex items-center gap-3">
                <div class="relative">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-12 border-2 border-primary/20" data-alt="Profile picture of Manager David smiling" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCYQi4SCwvUB8xMi_HPQtkfccAHMvgA7cW0ga5pUjyGJzoX4KOBZKKOW-NuI0mmb5x91cLFQZ3_rIBb9mwRK1bIzuQnUohlSDimccA78CPjL1V2Udf15v4cuecj5PHp8OO6CukphBwAcdhYj0uevArqT2gGTtVYLR_vJDsLaUMqcJ1LiYqKlbZ8SvnYg6ND2avD96aWNsWfsax60QE-7sySHAtJmCUKNMaqvaqgXIugGU9c2P-cOh6vBvyAnjBjqrHdnw7ZIUWBO8PK");'>
                    </div>
                    <div class="absolute bottom-0 right-0 size-3 bg-green-500 rounded-full border-2 border-white dark:border-[#1a2634]"></div>
                </div>
                <div class="flex flex-col">
                    <p class="text-[#617589] dark:text-gray-400 text-xs font-medium uppercase tracking-wider">Welcome back</p>
                    <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight">Manager {{ Auth::user()->name ?? 'User' }}</h2>
                </div>
            </a>
            <div class="flex w-12 items-center justify-end">
                <a href="{{ route('manager.notifications') }}" class="relative flex cursor-pointer items-center justify-center overflow-hidden rounded-full size-10 bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800 text-[#111418] dark:text-white transition-colors">
                    <span class="material-symbols-outlined text-2xl">notifications</span>
                    @php
                        $userId = request()->user()->id;
                        $notificationCount = App\Models\Notification::where('notifiable_id', $userId)
                                            ->whereNull('read_at')
                                            ->count();
                    @endphp
                    @if($notificationCount > 0)
                    <span class="absolute top-2 right-2 size-2 rounded-full bg-red-500"></span>
                    @endif
                </a>
            </div>
        </div>
        @endif
        
        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>
        
        <!-- Action Sheet (Add Options) -->
        <div id="actionSheet" class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 rounded-t-2xl shadow-2xl transform translate-y-full transition-transform duration-300 pb-safe">
            <div class="p-4">
                <div class="flex justify-center mb-4">
                    <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                </div>
                <h3 class="text-center text-lg font-semibold mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 gap-3">
                    <button class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" onclick="window.location.href='/manager/expenses/create'">
                        <div class="flex items-center justify-center size-10 rounded-lg bg-blue-100 dark:bg-blue-900 text-primary">
                            <span class="material-symbols-outlined">receipt</span>
                        </div>
                        <span class="text-base font-medium">Add Expense</span>
                    </button>
                    <button class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" onclick="window.location.href='/manager/complaints/create'">
                        <div class="flex items-center justify-center size-10 rounded-lg bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-400">
                            <span class="material-symbols-outlined">folder_shared</span>
                        </div>
                        <span class="text-base font-medium">Update Complaint</span>
                    </button>
                    <button class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" onclick="window.location.href='/manager/documents/create'">
                        <div class="flex items-center justify-center size-10 rounded-lg bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400">
                            <span class="material-symbols-outlined">upload</span>
                        </div>
                        <span class="text-base font-medium">Upload Document</span>
                    </button>
                </div>
                <button class="w-full mt-4 p-3 text-center text-red-600 dark:text-red-400 font-medium" onclick="toggleActionSheet()">
                    Cancel
                </button>
            </div>
        </div>
        
        <!-- More Menu (hidden by default, show on click) -->
        <div id="moreMenu" class="hidden absolute bottom-16 right-0 bg-white dark:bg-[#1a2632] rounded-xl shadow-lg p-4 w-64">
            <div class="grid grid-cols-3 gap-4">
                <a href="/manager/notices" class="flex flex-col items-center justify-center p-2 text-gray-500 dark:text-gray-300 hover:bg-gray-100 rounded">
                    <span class="material-symbols-outlined text-2xl">campaign</span>
                    <span class="text-xs mt-1">Notices</span>
                </a>
                <a href="{{ route('manager.emergency') }}" class="flex flex-col items-center justify-center p-2 text-gray-500 dark:text-gray-300 hover:bg-gray-100 rounded">
                    <span class="material-symbols-outlined text-2xl">warning</span>
                    <span class="text-xs mt-1">Alerts</span>
                </a>
                <a href="/manager/reports" class="flex flex-col items-center justify-center p-2 text-gray-500 dark:text-gray-300 hover:bg-gray-100 rounded">
                    <span class="material-symbols-outlined text-2xl">bar_chart</span>
                    <span class="text-xs mt-1">Reports</span>
                </a>
                <a href="/manager/profile" class="flex flex-col items-center justify-center p-2 text-gray-500 dark:text-gray-300 hover:bg-gray-100 rounded">
                    <span class="material-symbols-outlined text-2xl">person</span>
                    <span class="text-xs mt-1">Profile</span>
                </a>
                <a href="mailto:support@example.com" class="flex flex-col items-center justify-center p-2 text-gray-500 dark:text-gray-300 hover:bg-gray-100 rounded">
                    <span class="material-symbols-outlined text-2xl">support_agent</span>
                    <span class="text-xs mt-1">Support</span>
                </a>
                <a href="/logout" class="flex flex-col items-center justify-center p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg">
                    <span class="material-symbols-outlined text-2xl">logout</span>
                    <span class="text-xs mt-1">Logout</span>
                </a>
            </div>
        </div>
        

        
        <!-- Bottom Navigation - Hide on specific pages -->
        @if(!request()->routeIs('manager.activities') && !request()->routeIs('manager.notifications') && !request()->routeIs('manager.profile') && !request()->routeIs('manager.documents.*') && !request()->routeIs('manager.notices.*') && !request()->routeIs('manager.reports.*'))
        <div class="fixed bottom-0 left-0 w-full bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-800 pb-safe z-30">
            <div class="flex items-center justify-around h-16">
                <a href="{{ route('manager.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 {{ request()->routeIs('manager.dashboard') ? 'text-primary' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200' }}">
                    <span class="material-symbols-outlined text-2xl">{{ request()->routeIs('manager.dashboard') ? 'home' : 'home' }}</span>
                    <span class="text-[10px] font-medium">Home</span>
                </a>
                <a href="{{ route('manager.complaints.index') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 {{ request()->routeIs('manager.complaints.*') ? 'text-primary' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200' }}">
                    <span class="material-symbols-outlined text-2xl">{{ request()->routeIs('manager.complaints.*') ? 'assignment_late' : 'assignment_late' }}</span>
                    <span class="text-[10px] font-medium">Complaints</span>
                </a>
                <!-- Add / Action (Center Button) -->
                <div class="relative flex-1 flex items-center justify-center">
                    <button id="actionSheetBtn" class="bg-primary text-white rounded-full shadow-lg w-12 h-12 flex items-center justify-center absolute -top-6 left-1/2 transform -translate-x-1/2 z-10">
                        <span class="material-symbols-outlined text-2xl">add</span>
                    </button>
                    <!-- Action Sheet (hidden by default, show on click) -->
                    <div id="actionSheet" class="hidden absolute bottom-16 left-1/2 transform -translate-x-1/2 bg-white dark:bg-[#1a2632] rounded-xl shadow-lg p-4 w-56">
                        <a href="{{ route('manager.complaints.create') }}" class="w-full flex items-center gap-2 py-2 text-primary hover:bg-gray-100 rounded">
                            <span class="material-symbols-outlined">folder_shared</span> Create Complaint
                        </a>
                        <a href="/manager/expenses/create" class="w-full flex items-center gap-2 py-2 text-primary hover:bg-gray-100 rounded">
                            <span class="material-symbols-outlined">receipt_long</span> Add Expense
                        </a>
                        <form id="uploadForm" action="/manager/documents" method="POST" enctype="multipart/form-data" style="display: none;">
                            @csrf
                            <input type="file" name="file" id="fileInput" class="hidden" onchange="this.form.submit();" required />
                        </form>
                        <button type="button" onclick="document.getElementById('fileInput').click()" class="w-full flex items-center gap-2 py-2 text-primary hover:bg-gray-100 rounded">
                            <span class="material-symbols-outlined text-xl">upload</span>
                            Upload
                        </button>
                    </div>
                </div>
                <a href="/manager/documents" class="flex flex-col items-center justify-center w-full h-full gap-1 {{ request()->routeIs('manager.documents.*') ? 'text-primary' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200' }}">
                    <span class="material-symbols-outlined text-2xl">{{ request()->routeIs('manager.documents.*') ? 'folder' : 'folder' }}</span>
                    <span class="text-[10px] font-medium">Documents</span>
                </a>
                <button id="moreMenuBtn" class="flex flex-col items-center justify-center w-full h-full gap-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <span class="material-symbols-outlined text-2xl">menu</span>
                    <span class="text-[10px] font-medium">More</span>
                </button>
            </div>
        </div>
        @endif
    </div>
    
    <script>
        // Action Sheet toggle
        const actionBtn = document.getElementById('actionSheetBtn');
        const actionSheet = document.getElementById('actionSheet');
        actionBtn && actionBtn.addEventListener('click', () => {
            actionSheet.classList.toggle('hidden');
        });
        
        // More Menu toggle
        const moreBtn = document.getElementById('moreMenuBtn');
        const moreMenu = document.getElementById('moreMenu');
        moreBtn && moreBtn.addEventListener('click', () => {
            moreMenu.classList.toggle('hidden');
        });
        
        // Hide menus on outside click
        window.addEventListener('click', function(e) {
            if (!actionBtn.contains(e.target) && !actionSheet.contains(e.target)) {
                actionSheet.classList.add('hidden');
            }
            if (!moreBtn.contains(e.target) && !moreMenu.contains(e.target)) {
                moreMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>