<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    // Show all buildings
    public function index()
    {
        $buildings = Building::latest()->get();
        return view('admin.buildings.index', compact('buildings'));
    }

    // Show create form
    public function create()
    {
        return view('admin.buildings.create');
    }

    // Store new building
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Building::create($request->all());

        // ✅ FIXED: RELATIVE REDIRECT (NO MORE LOCALHOST)
        return redirect('/admin/buildings')
               ->with('success', 'Building Added Successfully');
    }

    // Show edit form
    public function edit($id)
    {
        $building = Building::findOrFail($id);
        return view('admin.buildings.edit', compact('building'));
    }

    // Update building
    public function update(Request $request, $id)
    {
        $building = Building::findOrFail($id);

        $request->validate([
            'name' => 'required',
        ]);

         $building->update($request->all());

         // Redirect to building-management after update
         return redirect('/admin/building-management')
             ->with('success', 'Building Updated Successfully');
    }

    // Delete building
    public function destroy($id)
    {
         Building::findOrFail($id)->delete();

         // Redirect to building-management after delete
         return redirect('/admin/building-management')
             ->with('success', 'Building Deleted Successfully');
    }
}
