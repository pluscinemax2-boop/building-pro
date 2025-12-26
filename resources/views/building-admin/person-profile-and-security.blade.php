@extends('building-admin.layout')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col max-w-md mx-auto bg-background-light dark:bg-background-dark pb-24">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-5 py-3 flex items-center justify-between">
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Profile & Security</h1>
        <a href="{{ route('building-admin.profile.edit') }}" class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-full hover:bg-blue-600 active:scale-95 transition-all shadow-md shadow-primary/20">
            <span class="material-symbols-outlined text-[20px] font-bold">edit</span>
            <span class="text-sm font-bold">Edit</span>
        </a>
    </header>
    <!-- Profile Section -->
    <section class="px-5 py-6">
        <div class="flex flex-col items-center gap-4">
            <div class="w-24 h-24 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden flex items-center justify-center">
                <img src="{{ $admin->avatar ?? asset('images/avatar-placeholder.png') }}" alt="Avatar" class="w-full h-full object-cover" />
            </div>
            <div class="text-center">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $admin->name }}</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">{{ $admin->email }}</p>
            </div>
        </div>
    </section>
    <!-- Security Section -->
    <section class="px-5 pt-2">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Security Settings</h3>
        <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-5 shadow border border-slate-100 dark:border-slate-700 flex flex-col gap-4 mb-3">
            <div class="flex items-center justify-between">
                <span class="font-medium text-slate-700 dark:text-slate-200">Password</span>
                <a href="{{ route('building-admin.profile.password') }}" class="text-primary text-sm font-bold hover:underline">Change</a>
            </div>
            <div class="flex items-center justify-between">
                <span class="font-medium text-slate-700 dark:text-slate-200">Two-Factor Authentication</span>
                <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $admin->two_factor_enabled ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-500' }}">
                    {{ $admin->two_factor_enabled ? 'Enabled' : 'Disabled' }}
                </span>
            </div>
        </div>
    </section>
    <!-- Bottom Tab Bar -->
    @include('building-admin.partials.bottom-nav', ['active' => 'profile'])
</div>
@endsection
