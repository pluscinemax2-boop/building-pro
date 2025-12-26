@extends('layouts.app')
@section('content')
@php
    // Example dynamic data, replace with real data from controller
    $enable_manager = $enable_manager ?? true;
    $resident_self_registration = $resident_self_registration ?? false;
    $max_managers = $max_managers ?? 5;
    $disable_role_deletion = $disable_role_deletion ?? true;
    $roles = $roles ?? [
        ['name' => 'Super Admin', 'desc' => 'Full Access, System Configuration', 'icon' => 'admin_panel_settings', 'color' => 'primary', 'status' => 'locked'],
        ['name' => 'Manager', 'desc' => 'Building Access, User Management', 'icon' => 'manage_accounts', 'color' => 'purple', 'status' => 'active'],
        ['name' => 'Resident', 'desc' => 'Limited Access, Self Service', 'icon' => 'person', 'color' => 'orange', 'status' => 'default'],
    ];
@endphp
<div class="relative flex h-full min-h-screen w-full flex-col overflow-hidden max-w-md mx-auto bg-white dark:bg-[#111a22] shadow-xl">
    <form method="POST" action="{{ route('admin.roles.access.save') }}">
        @csrf
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <!-- TopAppBar -->
        <header class="sticky top-0 z-10 bg-white dark:bg-[#111a22] border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center p-4 pb-3">
                <div class="w-10 h-10 flex items-center justify-center">
                    <a href="{{ route('dashboard') }}" class="flex size-10 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-[#111418] dark:text-white">
                        <span class="material-symbols-outlined" style="font-size: 24px;">arrow_back_ios_new</span>
                    </a>
                </div>
                <div class="flex-1 flex items-center justify-center">
                    <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] text-center">Roles and Access Settings</h2>
                </div>
                <div class="w-10 h-10"></div>
            </div>
        </header>
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark p-4">
        <!-- Section: Role & Access Settings -->
        <div class="mb-6">
            <h3 class="text-[#617589] dark:text-gray-400 text-sm font-semibold uppercase tracking-wider px-1 pb-3 pt-2">Role & Access Settings</h3>
            <div class="bg-white dark:bg-[#1a2632] rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-800 divide-y divide-gray-100 dark:divide-gray-800">
                <!-- Item: Enable Manager Role -->
                <div class="p-4 flex items-center justify-between gap-4">
                    <div class="flex flex-col gap-1 pr-2">
                        <p class="text-[#111418] dark:text-white text-base font-medium leading-tight">Enable Manager Role</p>
                        <p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal">Allow assigning manager privileges to users</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input class="sr-only peer" type="checkbox" name="enable_manager" value="1" {{ $enable_manager ? 'checked' : '' }} />
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/20 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                    </label>
                </div>
                <!-- Item: Resident Self-Registration -->
                <div class="p-4 flex items-center justify-between gap-4">
                    <div class="flex flex-col gap-1 pr-2">
                        <p class="text-[#111418] dark:text-white text-base font-medium leading-tight">Resident Self-Registration</p>
                        <p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal">Residents can sign up without an invite</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input class="sr-only peer" type="checkbox" name="resident_self_registration" value="1" {{ $resident_self_registration ? 'checked' : '' }} />
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/20 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                    </label>
                </div>
                <!-- Item: Max Managers per Building -->
                <div class="p-4 flex items-center justify-between gap-4">
                    <div class="flex flex-col gap-1">
                        <p class="text-[#111418] dark:text-white text-base font-medium leading-tight">Max Managers per Building</p>
                        <p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal">Limit admin access for security</p>
                    </div>
                    <div class="flex items-center bg-gray-50 dark:bg-gray-800 rounded-lg px-2 border border-gray-200 dark:border-gray-700 shrink-0">
                        <button type="button" class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md transition-colors max-managers-minus">
                            <span class="material-symbols-outlined text-[20px]">remove</span>
                        </button>
                        <input class="w-10 bg-transparent text-center text-[#111418] dark:text-white font-semibold border-none focus:ring-0 p-0 text-base" type="number" name="max_managers" value="{{ $max_managers }}" min="1" max="10" />
                        <button type="button" class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md transition-colors max-managers-plus">
                            <span class="material-symbols-outlined text-[20px]">add</span>
                        </button>
                    </div>
                </div>
                <!-- Item: Disable Role Deletion -->
                <div class="p-4 flex items-center justify-between gap-4">
                    <div class="flex flex-col gap-1 pr-2">
                        <p class="text-[#111418] dark:text-white text-base font-medium leading-tight">Disable Role Deletion</p>
                        <p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal">Prevents accidental removal of active roles</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input class="sr-only peer" type="checkbox" name="disable_role_deletion" value="1" {{ $disable_role_deletion ? 'checked' : '' }} />
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/20 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                    </label>
                </div>
            </div>
        </div>
        <!-- Additional Section: Role Hierarchy (Visual Placeholder) -->
        <div class="mb-6">
            <h3 class="text-[#617589] dark:text-gray-400 text-sm font-semibold uppercase tracking-wider px-1 pb-3 pt-2">Role Hierarchy Preview</h3>
            <div class="bg-white dark:bg-[#1a2632] rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-800 p-5">
                <div class="flex flex-col gap-4">
                    @foreach($roles as $i => $role)
                    <div class="flex items-center gap-4 {{ $i < count($roles)-1 ? '' : 'opacity-60' }}">
                        <div class="size-10 rounded-full bg-{{ $role['color'] }}-100 dark:bg-{{ $role['color'] }}-900/30 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-{{ $role['color'] }}-600 dark:text-{{ $role['color'] }}-400">{{ $role['icon'] }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-[#111418] dark:text-white">{{ $role['name'] }}</p>
                            <p class="text-xs text-[#617589] dark:text-gray-400">{{ $role['desc'] }}</p>
                        </div>
                        @if($role['status'] === 'locked')
                            <span class="material-symbols-outlined text-gray-400">lock</span>
                        @elseif($role['status'] === 'active')
                            <span class="text-xs font-semibold bg-green-100 text-green-700 px-2 py-1 rounded dark:bg-green-900/30 dark:text-green-400">Active</span>
                        @else
                            <span class="text-xs font-semibold bg-gray-100 text-gray-500 px-2 py-1 rounded dark:bg-gray-800 dark:text-gray-400">Default</span>
                        @endif
                    </div>
                    @if($i < count($roles)-1)
                        <div class="w-px h-4 bg-gray-200 dark:bg-gray-700 ml-5"></div>
                    @endif
                    @endforeach
                </div>
                <p class="text-xs text-[#617589] dark:text-gray-500 px-2 mt-2">
                    Hierarchy changes require system reboot. Contact support for advanced configuration.
                </p>
            </div>
        </div>
        <!-- Danger Zone -->
        <div class="mb-8">
            <h3 class="text-red-600 dark:text-red-400 text-sm font-semibold uppercase tracking-wider px-1 pb-3 pt-2">Danger Zone</h3>
            <div class="bg-white dark:bg-[#1a2632] rounded-xl overflow-hidden shadow-sm border border-red-100 dark:border-red-900/30">
                <button class="w-full text-left p-4 flex items-center justify-between group">
                    <div class="flex flex-col gap-1">
                        <p class="text-red-600 dark:text-red-400 text-base font-medium leading-tight">Reset Role Permissions</p>
                        <p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal">Revert all roles to default settings</p>
                    </div>
                    <span class="material-symbols-outlined text-gray-400 group-hover:text-red-500 transition-colors">chevron_right</span>
                </button>
            </div>
        </div>
        </main>
        <!-- Fixed Footer -->
        <div class="fixed bottom-0 left-0 z-30 w-full border-t border-gray-100 bg-white px-4 py-4 dark:border-gray-800 dark:bg-[#111a22]">
            <div class="mx-auto w-full max-w-md">
                <button type="submit" class="flex h-12 w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 text-base font-semibold text-white shadow-md shadow-blue-500/20 transition-all hover:bg-blue-600 active:scale-[0.98]">
                    <span class="material-symbols-outlined" style="font-size: 20px;">check</span>
                    Save Changes
                </button>
            </div>
        </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const minusBtn = document.querySelector('.max-managers-minus');
        const plusBtn = document.querySelector('.max-managers-plus');
        const input = document.querySelector('input[name="max_managers"]');
        if (minusBtn && plusBtn && input) {
            minusBtn.addEventListener('click', function(e) {
                e.preventDefault();
                let val = parseInt(input.value) || 1;
                if (val > 1) input.value = val - 1;
            });
            plusBtn.addEventListener('click', function(e) {
                e.preventDefault();
                let val = parseInt(input.value) || 1;
                if (val < 10) input.value = val + 1;
            });
        }
    });
    </script>
    </form>
@endsection
