<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyAlert;
use Illuminate\Http\Request;

class EmergencyAlertController extends Controller
{
    public function index()
    {
        $alerts = EmergencyAlert::latest()->get();
        return view('building-admin.emergency.index', compact('alerts'));
    }

    public function create()
    {
        return view('building-admin.emergency.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'type' => 'required',
        ]);
        EmergencyAlert::create($request->all());
        return redirect()->route('building-admin.emergency.index')->with('success', 'Emergency Alert Sent');
    }

    public function destroy($id)
    {
        EmergencyAlert::findOrFail($id)->delete();
        return back()->with('success', 'Alert Deleted');
    }
}
