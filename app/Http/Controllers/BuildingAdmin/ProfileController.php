<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $user = Auth::user();
        $building = $user->building;
        $file = $request->file('avatar');
        $path = $file->store('building-avatars', 'public');

        // Optionally delete old building image if not default
        if ($building->image_url && !str_contains($building->image_url, 'lh3.googleusercontent.com')) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $building->image_url));
        }

        $building->image_url = '/storage/' . $path;
        $building->save();

        return redirect()->route('building-admin.profile')->with('success', 'Profile image updated!');
    }
    public function show()
    {
        $user = Auth::user();
        $building = $user->building;
        // Fallbacks if any field is missing
        $buildingName = $building->name ?? 'Building';
        $buildingAddress = $building->address ?? '';
        $buildingImage = $building->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuDv9WLoiPx5ptjjbJSwxvKFZfdUXosyXv5VMQoMOj2G8Z0fVEqQ9zD5oVJBfwMmPvLJuPVJjnvK4hDcTQE_gBDeby1vZnqUzU2QpBbb96PfKhHErjB6zuOIFWaTb7at4KBZLyaVCGiVC57CFjTfwYT6P1Rom1R2ABY-y4CcsREDsP_gt7nilwnyrnSmnUBd8GebmjopZf4ZM5a0T3gXU-QUHuXviOVM6j_xygJPJbiKa5GPwj2rUgxsuTfduJOsnVMJydCEPqLTbLoO';
        $statusIcon = 'verified';
        $statusBgClass = 'bg-emerald-50 dark:bg-emerald-900/20';
        $statusTextClass = 'text-emerald-700 dark:text-emerald-400';
        $statusBorderClass = 'border-emerald-100 dark:border-emerald-800';
        $statusPingClass = 'bg-emerald-400 opacity-75';
        $statusDotClass = 'bg-emerald-500';
        $buildingStatus = $building->status ?? 'Active';
        $city = $building->city ?? '';
        $state = $building->state ?? '';
        $zip = $building->zip ?? '';
        $emergencyPhone = $building->emergency_phone ?? '';

        // Add missing variables with fallbacks
        $totalFloors = $building->total_floors ?? '';
        $totalFlats = $building->total_flats ?? '';
        $managerName = $building->manager_name ?? '';

        $generalInfo = [
            ['icon' => 'location_city', 'label' => 'City', 'value' => $city],
            ['icon' => 'map', 'label' => 'State', 'value' => $state],
            ['icon' => 'pin_drop', 'label' => 'Zip Code', 'value' => $zip],
        ];
        $capacityInfo = [
            ['icon' => 'stairs', 'label' => 'Total Floors', 'value' => $totalFloors],
            ['icon' => 'door_front', 'label' => 'Total Flats', 'value' => $totalFlats],
        ];
        $contactInfo = [
            ['icon' => 'person', 'label' => 'Manager', 'value' => $managerName],
            ['icon' => 'phone_in_talk', 'label' => 'Emergency', 'value' => $emergencyPhone, 'class' => 'text-primary group-hover/phone:underline cursor-pointer'],
        ];

        return view('building-admin.building-profile', [
            'pageTitle' => 'Building Profile',
            'buildingName' => $buildingName,
            'buildingAddress' => $buildingAddress,
            'buildingImage' => $buildingImage,
            'buildingImageAlt' => $buildingName,
            'statusIcon' => $statusIcon,
            'statusBgClass' => $statusBgClass,
            'statusTextClass' => $statusTextClass,
            'statusBorderClass' => $statusBorderClass,
            'statusPingClass' => $statusPingClass,
            'statusDotClass' => $statusDotClass,
            'buildingStatus' => $buildingStatus,
            'generalInfo' => $generalInfo,
            'capacityInfo' => $capacityInfo,
            'contactInfo' => $contactInfo,
            'editButtonIcon' => 'edit_document',
            'editButtonText' => 'Edit Information',
        ]);
    }
}
