<?php
namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    // Show all complaints (View All page)
    public function all(Request $request)
    {
        $user = auth()->user();
        $query = \App\Models\Complaint::where('building_id', $user->building_id);
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('description', 'like', "%$search%")
                  ->orWhere('title', 'like', "%$search%")
                  ->orWhere('id', $search);
        }
        $complaints = $query->orderByDesc('created_at')->paginate(20);
        return view('building-admin.complaints.all', compact('complaints'));
    }
    public function updateStatus(Request $request, $id)
    {
        $complaint = \App\Models\Complaint::findOrFail($id);
        $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved',
        ]);
        $complaint->status = $request->input('status');
        $complaint->save();
        return redirect()->route('building-admin.complaints.index')->with('success', 'Complaint status updated!');
    }
    public function store(Request $request)
    {
        $request->validate([
            'flat_id' => 'required|exists:flats,id',
            'resident_id' => 'required|exists:residents,id',
            'description' => 'required',
            'priority' => 'required|in:High,Medium,Low',
            'image' => 'nullable|image|max:4096',
        ]);
        $user = auth()->user();
        $building = $user->building;
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('complaint-images', 'public');
        }
        $complaint = \App\Models\Complaint::create([
            'building_id' => $building ? $building->id : null,
            'flat_id' => $request->input('flat_id'),
            'resident_id' => $request->input('resident_id'),
            'title' => $request->input('category', 'Complaint'),
            'description' => $request->input('description'),
            'priority' => $request->input('priority', 'Medium'),
            'image' => $imagePath,
            'status' => 'Open',
        ]);
        return redirect()->route('building-admin.complaints.index')->with('success', 'Complaint submitted successfully!');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = \App\Models\Complaint::where('building_id', $user->building_id);
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('description', 'like', "%$search%")
                  ->orWhere('title', 'like', "%$search%")
                  ->orWhere('id', $search);
        }
        $complaints = $query->orderByDesc('created_at')->get();
        $stats = [
            'total' => $complaints->count(),
            'open' => $complaints->where('status', 'Open')->count(),
            'in_progress' => $complaints->where('status', 'In Progress')->count(),
            'resolved' => $complaints->where('status', 'Resolved')->count(),
        ];
        return view('building-admin.complaints.index', compact('complaints', 'stats'));
    }

    public function create()
    {
        // Get current building for the admin
        $user = auth()->user();
        $building = $user->building;
        $flats = $building ? $building->flats()->orderBy('flat_number')->get() : collect();
        $residents = \App\Models\Resident::whereIn('flat_id', $flats->pluck('id'))->orderBy('name')->get();
        return view('building-admin.complaints.create', compact('flats', 'residents'));
    }
    // Show a single complaint detail
    public function show($id)
    {
        $complaint = \App\Models\Complaint::with(['flat', 'resident', 'building'])->findOrFail($id);
        return view('building-admin.complaints.show', compact('complaint'));
    }
}
