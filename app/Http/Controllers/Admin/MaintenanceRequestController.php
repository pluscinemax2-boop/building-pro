<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\Contractor;
use App\Models\Flat;
use App\Models\Resident;
use Illuminate\Http\Request;

class MaintenanceRequestController extends Controller
{
    // List all maintenance requests
    public function index()
    {
        $requests = MaintenanceRequest::with(['flat', 'resident', 'contractor'])->orderByDesc('created_at')->get();
        return view('admin.maintenance_requests.index', compact('requests'));
    }

    // Show form to create a new request
    public function create()
    {
        $flats = Flat::all();
        $residents = Resident::all();
        $contractors = Contractor::all();
        return view('admin.maintenance_requests.create', compact('flats', 'residents', 'contractors'));
    }

    // Store a new request
    public function store(Request $request)
    {
        $request->validate([
            'flat_id' => 'required',
            'title' => 'required',
            'requested_date' => 'required|date',
        ]);
        MaintenanceRequest::create($request->all());
        return redirect()->route('admin.maintenance_requests.index')->with('success', 'Request created successfully.');
    }

    // Show form to edit a request
    public function edit($id)
    {
        $requestItem = MaintenanceRequest::findOrFail($id);
        $flats = Flat::all();
        $residents = Resident::all();
        $contractors = Contractor::all();
        return view('admin.maintenance_requests.edit', compact('requestItem', 'flats', 'residents', 'contractors'));
    }

    // Update a request
    public function update(Request $request, $id)
    {
        $requestItem = MaintenanceRequest::findOrFail($id);
        $requestItem->update($request->all());
        return redirect()->route('admin.maintenance_requests.index')->with('success', 'Request updated successfully.');
    }

    // Delete a request
    public function destroy($id)
    {
        MaintenanceRequest::findOrFail($id)->delete();
        return redirect()->route('admin.maintenance_requests.index')->with('success', 'Request deleted successfully.');
    }

    // Change status
    public function changeStatus(Request $request, $id)
    {
        $requestItem = MaintenanceRequest::findOrFail($id);
        $requestItem->status = $request->status;
        if ($request->status === 'completed') {
            $requestItem->completed_date = now();
        }
        $requestItem->save();
        return redirect()->route('admin.maintenance_requests.index')->with('success', 'Status updated.');
    }
}
// Moved to BuildingAdmin
