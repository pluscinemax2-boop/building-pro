<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        // For now, return the view with placeholder data
        // In a real implementation, this would fetch actual reports for the manager's building
        $buildingId = request()->user()->building_id;
        
        $reports = collect([
            ['title' => 'Monthly Complaints Report', 'date' => 'Dec 2023', 'type' => 'PDF'],
            ['title' => 'Expenses Summary Q4', 'date' => 'Dec 2023', 'type' => 'PDF'],
            ['title' => 'Residents Activity Report', 'date' => 'Dec 2023', 'type' => 'PDF'],
        ]);
        
        return view('manager.reports.index', compact('reports'));
    }
}
