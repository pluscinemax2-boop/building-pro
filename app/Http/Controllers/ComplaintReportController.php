<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Complaint;
use App\Services\FpdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ComplaintReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Generate complaint report for a building
     */
    public function building(Building $building, Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $year = Carbon::createFromFormat('Y-m', $month)->year;
        $monthNum = Carbon::createFromFormat('Y-m', $month)->month;

        // Get complaints for the month
        $complaints = Complaint::where('building_id', $building->id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->with('user', 'assignedTo')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $stats = [
            'total' => $complaints->count(),
            'open' => $complaints->where('status', 'open')->count(),
            'in_progress' => $complaints->where('status', 'in_progress')->count(),
            'resolved' => $complaints->where('status', 'resolved')->count(),
            'closed' => $complaints->where('status', 'closed')->count(),
        ];

        // By category
        $byCategory = $complaints->groupBy('category')->map(function ($group) {
            return $group->count();
        });

        // Average resolution time
        $resolvedComplaints = $complaints->filter(function ($complaint) {
            return $complaint->resolved_at && $complaint->created_at;
        });

        $avgResolutionTime = $resolvedComplaints->count() > 0
            ? round($resolvedComplaints->map(function ($complaint) {
                return $complaint->resolved_at->diffInDays($complaint->created_at);
            })->avg(), 1)
            : 0;

        $html = view('pdfs.complaint-report', [
            'building' => $building,
            'complaints' => $complaints,
            'month' => $month,
            'stats' => $stats,
            'byCategory' => $byCategory,
            'avgResolutionTime' => $avgResolutionTime,
        ])->render();

        $pdf = new FpdfService();
        $pdf->addHtmlPage($html);
        return response($pdf->Output('S', $building->slug . '-complaints-' . $month . '.pdf'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $building->slug . '-complaints-' . $month . '.pdf"');
    }

    /**
     * Generate complaint analytics report
     */
    public function analytics(Building $building, Request $request)
    {
        $months = $request->input('months', 12);
        $startDate = now()->subMonths($months)->startOfMonth();

        // Get monthly complaint trends
        $monthlyTrends = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = Complaint::where('building_id', $building->id)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyTrends[$date->format('M Y')] = $count;
        }

        // Category breakdown
        $categoryStats = Complaint::where('building_id', $building->id)
            ->where('created_at', '>=', $startDate)
            ->groupBy('category')
            ->selectRaw('category, count(*) as count, avg(DATEDIFF(resolved_at, created_at)) as avg_resolution')
            ->get()
            ->keyBy('category');

        $pdfService = new PdfService();
        $pdfService->init();

        $html = view('pdfs.complaint-analytics', [
            'building' => $building,
            'monthlyTrends' => $monthlyTrends,
            'categoryStats' => $categoryStats,
            'months' => $months,
        ])->render();

        $pdfService->html($html)
            ->metadata(
                'Complaint Analytics - ' . $building->name,
                'Building Manager Pro',
                'Complaint Analytics'
            );

        return $pdfService->download($building->slug . '-complaint-analytics.pdf');
    }

    /**
     * Show complaint report preview
     */
    public function preview(Building $building, Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $year = Carbon::createFromFormat('Y-m', $month)->year;
        $monthNum = Carbon::createFromFormat('Y-m', $month)->month;

        $complaints = Complaint::where('building_id', $building->id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->with('user', 'assignedTo')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $complaints->count(),
            'open' => $complaints->where('status', 'open')->count(),
            'in_progress' => $complaints->where('status', 'in_progress')->count(),
            'resolved' => $complaints->where('status', 'resolved')->count(),
            'closed' => $complaints->where('status', 'closed')->count(),
        ];

        $byCategory = $complaints->groupBy('category')->map(function ($group) {
            return $group->count();
        });

        return view('pdfs.complaint-report-preview', [
            'building' => $building,
            'complaints' => $complaints,
            'month' => $month,
            'stats' => $stats,
            'byCategory' => $byCategory,
        ]);
    }
}
