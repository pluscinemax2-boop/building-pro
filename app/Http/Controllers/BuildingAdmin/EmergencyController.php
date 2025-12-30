<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmergencyAlert;

class EmergencyController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $building = $user->building;
        
        $query = EmergencyAlert::where('building_id', $building->id);
        
        // Apply status filter if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Apply search filter if provided
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%');
        }
        
        $alerts = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('building-admin.emergency-alerts', compact('alerts'));
    }
    
    public function create()
    {
        return view('building-admin.emergency.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:draft,scheduled,sent',
            'scheduled_at' => 'nullable|date|after:now',
        ]);
        
        $user = Auth::user();
        $building = $user->building;
        
        $alert = EmergencyAlert::create([
            'title' => $request->title,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => $request->status,
            'scheduled_at' => $request->status === 'scheduled' ? $request->scheduled_at : null,
            'building_id' => $building->id,
            'created_by' => $user->id,
        ]);
        
        return redirect()->route('building-admin.emergency')->with('success', 'Emergency alert created successfully!');
    }
    
    public function show(EmergencyAlert $emergency)
    {
        return view('building-admin.emergency.show', compact('emergency'));
    }
    
    public function edit(EmergencyAlert $emergency)
    {
        return view('building-admin.emergency.edit', compact('emergency'));
    }
    
    public function update(Request $request, EmergencyAlert $emergency)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:draft,scheduled,sent',
            'scheduled_at' => 'nullable|date|after:now',
        ]);
        
        $emergency->update([
            'title' => $request->title,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => $request->status,
            'scheduled_at' => $request->status === 'scheduled' ? $request->scheduled_at : null,
        ]);
        
        return redirect()->route('building-admin.emergency')->with('success', 'Emergency alert updated successfully!');
    }
    
    public function destroy(EmergencyAlert $emergency)
    {
        $emergency->delete();
        
        return redirect()->route('building-admin.emergency')->with('success', 'Emergency alert deleted successfully!');
    }
}
