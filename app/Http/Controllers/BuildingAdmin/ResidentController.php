<?php

namespace App\Http\Controllers\BuildingAdmin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Flat;

class ResidentController extends Controller
{

    public function index()
    {
        $residents = Resident::all();
        // You may want to pass $stats and $flats if needed for the new design
        $stats = [
            'total' => $residents->count(),
            'occupied' => $residents->where('status', 'occupied')->count(),
            'vacant' => $residents->where('status', 'vacant')->count(),
        ];
        $flats = Flat::all();
        return view('building-admin.resident-management', compact('residents', 'stats', 'flats'));
    }

    public function create()
    {
        $flats = Flat::all();
        return view('building-admin.residents.create', compact('flats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'flat_id' => 'required|exists:flats,id',
        ]);

        // Check if flat already has 2 residents
        $residentCount = Resident::where('flat_id', $validated['flat_id'])->count();
        if ($residentCount >= 2) {
            return back()->withErrors(['flat_id' => 'Maximum 2 residents allowed per flat.'])->withInput();
        }

        Resident::create($validated);
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

    public function destroy($resident)
    {
        $resident = Resident::findOrFail($resident);
        $resident->delete();
        return redirect()->route('building-admin.residents.index')->with('success', 'Resident deleted successfully.');
    }
}
