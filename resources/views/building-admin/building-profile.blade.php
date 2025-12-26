@extends('layouts.app')
@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col overflow-x-hidden pb-24">
    <!-- Top App Bar -->
    <div class="flex items-center bg-white dark:bg-[#1a2632] p-4 sticky top-0 z-30 border-b border-gray-100 dark:border-gray-800 shadow-sm">
        <a href="{{ route('building-admin.dashboard') }}" class="text-[#111418] dark:text-white flex size-12 shrink-0 items-center justify-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-full transition-colors">
            <span class="material-symbols-outlined">arrow_back_ios_new</span>
        </a>
        <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight flex-1 text-center pr-12">{{ $pageTitle ?? 'Building Profile' }}</h2>
    </div>
    <!-- Scrollable Content Area -->
    <div class="flex flex-col gap-6 p-4 md:max-w-xl md:mx-auto w-full">
        <!-- Profile Header / Hero -->
        <div class="flex flex-col items-center gap-4 mt-2">
            <form method="POST" action="{{ route('building-admin.profile.avatar') }}" enctype="multipart/form-data" class="relative group flex flex-col items-center">
                @csrf
                <label for="avatar-upload" class="cursor-pointer">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-2xl h-32 w-32 shadow-md ring-4 ring-white dark:ring-gray-800" data-alt="{{ $buildingImageAlt ?? 'Building image' }}" style="background-image: url('{{ $buildingImage }}');"></div>
                    <input id="avatar-upload" name="avatar" type="file" accept="image/*" class="hidden" onchange="this.form.submit()">
                </label>
                <div class="absolute -bottom-2 -right-2 bg-white dark:bg-[#1a2632] p-1.5 rounded-full shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="material-symbols-outlined text-primary text-[20px]">{{ $statusIcon ?? 'verified' }}</span>
                </div>
                <span class="text-xs text-gray-500 mt-2">Click image to change</span>
            </form>
            <div class="flex flex-col items-center justify-center gap-1 text-center">
                <h1 class="text-[#111418] dark:text-white text-2xl font-bold leading-tight tracking-tight">{{ $buildingName }}</h1>
                <p class="text-[#617589] dark:text-gray-400 text-sm font-normal">{{ $buildingAddress }}</p>
                <div class="mt-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 {{ $statusBgClass ?? 'bg-emerald-50 dark:bg-emerald-900/20' }} {{ $statusTextClass ?? 'text-emerald-700 dark:text-emerald-400' }} text-xs font-semibold rounded-full border {{ $statusBorderClass ?? 'border-emerald-100 dark:border-emerald-800' }}">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $statusPingClass ?? 'bg-emerald-400 opacity-75' }}"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 {{ $statusDotClass ?? 'bg-emerald-500' }}"></span>
                        </span>
                        {{ $buildingStatus ?? 'Active Status' }}
                    </span>
                </div>
            </div>
        </div>
        <!-- Card: General Information -->
        <div class="flex flex-col gap-2">
            <h3 class="text-[#111418] dark:text-white text-base font-bold px-1">{{ $generalInfoTitle ?? 'General Information' }}</h3>
            <div class="bg-white dark:bg-[#1a2632] rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-gray-100 dark:border-gray-800 overflow-hidden">
                @foreach(($generalInfo ?? [
                    ['icon' => 'location_city', 'label' => 'City', 'value' => $city ?? 'San Francisco'],
                    ['icon' => 'map', 'label' => 'State', 'value' => $state ?? 'CA'],
                    ['icon' => 'pin_drop', 'label' => 'Zip Code', 'value' => $zip ?? '94103'],
                ]) as $item)
                <div class="flex items-center justify-between p-4 @if(!$loop->last) border-b border-gray-50 dark:border-gray-700/50 @endif hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center size-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-primary">
                            <span class="material-symbols-outlined text-[20px]">{{ $item['icon'] }}</span>
                        </div>
                        <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">{{ $item['label'] }}</span>
                    </div>
                    <span class="text-[#111418] dark:text-white text-sm font-medium">{{ $item['value'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Card: Capacity & Structure -->
        <div class="flex flex-col gap-2">
            <h3 class="text-[#111418] dark:text-white text-base font-bold px-1">{{ $capacityTitle ?? 'Capacity & Structure' }}</h3>
            <div class="bg-white dark:bg-[#1a2632] rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-gray-100 dark:border-gray-800 overflow-hidden">
                @foreach(($capacityInfo ?? [
                    ['icon' => 'stairs', 'label' => 'Total Floors', 'value' => $totalFloors ?? '12 Floors'],
                    ['icon' => 'door_front', 'label' => 'Total Flats', 'value' => $totalFlats ?? '48 Units'],
                ]) as $item)
                <div class="flex items-center justify-between p-4 @if(!$loop->last) border-b border-gray-50 dark:border-gray-700/50 @endif hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center size-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-primary">
                            <span class="material-symbols-outlined text-[20px]">{{ $item['icon'] }}</span>
                        </div>
                        <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">{{ $item['label'] }}</span>
                    </div>
                    <span class="text-[#111418] dark:text-white text-sm font-medium">{{ $item['value'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Card: Primary Contact -->
        <div class="flex flex-col gap-2">
            <h3 class="text-[#111418] dark:text-white text-base font-bold px-1">{{ $contactTitle ?? 'Primary Contact' }}</h3>
            <div class="bg-white dark:bg-[#1a2632] rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-gray-100 dark:border-gray-800 overflow-hidden">
                @foreach(($contactInfo ?? [
                    ['icon' => 'person', 'label' => 'Manager', 'value' => $managerName ?? 'Jane Doe'],
                    ['icon' => 'phone_in_talk', 'label' => 'Emergency', 'value' => $emergencyPhone ?? '(555) 123-4567', 'class' => 'text-primary group-hover/phone:underline cursor-pointer'],
                ]) as $item)
                <div class="flex items-center justify-between p-4 @if(!$loop->last) border-b border-gray-50 dark:border-gray-700/50 @endif hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors @if(isset($item['class'])) group/phone @endif">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center size-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-primary">
                            <span class="material-symbols-outlined text-[20px]">{{ $item['icon'] }}</span>
                        </div>
                        <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">{{ $item['label'] }}</span>
                    </div>
                    <span class="text-[#111418] dark:text-white text-sm font-medium @if(isset($item['class'])) {{ $item['class'] }} @endif">{{ $item['value'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Floating Action Button Area -->
    <div class="fixed bottom-0 left-0 right-0 p-4 bg-white/90 dark:bg-[#1a2632]/90 backdrop-blur-md border-t border-gray-100 dark:border-gray-800 flex justify-center z-40">
        <a href="{{ route('building-admin.building-settings') }}" class="w-full md:max-w-md bg-primary hover:bg-[#0f6bca] active:scale-[0.98] transition-all duration-200 text-white font-bold py-3.5 px-6 rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20">
            <span class="material-symbols-outlined text-[20px]">{{ $editButtonIcon }}</span>
            <span>{{ $editButtonText }}</span>
        </a>
    </div>
</div>
@endsection
