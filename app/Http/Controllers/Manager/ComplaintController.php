<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Flat;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    // ✅ All complaints (latest first)
    public function index()
    {
        $buildingId = request()->user()->building_id;
        $complaints = Complaint::with(['flat', 'resident', 'building'])
                            ->where('building_id', $buildingId)
                            ->latest()
                            ->get();
        
        // Calculate stats for the dashboard
        $stats = [
            'open' => $complaints->where('status', 'Open')->count(),
            'in_progress' => $complaints->where('status', 'In Progress')->count(),
            'resolved' => $complaints->where('status', 'Resolved')->count(),
        ];

        return view('manager.complaints.index', compact('complaints', 'stats'));
    }

    // ✅ Show create complaint form
    public function create()
    {
        $buildingId = request()->user()->building_id;
        $flats = Flat::where('building_id', $buildingId)->get();
        $residents = Resident::where('building_id', $buildingId)->get();
        
        return view('manager.complaints.create', compact('flats', 'residents'));
    }

    // ✅ Store new complaint
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'flat_id' => 'required|exists:flats,id',
            'resident_id' => 'required|exists:residents,id',
            'priority' => 'required|in:Low,Medium,High',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $buildingId = request()->user()->building_id;
        
        $complaint = new Complaint();
        $complaint->title = $request->title;
        $complaint->description = $request->description;
        $complaint->flat_id = $request->flat_id;
        $complaint->resident_id = $request->resident_id;
        $complaint->building_id = $buildingId;
        $complaint->status = 'Open';
        $complaint->priority = $request->priority;
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('complaints', 'public');
            $complaint->image = $path;
        }
        
        $complaint->save();

        logActivity('Manager created new complaint');

        return redirect()->route('manager.complaints.index')->with('success', 'Complaint created successfully');
    }

    // ✅ Show complaint details
    public function show($id)
    {
        $buildingId = request()->user()->building_id;
        $complaint = Complaint::with(['flat', 'resident', 'building'])->where('building_id', $buildingId)->findOrFail($id);
        
        return view('manager.complaints.show', compact('complaint'));
    }

    // ✅ Show edit complaint form
    public function edit($id)
    {
        $buildingId = request()->user()->building_id;
        $complaint = Complaint::where('building_id', $buildingId)->findOrFail($id);
        $flats = Flat::where('building_id', $buildingId)->get();
        $residents = Resident::where('building_id', $buildingId)->get();
        
        return view('manager.complaints.edit', compact('complaint', 'flats', 'residents'));
    }

    // ✅ Update complaint
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'flat_id' => 'required|exists:flats,id',
            'resident_id' => 'required|exists:residents,id',
            'priority' => 'required|in:Low,Medium,High',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $buildingId = request()->user()->building_id;
        $complaint = Complaint::where('building_id', $buildingId)->findOrFail($id);
        
        $complaint->title = $request->title;
        $complaint->description = $request->description;
        $complaint->flat_id = $request->flat_id;
        $complaint->resident_id = $request->resident_id;
        $complaint->priority = $request->priority;
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($complaint->image) {
                Storage::disk('public')->delete($complaint->image);
            }
            $path = $request->file('image')->store('complaints', 'public');
            $complaint->image = $path;
        }
        
        $complaint->save();

        logActivity('Manager updated complaint');

        return redirect()->route('manager.complaints.show', $complaint->id)->with('success', 'Complaint updated successfully');
    }

    // ✅ Delete complaint
    public function destroy($id)
    {
        $buildingId = request()->user()->building_id;
        $complaint = Complaint::where('building_id', $buildingId)->findOrFail($id);
        
        // Delete image if exists
        if ($complaint->image) {
            Storage::disk('public')->delete($complaint->image);
        }
        
        $complaint->delete();

        logActivity('Manager deleted complaint');

        return redirect()->route('manager.complaints.index')->with('success', 'Complaint deleted successfully');
    }

    // ✅ Manager can update status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $buildingId = request()->user()->building_id;
        $complaint = Complaint::where('building_id', $buildingId)->findOrFail($id);
        $complaint->update(['status' => $request->status]);

        logActivity('Manager updated complaint status');

        return back()->with('success', 'Status Updated by Manager');
    }
}
