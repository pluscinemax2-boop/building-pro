<?php

namespace App\Http\Controllers\BuildingAdmin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flat;
use App\Models\Building;


class FlatController extends Controller
{
    public function show($flat)
    {
        $flat = Flat::findOrFail($flat);
        // You can pass more related data if needed
        return view('building-admin.flats.show', compact('flat'));
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $filter = $request->query('filter', 'all');
        $search = $request->query('search', '');
        $query = Flat::where('building_id', $user->building_id);
        if ($filter === 'occupied') {
            $query->where('status', 'occupied');
        } elseif ($filter === 'vacant') {
            $query->where('status', 'vacant');
        } elseif ($filter === 'maintenance') {
            $query->where('status', 'maintenance');
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('flat_number', 'like', "%$search%")
                  ->orWhere('number', 'like', "%$search%")
                  ->orWhere('resident_name', 'like', "%$search%")
                  ->orWhere('block', 'like', "%$search%")
                  ->orWhere('floor', 'like', "%$search%")
                  ->orWhere('type', 'like', "%$search%")
                  ;
            });
        }
        $flats = $query->get();
        $allFlats = Flat::all();
        $stats = [
            'total' => $allFlats->count(),
            'occupied' => $allFlats->where('status', 'occupied')->count(),
            'vacant' => $allFlats->where('status', 'vacant')->count(),
        ];
        return view('building-admin.flat-management', compact('flats', 'stats', 'filter', 'search'));
    }


    public function create()
    {
        $building = auth()->user()->building;
        return view('building-admin.flats.create', compact('building'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'flat_number' => 'required|string|max:20',
            'floor_number' => 'required|integer',
            'bhk' => 'required|string',
            'area' => 'nullable|integer',
            'price' => 'nullable|integer',
            'status' => 'nullable|string',
        ]);

        $flat = Flat::create([
            'building_id' => $validated['building_id'],
            'flat_number' => $validated['flat_number'],
            'floor' => $validated['floor_number'],
            'type' => $validated['bhk'],
            'status' => $validated['status'] ?? 'vacant',
            // Add area, price if you add to fillable/model
        ]);

        return redirect()->route('building-admin.flat-management.index')->with('success', 'Flat created successfully.');
    }


    public function edit($flat)
    {
        $flat = Flat::findOrFail($flat);
        return view('building-admin.flats.edit', [
            'flat' => $flat,
        ]);
    }


    public function update(Request $request, $flat)
    {
        $flat = Flat::findOrFail($flat);
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'flat_number' => 'required|string|max:255',
            'floor_number' => 'required|integer',
            'bhk' => 'required|string',
            'area' => 'nullable|integer',
            'price' => 'nullable|integer',
            'status' => 'nullable|string',
        ]);
        $flat->update([
            'building_id' => $validated['building_id'],
            'flat_number' => $validated['flat_number'],
            'floor' => $validated['floor_number'],
            'type' => $validated['bhk'],
            'status' => $validated['status'] ?? 'vacant',
            // Add area, price if you add to fillable/model
        ]);
        return redirect()->route('building-admin.flat-management.index')->with('success', 'Flat updated successfully.');
    }


    public function destroy($flat)
    {
        $flat = Flat::findOrFail($flat);
        $flat->delete();
        return redirect()->route('building-admin.flat-management.index')->with('success', 'Flat deleted successfully.');
    }
}
