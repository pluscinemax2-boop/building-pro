<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $building = $user->building;
        
        // Get the filter parameter from the request
        $filter = $request->get('filter', 'all');
        
        // Get the role ID for Manager
        $managerRole = Role::where('name', 'Manager')->first();
        
        if (!$managerRole) {
            // If Manager role doesn't exist, create it
            $managerRole = Role::create(['name' => 'Manager']);
        }
        
        // Start with all users who have the Manager role and belong to the same building
        $managersQuery = User::where('role_id', $managerRole->id)->where('building_id', $building->id);
        
        // Apply filter based on the parameter
        switch ($filter) {
            case 'active':
                $managersQuery->where('status', '!=', 'inactive');
                break;
            case 'inactive':
                $managersQuery->where('status', 'inactive');
                break;
        }
        
        $managers = $managersQuery->get();
        
        $stats = [
            'total' => User::where('role_id', $managerRole->id)->where('building_id', $building->id)->count(),
            'active' => User::where('role_id', $managerRole->id)->where('building_id', $building->id)->where('status', '!=', 'inactive')->count(),
            'inactive' => User::where('role_id', $managerRole->id)->where('building_id', $building->id)->where('status', 'inactive')->count(),
        ];
        
        return view('building-admin.manager-management', compact('managers', 'stats', 'filter'));
    }

    public function create()
    {
        return view('building-admin.managers.create');
    }

    public function store(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $building = $user->building;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $managerRole = Role::where('name', 'Manager')->first();
        if (!$managerRole) {
            $managerRole = Role::create(['name' => 'Manager']);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt('123456'), // Default password
            'role_id' => $managerRole->id,
            'status' => $validated['status'], // Use provided status
            'building_id' => $building->id, // Assign to current building
        ]);

        // Send account creation notification email
        try {
            Mail::to($user->email)->send(new \App\Mail\AccountCreatedMail($user, '123456'));
        } catch (\Exception $e) {
            // Log the error but don't fail the creation
            Log::warning('Failed to send account creation email: ' . $e->getMessage());
        }

        return redirect()->route('building-admin.manager-management.index')->with('success', 'Manager created successfully.');
    }

    public function edit($manager)
    {
        $buildingAdmin = \Illuminate\Support\Facades\Auth::user();
        $building = $buildingAdmin->building;
        
        $manager = User::where('id', $manager)
                    ->where('building_id', $building->id)
                    ->where('role_id', function($query) {
                        $query->select('id')->from('roles')->where('name', 'Manager');
                    })
                    ->firstOrFail();
        return view('building-admin.managers.edit', compact('manager'));
    }

    public function update(Request $request, $manager)
    {
        $buildingAdmin = \Illuminate\Support\Facades\Auth::user();
        $building = $buildingAdmin->building;
        
        $manager = User::where('id', $manager)
                    ->where('building_id', $building->id)
                    ->where('role_id', function($query) {
                        $query->select('id')->from('roles')->where('name', 'Manager');
                    })
                    ->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $manager->id,
            'phone' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $manager->update($validated);
        
        return redirect()->route('building-admin.manager-management.index')->with('success', 'Manager updated successfully.');
    }

    public function destroy($manager)
    {
        $buildingAdmin = \Illuminate\Support\Facades\Auth::user();
        $building = $buildingAdmin->building;
        
        $manager = User::where('id', $manager)
                    ->where('building_id', $building->id)
                    ->where('role_id', function($query) {
                        $query->select('id')->from('roles')->where('name', 'Manager');
                    })
                    ->firstOrFail();
        $manager->delete();
        
        return redirect()->route('building-admin.manager-management.index')->with('success', 'Manager deleted successfully.');
    }
}