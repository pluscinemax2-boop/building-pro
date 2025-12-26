@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white dark:bg-[#1e2732] rounded-xl shadow p-6">
    <div class="flex flex-col items-center gap-4">
        <div class="bg-center bg-no-repeat bg-cover rounded-full size-24 shadow ring-2 ring-primary/10" style="background-image: url('{{ $adminProfilePic ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuA3ZuObFSZHcFPwZeebevPXn90ykSdYyyRbFwvZT5kxnwTN6g0DWnCPKbsm7VahpVebE_uFjE_4-d47cmFDjGeJ7RCW0kY3-eARZBZirBsPh9bf8SczIWPuXLCvxcBESlhUjessmmHRvAE2PXPNwDlD1yzhursTNvWM_-o_Xg1V4nS-aGNhU-1FlP940QzNY6WiqElxstzTfFmxE1SW8nqAxchbcKm6V67KVqCvDJB-gM6-gqoSIVOZqkpEMF1EmdHQpN1hIvWKNzmK' }}');"></div>
        <h2 class="text-2xl font-bold text-[#111418] dark:text-white">{{ $adminName ?? 'Building Admin' }}</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $adminEmail ?? 'admin@email.com' }}</p>
    </div>
    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-2 text-primary">Profile Details</h3>
        <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
            <li><strong>Building:</strong> {{ $buildingName ?? 'Sunrise Heights' }}</li>
            <li><strong>Role:</strong> Building Admin</li>
            <li><strong>Contact:</strong> {{ $adminContact ?? 'N/A' }}</li>
        </ul>
    </div>
    <div class="mt-6 flex justify-center">
        <a href="#" class="bg-primary text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition-colors">Edit Profile</a>
    </div>
</div>
@endsection
