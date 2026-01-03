<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SecurityLog; // Using existing SecurityLog model for activity tracking
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $building = $user->building;
        
        // Get filter parameters
        $filter = $request->get('filter', 'all');
        $search = $request->get('search', '');
        
        // Start building the query
        $logsQuery = SecurityLog::where('building_id', $building->id)
                              ->with('user') // Load user relationship
                              ->orderBy('created_at', 'desc');
        
        // Apply filter based on action type
        switch ($filter) {
            case 'expenses':
                $logsQuery->where('action', 'like', '%expense%');
                break;
            case 'complaints':
                $logsQuery->where('action', 'like', '%complaint%');
                break;
            case 'documents':
                $logsQuery->where('action', 'like', '%document%');
                break;
            case 'notices':
                $logsQuery->where('action', 'like', '%notice%');
                break;
        }
        
        // Apply search if provided
        if ($search) {
            $logsQuery->where(function($query) use ($search) {
                $query->where('action', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhereHas('user', function($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
            });
        }
        
        $logs = $logsQuery->paginate(20);
        
        // Get counts for filter options
        $stats = [
            'total' => SecurityLog::where('building_id', $building->id)->count(),
            'expenses' => SecurityLog::where('building_id', $building->id)->where('action', 'like', '%expense%')->count(),
            'complaints' => SecurityLog::where('building_id', $building->id)->where('action', 'like', '%complaint%')->count(),
            'documents' => SecurityLog::where('building_id', $building->id)->where('action', 'like', '%document%')->count(),
            'notices' => SecurityLog::where('building_id', $building->id)->where('action', 'like', '%notice%')->count(),
        ];
        
        return view('building-admin.activity-log', compact('logs', 'stats', 'filter', 'search'));
    }
}