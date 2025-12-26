<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Building;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('building')->get();
        return view('building-admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $buildings = Building::all();
        return view('building-admin.properties.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);
        Property::create($request->all());
        return redirect()->route('building-admin.properties.index')->with('success', 'Property Added Successfully');
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);
        $buildings = Building::all();
        return view('building-admin.properties.edit', compact('property', 'buildings'));
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->update($request->all());
        return redirect()->route('building-admin.properties.index')->with('success', 'Property Updated Successfully');
    }

    public function destroy($id)
    {
        Property::findOrFail($id)->delete();
        return redirect()->route('building-admin.properties.index')->with('success', 'Property Deleted Successfully');
    }
}
