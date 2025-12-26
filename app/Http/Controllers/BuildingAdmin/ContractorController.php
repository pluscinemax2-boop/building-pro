<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use Illuminate\Http\Request;

class ContractorController extends Controller
{
    public function index()
    {
        $contractors = Contractor::all();
        return view('building-admin.contractors.index', compact('contractors'));
    }

    public function create()
    {
        return view('building-admin.contractors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        Contractor::create($request->all());
        return redirect()->route('building-admin.contractors.index')->with('success', 'Contractor added successfully.');
    }

    public function edit($id)
    {
        $contractor = Contractor::findOrFail($id);
        return view('building-admin.contractors.edit', compact('contractor'));
    }

    public function update(Request $request, $id)
    {
        $contractor = Contractor::findOrFail($id);
        $contractor->update($request->all());
        return redirect()->route('building-admin.contractors.index')->with('success', 'Contractor updated successfully.');
    }

    public function destroy($id)
    {
        Contractor::findOrFail($id)->delete();
        return redirect()->route('building-admin.contractors.index')->with('success', 'Contractor deleted successfully.');
    }
}
