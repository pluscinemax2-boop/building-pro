<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Payment;
use App\Services\FpdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BillingReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Generate monthly billing report
     */
    public function monthly(Building $building, Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $year = Carbon::createFromFormat('Y-m', $month)->year;
        $monthNum = Carbon::createFromFormat('Y-m', $month)->month;

        // Get billing data for the month
        $payments = Payment::where('building_id', $building->id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->with('user', 'subscription')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $payments->sum('amount');
        $totalPayments = $payments->count();
        $successfulPayments = $payments->where('status', 'completed')->count();

        // Render blade template
        $html = view('pdfs.billing-report', [
            'building' => $building,
            'payments' => $payments,
            'month' => $month,
            'totalRevenue' => $totalRevenue,
            'totalPayments' => $totalPayments,
            'successfulPayments' => $successfulPayments,
        ])->render();

        $pdf = new FpdfService();
        $pdf->addHtmlPage($html);
        return response($pdf->Output('S', $building->slug . '-billing-' . $month . '.pdf'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $building->slug . '-billing-' . $month . '.pdf"');
    }

    /**
     * Generate annual billing report
     */
    public function annual(Building $building, Request $request)
    {
        $year = $request->input('year', now()->year);

        // Get monthly summaries
        $monthlyData = [];
        $totalRevenue = 0;

        for ($month = 1; $month <= 12; $month++) {
            $monthPayments = Payment::where('building_id', $building->id)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where('status', 'completed')
                ->get();

            $monthRevenue = $monthPayments->sum('amount');
            $monthlyData[Carbon::createFromDate($year, $month, 1)->format('F')] = [
                'revenue' => $monthRevenue,
                'count' => $monthPayments->count(),
            ];

            $totalRevenue += $monthRevenue;
        }

        $pdfService = new PdfService();
        $pdfService->init();

        $html = view('pdfs.annual-report', [
            'building' => $building,
            'year' => $year,
            'monthlyData' => $monthlyData,
            'totalRevenue' => $totalRevenue,
        ])->render();

        $pdfService->html($html)
            ->metadata(
                'Annual Billing Report - ' . $building->name . ' - ' . $year,
                'Building Manager Pro',
                'Annual Billing Report'
            );

        return $pdfService->download($building->slug . '-annual-' . $year . '.pdf');
    }

    /**
     * Show billing report preview
     */
    public function preview(Building $building, Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $year = Carbon::createFromFormat('Y-m', $month)->year;
        $monthNum = Carbon::createFromFormat('Y-m', $month)->month;

        $payments = Payment::where('building_id', $building->id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->with('user', 'subscription')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $payments->sum('amount');
        $totalPayments = $payments->count();
        $successfulPayments = $payments->where('status', 'completed')->count();

        return view('pdfs.billing-report-preview', [
            'building' => $building,
            'payments' => $payments,
            'month' => $month,
            'totalRevenue' => $totalRevenue,
            'totalPayments' => $totalPayments,
            'successfulPayments' => $successfulPayments,
        ]);
    }
}
