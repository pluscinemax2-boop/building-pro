<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Complaint;
use App\Models\Building;
use App\Services\FpdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentReceiptController extends Controller
{


    /**
     * Generate payment receipt PDF
     */
    public function download(Payment $payment)
    {
        // Check authorization
        if (auth()->user()->id !== $payment->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized to access this payment receipt');
        }

        // Get payment with relations
        $payment = $payment->load('user', 'building', 'subscription');

        // Render blade template to HTML
        $html = view('pdfs.payment-receipt', ['payment' => $payment])->render();

        $pdf = new FpdfService();
        $pdf->addHtmlPage($html);
        return response($pdf->Output('S', 'receipt-' . $payment->id . '-' . now()->format('Y-m-d') . '.pdf'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="receipt-' . $payment->id . '-' . now()->format('Y-m-d') . '.pdf"');
    }

    /**
     * View receipt before downloading
     */
    public function preview(Payment $payment)
    {
        if (auth()->user()->id !== $payment->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $payment = $payment->load('user', 'building', 'subscription');

        return view('pdfs.payment-receipt-preview', ['payment' => $payment]);
    }
}
