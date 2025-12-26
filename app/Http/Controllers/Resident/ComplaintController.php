<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Flat;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function create($flatId)
    {
        $flat = Flat::findOrFail($flatId);
        return view('resident.complaints.create', compact('flat'));
    }

    public function store(Request $request, $flatId)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $flat = Flat::findOrFail($flatId);

        Complaint::create([
            'building_id' => $flat->building_id,
            'flat_id' => $flatId,
            'resident_id' => $flat->resident->id ?? null,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Open',
        ]);

        return back()->with('success', 'Complaint Submitted');

        logActivity('Resident created a complaint');
    }
}
