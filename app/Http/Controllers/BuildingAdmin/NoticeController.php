<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\SecurityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Notice::where('building_id', $user->building_id);

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('body', 'like', '%'.$request->search.'%');
            });
        }

        // Tabs (status)
        $tab = $request->input('tabs', 'Active');
        $now = now()->toDateString();
        if ($tab === 'Active') {
            $query->where(function($q) use ($now) {
                $q->whereNull('visible_from')->orWhere('visible_from', '<=', $now);
            })->where(function($q) use ($now) {
                $q->whereNull('visible_to')->orWhere('visible_to', '>=', $now);
            });
        } elseif ($tab === 'Scheduled') {
            $query->where('visible_from', '>', $now);
        } elseif ($tab === 'Expired') {
            $query->where('visible_to', '<', $now);
        }

        $notices = $query->orderByDesc('created_at')->get();

        // Counts for tabs
        $counts = [
            'active' => Notice::where('building_id', $user->building_id)
                ->where(function($q) use ($now) {
                    $q->whereNull('visible_from')->orWhere('visible_from', '<=', $now);
                })->where(function($q) use ($now) {
                    $q->whereNull('visible_to')->orWhere('visible_to', '>=', $now);
                })->count(),
            'scheduled' => Notice::where('building_id', $user->building_id)
                ->where('visible_from', '>', $now)->count(),
            'expired' => Notice::where('building_id', $user->building_id)
                ->where('visible_to', '<', $now)->count(),
        ];

        // Add computed properties for UI
        foreach ($notices as $notice) {
            // Image fallback
            $notice->image_url = $notice->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCCa3i0_knWNnWeER5n_Q8u8FJiCxNu9b3NPn36LqiRg6TIhfwHiXvplksa92hupbpAmuZvpb6DpbJ1DtT0yc4svuEnINFM0He_3raQ0wu4ogMum_QfassFN7FJdYQ_AlkYntbF2etyqNt9_0OURDYs3fxNRw40hbUWO3YZwy5-u1oIhsFcyivjgyt9FRvVAU0Q48J_ux-EWSchpUXVPmBXU2vGU0_Oe86cDngNgWdqcpnwGnDAicz5a6RggTWTS-i3aQ95SiljQPAt';
            // Status badge
            if ($notice->visible_to && $notice->visible_to < $now) {
                $notice->status_badge = 'Expired';
                $notice->status_badge_bg = 'bg-gray-500/90';
                $notice->status_badge_pulse = false;
            } elseif ($notice->visible_from && $notice->visible_from > $now) {
                $notice->status_badge = 'Scheduled';
                $notice->status_badge_bg = 'bg-orange-500/90';
                $notice->status_badge_pulse = false;
            } else {
                $notice->status_badge = 'Live';
                $notice->status_badge_bg = 'bg-green-500/90';
                $notice->status_badge_pulse = true;
            }
            // Expires label
            if ($notice->visible_to) {
                $notice->expires_label = 'Expires: ' . Carbon::parse($notice->visible_to)->format('M d, Y');
            } elseif ($notice->visible_from && $notice->visible_from > $now) {
                $notice->expires_label = 'Scheduled: ' . Carbon::parse($notice->visible_from)->format('M d, Y');
            } else {
                $notice->expires_label = '';
            }
        }

        return view('building-admin.notices.index', compact('notices', 'counts', 'tab'));
    }

    public function create()
    {
        return view('building-admin.notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'visible_from' => 'required|date',
            'visible_to' => 'required|date|after_or_equal:visible_from',
            'image' => 'nullable|image|max:10240', // 10MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('notices', 'public');
        }

        $notice = Notice::create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $imagePath,
            'visible_from' => $request->visible_from,
            'visible_to' => $request->visible_to,
            'posted_by' => Auth::user()->name ?? 'Admin',
            'building_id' => Auth::user()->building_id,
        ]);
        
        // Log the activity
        SecurityLog::create([
            'user_id' => Auth::id(),
            'building_id' => Auth::user()->building_id,
            'role' => Auth::user()->role->name ?? 'building-admin',
            'action' => 'Notice published',
            'description' => 'Notice "' . $request->title . '" was published by ' . Auth::user()->name,
            'ip_address' => $request->ip(),
            'url' => $request->url(),
        ]);
        
        return redirect()->route('building-admin.notices.index')->with('success', 'Notice posted successfully.');
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        return view('building-admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'visible_from' => 'required|date',
            'visible_to' => 'required|date|after_or_equal:visible_from',
            'image' => 'nullable|image|max:10240', // 10MB
        ]);

        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'visible_from' => $request->visible_from,
            'visible_to' => $request->visible_to,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($notice->image) {
                \Storage::disk('public')->delete($notice->image);
            }
            $data['image'] = $request->file('image')->store('notices', 'public');
        }

        $notice->update($data);
        return redirect()->route('building-admin.notices.index')->with('success', 'Notice updated successfully.');
    }

    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);
        // Delete image from storage if exists
        if ($notice->image) {
            \Storage::disk('public')->delete($notice->image);
        }
        $notice->delete();
        return redirect()->route('building-admin.notices.index')->with('success', 'Notice deleted successfully.');
    }
}
