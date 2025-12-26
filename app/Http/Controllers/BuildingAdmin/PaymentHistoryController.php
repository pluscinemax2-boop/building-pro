<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $building = $user->building;
        // Fetch real payments for this building, with subscription and plan
        $payments = \App\Models\Payment::with(['subscription.plan'])
            ->where('building_id', $building->id)
            ->latest()
            ->get();
        return view('building-admin.payment-history', compact('payments'));
    }
}
