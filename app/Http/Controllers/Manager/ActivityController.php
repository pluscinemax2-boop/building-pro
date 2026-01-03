<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = request()->user();
        $buildingId = $user->building_id;
        
        $query = Complaint::with(['flat', 'resident', 'building'])
                      ->where('building_id', $buildingId);
        
        // Apply search filter if provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('flat', function($q2) use ($search) {
                      $q2->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('resident', function($q2) use ($search) {
                      $q2->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        // Apply status filter if provided
        if ($request->has('status') && $request->status && $request->status !== 'All') {
            $query->where('status', $request->status);
        }
        
        $activities = $query->latest()->paginate(10);
        
        return view('manager.activities.index', compact('activities'));
    }
}
