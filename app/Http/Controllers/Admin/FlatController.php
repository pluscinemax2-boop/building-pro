<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Flat;
use Illuminate\Http\Request;

class FlatController extends Controller
{
    // ✅ List flats of a building
    public function index($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $flats = $building->flats()->with('resident')->get();

        return view('admin.flats.index', compact('building', 'flats'));
    }

    // ✅ Show create flat form
    public function create($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        return view('admin.flats.create', compact('building'));
    }

    // ✅ Store flat
    public function store(Request $request, $buildingId)
    {
        $request->validate([
            'flat_number' => 'required',
        ]);

        Flat::create([
            'building_id' => $buildingId,
            'flat_number' => $request->flat_number,
            'floor' => $request->floor,
            'type' => $request->type,
            'status' => $request->status ?? 'Available',
        ]);

        return redirect('/admin/buildings/'.$buildingId.'/flats')
               ->with('success', 'Flat Added Successfully');
    }

    // ✅ Edit flat
    public function edit($buildingId, $flatId)
    {
        $building = Building::findOrFail($buildingId);
        $flat = Flat::findOrFail($flatId);

        return view('admin.flats.edit', compact('building', 'flat'));
    }

    // ✅ Update flat
    public function update(Request $request, $buildingId, $flatId)
    {
        $flat = Flat::findOrFail($flatId);

        $flat->update([
            'flat_number' => $request->flat_number,
            'floor' => $request->floor,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect('/admin/buildings/'.$buildingId.'/flats')
               ->with('success', 'Flat Updated Successfully');
    }

    // ✅ Delete flat
    public function destroy($buildingId, $flatId)
    {
        Flat::findOrFail($flatId)->delete();

        return redirect('/admin/buildings/'.$buildingId.'/flats')
               ->with('success', 'Flat Deleted Successfully');
    }
}
// Moved to BuildingAdmin
