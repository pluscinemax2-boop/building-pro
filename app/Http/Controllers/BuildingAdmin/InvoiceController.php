<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $building = $user->building;
        $invoices = Invoice::with(['building', 'subscription.plan'])
            ->where('building_id', $building->id)
            ->latest('issue_date')
            ->get();
        return view('building-admin.invoices', compact('invoices'));
    }
}
