<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceViewController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        $invoice = Invoice::with(['building', 'subscription.plan'])
            ->where('building_id', $user->building->id)
            ->findOrFail($id);
        return view('building-admin.invoice-view', compact('invoice'));
    }

    public function downloadPdf($id)
    {
        $user = Auth::user();
        $invoice = Invoice::with(['building', 'subscription.plan'])
            ->where('building_id', $user->building->id)
            ->findOrFail($id);
        $pdf = Pdf::loadView('pdfs.invoice', compact('invoice'));
        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
