<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Flat;
use App\Models\Resident;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the manager's building
        $user = request()->user();
        $buildingId = $user->building_id;
        
        $totalFlats      = Flat::where('building_id', $buildingId)->count();
        $totalResidents  = Resident::where('building_id', $buildingId)->count();
        $openComplaints  = Complaint::where('building_id', $buildingId)
                                    ->where('status', 'Open')->count();
        $inProgress      = Complaint::where('building_id', $buildingId)
                                    ->where('status', 'In Progress')->count();
        $resolvedToday   = Complaint::where('building_id', $buildingId)
                                    ->where('status', 'Resolved')
                                    ->whereDate('updated_at', today())
                                    ->count();
        $pendingApproval = Complaint::where('building_id', $buildingId)
                                    ->where('status', 'Pending Approval')->count();
        $recentComplaints = Complaint::with(['flat', 'resident', 'building'])
                                    ->where('building_id', $buildingId)
                                    ->latest()
                                    ->limit(3)
                                    ->get();

        $user = request()->user();
        
        return view('manager.dashboard', compact(
            'user',
            'totalFlats',
            'totalResidents',
            'openComplaints',
            'inProgress',
            'resolvedToday',
            'pendingApproval',
            'recentComplaints'
        ));
    }
}