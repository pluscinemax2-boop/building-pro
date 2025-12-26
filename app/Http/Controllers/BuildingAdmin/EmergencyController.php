<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    public function index()
    {
        // You can load emergencies for the building-admin here
        return view('building-admin.emergency.index');
    }
}
