<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\EmergencyAlert;

class EmergencyController extends Controller
{
    public function index()
    {
        $buildingId = request()->user()->building_id;
        $alerts = EmergencyAlert::where('building_id', $buildingId)->latest()->get();

        return view('manager.emergency.index', compact('alerts'));
    }
}
