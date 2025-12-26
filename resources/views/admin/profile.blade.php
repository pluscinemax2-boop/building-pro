@extends('layouts.app')

@section('content')
<!-- Top Navigation Bar -->
<header class="sticky top-0 z-50 bg-white/80 dark:bg-[#101922]/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 px-4 pt-safe-top">
<div class="flex items-center justify-between h-14 max-w-md mx-auto w-full">
<a href="{{ url()->previous() }}" class="flex items-center justify-center w-10 h-10 -ml-2 text-gray-900 dark:text-white rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
    <span class="material-symbols-outlined text-[24px]">arrow_back_ios_new</span>
</a>
<h1 class="text-lg font-bold tracking-tight">Profile</h1>
<a href="#" onclick="alert('Edit profile coming soon!')" class="flex items-center justify-center h-10 px-2 text-primary font-bold text-[15px] hover:opacity-80 transition-opacity">Edit</a>
</div>
</header>
<!-- Main Content Area -->
<main class="flex-1 w-full max-w-md mx-auto p-4 space-y-6">
<!-- Profile Header Card -->
<section class="bg-white dark:bg-[#1a2632] rounded-xl p-6 shadow-sm border border-gray-100/50 dark:border-gray-700/30 flex flex-col items-center justify-center relative overflow-hidden">
<!-- Decorative background blur -->
<div class="absolute top-0 w-full h-24 bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
<div class="relative z-10">
<div class="relative">
    <form id="avatar-upload-form" action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" id="avatar-input" name="avatar" accept="image/*" class="hidden" onchange="document.getElementById('avatar-upload-form').submit();">
        <div class="w-28 h-28 rounded-full bg-gray-200 border-4 border-white dark:border-[#1a2632] shadow-sm bg-center bg-cover" data-alt="User profile image" style="background-image: url('{{ Auth::user()->avatar_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuB1xWu8U2_piLzC5LhFoM03bfSMhsCg0JtRTeXokKDFTnVGlC1VUyhfEuCRknW1ftPD69W6tXG03Vz_80JliRZrzoFHRjxKNNetgnQ8P3CxvU5Hjo7Wwd02gCvnxSHR1AIiQEkAuQUF5NcdTFSnRkh7AJZmNYQINAtYcmBPhf4YgEHlbz2npQUgalmr0BdbN3KtvnfPw_hlmIENyUFnXUuOgpWZk1QH6e3LCr77nWM3YWFSyFpRHndIjgEq7l3_thcKoXwJPWjXHEWX' }}');">
        </div>
        <button type="button" onclick="document.getElementById('avatar-input').click();" class="absolute bottom-1 right-1 bg-primary text-white rounded-full p-2 flex items-center justify-center border-2 border-white dark:border-[#1a2632] shadow-sm hover:bg-blue-600 transition-colors">
            <span class="material-symbols-outlined text-[16px]">photo_camera</span>
        </button>
    </form>
</div>
</div>
<div class="mt-4 text-center z-10">
<h2 class="text-xl font-bold text-[#111418] dark:text-white leading-tight">{{ Auth::user()->name }}</h2>
<div class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
    {{ Auth::user()->role->name ?? 'Admin' }}
</div>
</div>
</section>
<!-- Personal Information Section -->
<section>
<h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 pl-2">Personal Information</h3>
<div class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-gray-100/50 dark:border-gray-700/30 overflow-hidden divide-y divide-gray-100 dark:divide-gray-800">
<!-- Full Name Field -->
<div class="group flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
<div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
<span class="material-symbols-outlined text-[18px]">person</span>
</div>
<div class="flex-1">
<label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-0.5">Full Name</label>
<input class="w-full bg-transparent border-none p-0 text-[#111418] dark:text-white text-[15px] font-medium focus:ring-0 placeholder:text-gray-400" type="text" value="{{ Auth::user()->name }}"/>
</div>
<span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-[18px]">edit</span>
</div>
<!-- Email Field (Locked) -->
<div class="group flex items-center gap-4 p-4 bg-gray-50/50 dark:bg-gray-800/20">
<div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
<span class="material-symbols-outlined text-[18px]">mail</span>
</div>
<div class="flex-1">
<label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-0.5">Email Address</label>
<input class="w-full bg-transparent border-none p-0 text-gray-500 dark:text-gray-400 text-[15px] font-medium focus:ring-0 cursor-not-allowed" readonly type="email" value="{{ Auth::user()->email }}"/>
</div>
<span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-[18px]">lock</span>
</div>
<!-- Phone Field -->
<div class="group flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
<div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
<span class="material-symbols-outlined text-[18px]">call</span>
</div>
<div class="flex-1">
<label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-0.5">Phone Number</label>
<input class="w-full bg-transparent border-none p-0 text-[#111418] dark:text-white text-[15px] font-medium focus:ring-0 placeholder:text-gray-400" type="tel" value="{{ Auth::user()->phone ?? '' }}"/>
</div>
<span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-[18px]">edit</span>
</div>
</div>
</section>
<!-- Security Section -->
<section>
<h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 pl-2">Security</h3>
<div class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-gray-100/50 dark:border-gray-700/30 overflow-hidden divide-y divide-gray-100 dark:divide-gray-800">
<!-- Change Password -->
<a href="/password/reset" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors text-left group">
    <div class="flex items-center gap-4">
        <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-primary">
            <span class="material-symbols-outlined text-[20px]">lock_reset</span>
        </div>
        <span class="text-[15px] font-medium text-[#111418] dark:text-white">Change Password</span>
    </div>
    <span class="material-symbols-outlined text-gray-300 group-hover:text-primary transition-colors text-[20px]">chevron_right</span>
</a>
<!-- Biometric Toggle -->
<div class="flex items-center justify-between p-4">
<div class="flex items-center gap-4">
<div class="flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-primary">
<span class="material-symbols-outlined text-[20px]">fingerprint</span>
</div>
<div class="flex flex-col">
<span class="text-[15px] font-medium text-[#111418] dark:text-white">Biometric Login</span>
<span class="text-xs text-gray-500">FaceID / TouchID</span>
</div>
</div>
<!-- Toggle Switch -->
<label class="relative inline-flex items-center cursor-pointer">
    <input class="sr-only peer" type="checkbox" value="" onclick="alert('Biometric login coming soon!')"/>
    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
</label>
</div>
</div>
</section>
<!-- Logout Button -->
<form method="POST" action="{{ url('/logout') }}" class="w-full mt-4">
    @csrf
    <button type="submit" class="w-full bg-white dark:bg-[#1a2632] border border-red-100 dark:border-red-900/30 rounded-xl p-4 shadow-sm flex items-center justify-center gap-2 text-red-600 dark:text-red-500 font-semibold text-[15px] hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
        <span class="material-symbols-outlined text-[20px]">logout</span>
        Log Out
    </button>
</form>
</main>
<!-- Bottom Navigation Bar -->
<nav class="fixed bottom-0 z-40 w-full bg-white dark:bg-[#101922] border-t border-gray-100 dark:border-gray-800 pb-safe-bottom">
    <div class="flex justify-around items-center h-[60px] max-w-md mx-auto">
        <a class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-primary transition-colors gap-1" href="{{ route('admin.dashboard') }}">
            <span class="material-symbols-outlined text-[24px]">dashboard</span>
            <span class="text-[10px] font-medium">Dashboard</span>
        </a>
        <a class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-primary transition-colors gap-1" href="{{ route('admin.building-management') }}">
            <span class="material-symbols-outlined text-[24px]">apartment</span>
            <span class="text-[10px] font-medium">Buildings</span>
        </a>
        <a class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-primary transition-colors gap-1" href="{{ route('users.index') }}">
            <span class="material-symbols-outlined text-[24px]">group</span>
            <span class="text-[10px] font-medium">Users</span>
        </a>
        <a class="flex flex-col items-center justify-center w-full h-full text-primary gap-1" href="{{ route('admin.profile') }}">
            <span class="material-symbols-outlined text-[24px] fill-current">person</span>
            <span class="text-[10px] font-bold">Profile</span>
        </a>
    </div>
</nav>
<!-- Safe Area Spacing for Bottom Nav -->
<style>
        .pb-safe-bottom {
            padding-bottom: env(safe-area-inset-bottom, 20px);
        }
        .pt-safe-top {
            padding-top: env(safe-area-inset-top, 0px);
        }
    </style>
@endsection
