<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\EmergencyAlert;

class EmergencyController extends Controller
{
    // ✅ Residents view alerts
    public function index()
    {
        $alerts = EmergencyAlert::latest()->get();
        return view('resident.emergency.index', compact('alerts'));
    }
}
