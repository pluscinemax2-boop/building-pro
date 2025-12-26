<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'App')</title>
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
        </style>
</head>
<body>
    <main>
        @yield('content')
    </main>
    <!-- Settings Overlay Modal (global, for all pages) -->
    <div class="fixed inset-0 z-50 flex items-center justify-center px-4 pb-20 hidden" id="settings-overlay">
        <div class="absolute inset-0 bg-[#111418]/50 backdrop-blur-[2px] transition-opacity duration-300 cursor-pointer" onclick="document.getElementById('settings-overlay').classList.add('hidden')"></div>
        <div class="relative w-full max-w-[340px] dark:bg-[#192531] rounded-2xl shadow-2xl flex flex-col overflow-hidden animate-[fade-in-up_0.2s_ease-out]">
            <div>
                <div class="grid grid-cols-3 gap-3">
                    <button class="flex flex-col items-center justify-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-[#101922] border border-transparent hover:border-primary/20 hover:bg-blue-50/50 dark:hover:bg-primary/10 transition-all group aspect-square" onclick="window.location.href='{{ route('admin.subcription') }}'">
                        <div class="text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined" style="font-size: 28px;">credit_card</span>
                        </div>
                        <span class="text-[10px] font-semibold text-center text-gray-700 dark:text-gray-300 leading-tight">Subscription</span>
                    </button>
                    <button class="flex flex-col items-center justify-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-[#101922] border border-transparent hover:border-purple-500/20 hover:bg-purple-50/50 dark:hover:bg-purple-900/10 transition-all group aspect-square" onclick="window.location.href='{{ route('admin.system-settings') }}'">
                        <div class="text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined" style="font-size: 28px;">dns</span>
                        </div>
                        <span class="text-[10px] font-semibold text-center text-gray-700 dark:text-gray-300 leading-tight">General Settings</span>
                    </button>
                    <button class="flex flex-col items-center justify-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-[#101922] border border-transparent hover:border-green-500/20 hover:bg-green-50/50 dark:hover:bg-green-900/10 transition-all group aspect-square" onclick="window.location.href='{{ route('admin.payment.gateway') }}'">
                        <div class="text-green-600 dark:text-green-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined" style="font-size: 28px;">payments</span>
                        </div>
                        <span class="text-[10px] font-semibold text-center text-gray-700 dark:text-gray-300 leading-tight">Payment Gateway</span>
                    </button>
                    <button class="flex flex-col items-center justify-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-[#101922] border border-transparent hover:border-amber-500/20 hover:bg-amber-50/50 dark:hover:bg-amber-900/10 transition-all group aspect-square" onclick="window.location.href='{{ route('admin.email.notification') }}'">
                        <div class="text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined" style="font-size: 28px;">mail</span>
                        </div>
                        <span class="text-[10px] font-semibold text-center text-gray-700 dark:text-gray-300 leading-tight">Email/ Notification</span>
                    </button>
                    <button class="flex flex-col items-center justify-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-[#101922] border border-transparent hover:border-red-500/20 hover:bg-red-50/50 dark:hover:bg-red-900/10 transition-all group aspect-square" onclick="window.location.href='{{ route('admin.users.security') }}'">  
                        <div class="text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined" style="font-size: 28px;">security</span>
                        </div>
                        <span class="text-[10px] font-semibold text-center text-gray-700 dark:text-gray-300 leading-tight">User &amp; Security</span>
                    </button>
                    <button class="flex flex-col items-center justify-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-[#101922] border border-transparent hover:border-indigo-500/20 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/10 transition-all group aspect-square" onclick="window.location.href='{{ route('admin.roles.access') }}'">
                        <div class="text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined" style="font-size: 28px;">admin_panel_settings</span>
                        </div>
                        <span class="text-[10px] font-semibold text-center text-gray-700 dark:text-gray-300 leading-tight">Role &amp; Access</span>
                    </button>
                    <button class="flex flex-col items-center justify-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-[#101922] border border-transparent hover:border-cyan-500/20 hover:bg-cyan-50/50 dark:hover:bg-cyan-900/10 transition-all group aspect-square" onclick="window.location.href='{{ route('admin.feature.toggles') }}'">
                        <div class="text-cyan-600 dark:text-cyan-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined" style="font-size: 28px;">toggle_on</span>
                        </div>
                        <span class="text-[10px] font-semibold text-center text-gray-700 dark:text-gray-300 leading-tight">Feature Toggles</span>
                    </button>
                    <button class="flex flex-col items-center justify-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-[#101922] border border-transparent hover:border-slate-500/20 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all group aspect-square" onclick="window.location.href='{{ route('admin.system.maintenance') }}'">
                        <div class="text-slate-600 dark:text-slate-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined" style="font-size: 28px;">build</span>
                        </div>
                        <span class="text-[10px] font-semibold text-center text-gray-700 dark:text-gray-300 leading-tight">System Maintenance</span>
                    </button>
                    <button class="flex flex-col items-center justify-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-[#101922] border border-transparent hover:border-pink-500/20 hover:bg-pink-50/50 dark:hover:bg-pink-900/10 transition-all group aspect-square" onclick="window.location.href='{{ route('admin.legal.policy') }}'">
                        <div class="text-pink-600 dark:text-pink-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined" style="font-size: 28px;">policy</span>
                        </div>
                        <span class="text-[10px] font-semibold text-center text-gray-700 dark:text-gray-300 leading-tight">Legal &amp; Policy</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
