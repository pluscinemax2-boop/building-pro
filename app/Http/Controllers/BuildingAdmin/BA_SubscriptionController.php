<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BA_SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $building = $user->building;

        return view('building-admin.subscription', compact('user', 'building'));
    }
}
