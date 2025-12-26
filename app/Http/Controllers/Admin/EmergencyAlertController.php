<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyAlert;
use Illuminate\Http\Request;

class EmergencyAlertController extends Controller
{
    // ✅ List all alerts
    public function index()
    {
        $alerts = EmergencyAlert::latest()->get();
        return view('admin.emergency.index', compact('alerts'));
    }

    // ✅ Show create form
    public function create()
    {
        return view('admin.emergency.create');
    }

    // ✅ Store alert
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'type' => 'required',
        ]);

        EmergencyAlert::create($request->all());

        return redirect('/admin/emergency')
               ->with('success', 'Emergency Alert Sent');
        
        logActivity('Admin sent emergency alert');       
    }

    // ✅ Delete alert
    public function destroy($id)
    {
        EmergencyAlert::findOrFail($id)->delete();
        return back()->with('success', 'Alert Deleted');
    }
}
