@extends('manager.layout')

@section('title', 'Profile - Manager')

@section('content')
<div class="p-4">
    <h3 class="text-lg font-bold mb-4">Profile</h3>
    
    <div class="flex flex-col items-center mb-6">
        <div class="relative">
            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-20 border-4 border-primary/20" data-alt="Profile picture of Manager David smiling" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCYQi4SCwvUB8xMi_HPQtkfccAHMvgA7cW0ga5pUjyGJzoX4KOBZKKOW-NuI0mmb5x91cLFQZ3_rIBb9mwRK1bIzuQnUohlSDimccA78CPjL1V2Udf15v4cuecj5PHp8OO6CukphBwAcdhYj0uevArqT2gGTtVYLR_vJDsLaUMqcJ1LiYqKlbZ8SvnYg6ND2avD96aWNsWfsax60QE-7sySHAtJmCUKNMaqvaqgXIugGU9c2P-cOh6vBvyAnjBjqrHdnw7ZIUWBO8PK");'>
            </div>
            <div class="absolute bottom-0 right-0 size-5 bg-green-500 rounded-full border-4 border-white dark:border-[#1a2634]"></div>
        </div>
        <h4 class="text-xl font-bold mt-3">Manager {{ $user->name ?? 'User' }}</h4>
        <p class="text-[#617589] dark:text-gray-400 text-sm">{{ $user->email ?? 'manager@example.com' }}</p>
    </div>
    
    <div class="space-y-3">
        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 size-10">
                    <span class="material-symbols-outlined">person</span>
                </div>
                <span class="text-base font-medium">Personal Info</span>
            </div>
            <span class="material-symbols-outlined text-gray-400 text-xl">chevron_right</span>
        </div>
        
        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-400 size-10">
                    <span class="material-symbols-outlined">lock</span>
                </div>
                <span class="text-base font-medium">Change Password</span>
            </div>
            <span class="material-symbols-outlined text-gray-400 text-xl">chevron_right</span>
        </div>
        
        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center rounded-lg bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 size-10">
                    <span class="material-symbols-outlined">notifications</span>
                </div>
                <span class="text-base font-medium">Notifications</span>
            </div>
            <span class="material-symbols-outlined text-gray-400 text-xl">chevron_right</span>
        </div>
        
        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400 size-10">
                    <span class="material-symbols-outlined">security</span>
                </div>
                <span class="text-base font-medium">Security</span>
            </div>
            <span class="material-symbols-outlined text-gray-400 text-xl">chevron_right</span>
        </div>
    </div>
</div>
@endsection