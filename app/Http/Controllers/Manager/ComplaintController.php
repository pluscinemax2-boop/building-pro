<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    // ✅ All complaints (latest first)
    public function index()
    {
        $complaints = Complaint::with(['flat', 'resident', 'building'])->latest()->get();

        return view('manager.complaints.index', compact('complaints'));
    }

    // ✅ Manager can update status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->update(['status' => $request->status]);

        logActivity('Manager updated complaint status');

        return back()->with('success', 'Status Updated by Manager');
    }
}
