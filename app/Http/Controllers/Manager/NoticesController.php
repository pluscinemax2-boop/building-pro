<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticesController extends Controller
{
    public function index()
    {
        // Fetch notices for the manager's building
        $buildingId = request()->user()->building_id;
        $notices = Notice::where('building_id', $buildingId)->latest()->paginate(10);
        
        return view('manager.notices.index', compact('notices'));
    }
}
