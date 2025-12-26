<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Flat;
use App\Models\Resident;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFlats      = Flat::count();
        $totalResidents  = Resident::count();
        $openComplaints  = Complaint::where('status', 'Open')->count();
        $inProgress      = Complaint::where('status', 'In Progress')->count();

        return view('manager.dashboard', compact(
            'totalFlats',
            'totalResidents',
            'openComplaints',
            'inProgress'
        ));
    }
}
