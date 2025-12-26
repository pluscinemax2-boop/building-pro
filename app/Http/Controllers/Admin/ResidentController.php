<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\Flat;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    // ✅ Show resident create form for a flat
    public function create($flatId)
    {
        $flat = Flat::with('resident')->findOrFail($flatId);

        // ✅ HARD BLOCK: Already occupied
        if ($flat->resident) {
            return redirect('/admin/buildings/'.$flat->building_id.'/flats')
                ->with('success', 'This flat is already occupied.');
        }

        return view('admin.residents.create', compact('flat'));
    }


    // ✅ Store resident & assign to flat
    public function store(Request $request, $flatId)
    {
        $flat = Flat::with('resident')->findOrFail($flatId);

        // ✅ FINAL SECURITY BLOCK
        if ($flat->resident) {
            return redirect('/admin/buildings/'.$flat->building_id.'/flats')
                ->with('success', 'Resident already exists for this flat.');
        }

        $request->validate([
            'name' => 'required',
        ]);

        Resident::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'flat_id' => $flatId,
        ]);

        Flat::where('id', $flatId)->update([
            'status' => 'Occupied'
        ]);

        return redirect('/admin/buildings/'.$request->building_id.'/flats')
            ->with('success', 'Resident Assigned Successfully');

        logActivity('Admin assigned resident to flat');    
        }


    // ✅ Edit resident
    public function edit($residentId)
    {
        $resident = Resident::findOrFail($residentId);
        return view('admin.residents.edit', compact('resident'));
    }

    // ✅ Update resident
    public function update(Request $request, $residentId)
    {
        $resident = Resident::findOrFail($residentId);

        $resident->update($request->only('name','email','phone'));

        return back()->with('success', 'Resident Updated Successfully');
    }

    // ✅ Delete resident + free flat
    public function destroy($residentId)
    {
        $resident = Resident::findOrFail($residentId);

        if ($resident->flat_id) {
            Flat::where('id', $resident->flat_id)->update([
                'status' => 'Available'
            ]);
        }

        $resident->delete();

        return back()->with('success', 'Resident Removed');
    }
}
    