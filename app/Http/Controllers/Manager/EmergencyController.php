<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\EmergencyAlert;

class EmergencyController extends Controller
{
    public function index()
    {
        $alerts = EmergencyAlert::latest()->get();

        return view('manager.emergency.index', compact('alerts'));
    }
}
