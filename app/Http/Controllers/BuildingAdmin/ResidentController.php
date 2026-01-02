<?php

namespace App\Http\Controllers\BuildingAdmin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Flat;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ResidentController extends Controller
{

    public function index(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $building = $user->building;
        $flats = $building ? $building->flats()->get() : collect();
        
        // Get the filter parameter from the request
        $filter = $request->get('filter', 'all');
        
        // Start with all residents in the building
        $residentsQuery = \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'));
        
        // Apply filter based on the parameter
        switch ($filter) {
            case 'occupied':
                $residentsQuery->where('status', 'occupied');
                break;
            case 'vacant':
                $residentsQuery->where('status', 'vacant');
                break;
            case 'active':
                $residentsQuery->where('status', '!=', 'inactive');
                break;
            case 'inactive':
                $residentsQuery->where('status', 'inactive');
                break;
        }
        
        $residents = $residentsQuery->get();
        
        $stats = [
            'total' => \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))->count(),
            'occupied' => \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))->where('status', 'occupied')->count(),
            'vacant' => \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))->where('status', 'vacant')->count(),
            'active' => \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))->where('status', '!=', 'inactive')->count(),
            'inactive' => \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))->where('status', 'inactive')->count(),
        ];
        
        return view('building-admin.resident-management', compact('residents', 'stats', 'flats', 'filter'));
    }

    public function create()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $building = $user->building;
        $flats = $building ? $building->flats()->get() : collect();
        return view('building-admin.residents.create', compact('flats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'flat_id' => 'required|exists:flats,id',
        ]);

        // Check if flat already has 2 residents
        $residentCount = Resident::where('flat_id', $validated['flat_id'])->count();
        if ($residentCount >= 2) {
            return back()->withErrors(['flat_id' => 'Maximum 2 residents allowed per flat.'])->withInput();
        }

        // Get the Resident role
        $residentRole = Role::where('name', 'Resident')->first();
        if (!$residentRole) {
            $residentRole = Role::create(['name' => 'Resident']);
        }

        // Create the user account first
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt('123456'), // Default password
            'role_id' => $residentRole->id,
            'status' => 'active',
        ]);

        // Create the resident record
        $resident = Resident::create($validated + ['user_id' => $user->id]);
        
        // Send account creation notification email
        try {
            Mail::to($user->email)->send(new \App\Mail\AccountCreatedMail($user, '123456'));
        } catch (\Exception $e) {
            // Log the error but don't fail the creation
            Log::warning('Failed to send account creation email: ' . $e->getMessage());
        }

        return redirect()->route('building-admin.residents.index')->with('success', 'Resident created successfully.');
    }

    public function edit($resident)
    {
        $resident = Resident::findOrFail($resident);
        $flats = Flat::all();
        return view('building-admin.residents.edit', compact('resident', 'flats'));
    }

    public function update(Request $request, $resident)
    {
        $resident = Resident::findOrFail($resident);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'flat_id' => 'required|exists:flats,id',
        ]);
        $resident->update($validated);
        return redirect()->route('building-admin.residents.index')->with('success', 'Resident updated successfully.');
    }

    public function callDirectory(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $building = $user->building;
        $flats = $building ? $building->flats()->get() : collect();
        
        // Get the filter parameter from the request
        $filter = $request->get('filter', 'all');
        
        // Start with all residents in the building
        $residentsQuery = \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))
                                    ->with('flat'); // Load flat relationship
        
        // Apply filter based on the parameter
        switch ($filter) {
            case 'occupied':
                $residentsQuery->where('status', 'occupied');
                break;
            case 'vacant':
                $residentsQuery->where('status', 'vacant');
                break;
            case 'active':
                $residentsQuery->where('status', '!=', 'inactive');
                break;
            case 'inactive':
                $residentsQuery->where('status', 'inactive');
                break;
        }
        
        $residents = $residentsQuery->get();
        
        $stats = [
            'total' => \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))->count(),
            'occupied' => \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))->where('status', 'occupied')->count(),
            'vacant' => \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))->where('status', 'vacant')->count(),
            'active' => \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))->where('status', '!=', 'inactive')->count(),
            'inactive' => \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))->where('status', 'inactive')->count(),
        ];
        
        return view('building-admin.resident-management', compact('residents', 'stats', 'flats', 'filter'));
    }

    public function exportCsv(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $building = $user->building;
        $flats = $building ? $building->flats()->get() : collect();
        
        // Get all residents in the building with their flats
        $residents = \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))
                                    ->with('flat')
                                    ->get();
        
        // Create CSV content
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="resident-directory.csv"',
        ];
        
        $callback = function() use ($residents) {
            $file = fopen('php://output', 'w');
            
            // Add CSV header
            fputcsv($file, ['Flat Number', 'Name', 'Mobile Number']);
            
            // Add data rows
            foreach ($residents as $resident) {
                fputcsv($file, [
                    $resident->flat ? $resident->flat->block . '-' . $resident->flat->flat_number : 'N/A',
                    $resident->name,
                    $resident->phone
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function destroy($resident)
    {
        $resident = Resident::findOrFail($resident);
        $resident->delete();
        return redirect()->route('building-admin.residents.index')->with('success', 'Resident deleted successfully.');
    }
}
