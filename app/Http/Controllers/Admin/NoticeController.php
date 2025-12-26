<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    // List all notices
    public function index()
    {
        $notices = Notice::orderByDesc('created_at')->get();
        return view('admin.notices.index', compact('notices'));
    }

    // Show form to create a notice
    public function create()
    {
        return view('admin.notices.create');
    }

    // Store a new notice
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        Notice::create([
            'title' => $request->title,
            'content' => $request->content,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active'),
            'created_by' => Auth::id(),
        ]);
        // TODO: Implement notifications to users
        return redirect()->route('admin.notices.index')->with('success', 'Notice posted successfully.');
    }

    // Show form to edit a notice
    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        return view('admin.notices.edit', compact('notice'));
    }

    // Update a notice
    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        $notice->update([
            'title' => $request->title,
            'content' => $request->content,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active'),
        ]);
        return redirect()->route('admin.notices.index')->with('success', 'Notice updated successfully.');
    }

    // Delete a notice
    public function destroy($id)
    {
        Notice::findOrFail($id)->delete();
        return redirect()->route('admin.notices.index')->with('success', 'Notice deleted successfully.');
    }
}
