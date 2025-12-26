<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Flat;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    // ✅ List complaints of a flat
    public function index($flatId)
    {
        $flat = Flat::with('complaints.resident')->findOrFail($flatId);
        $complaints = $flat->complaints;

        return view('admin.complaints.index', compact('flat', 'complaints'));
    }

    // ✅ Update status
    public function updateStatus(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->update(['status' => $request->status]);

        return back()->with('success', 'Status Updated');

        logActivity('Admin updated complaint status');
    }

    // ✅ Delete complaint
    public function destroy($id)
    {
        Complaint::findOrFail($id)->delete();

        return back()->with('success', 'Complaint Deleted');

        logActivity('Admin deleted a complaint');
    }
}
