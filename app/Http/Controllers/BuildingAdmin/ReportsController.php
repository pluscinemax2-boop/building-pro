<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\Complaint;
use App\Models\Building;

class ReportsController extends Controller {

    // Download: Complaints Summary Report (Operational)
    public function downloadComplaintsSummary(Request $request) {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $user = Auth::user();
        $building = $user->building;
        $complaints = \App\Models\Complaint::where('building_id', $building->id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        $pdf = new \App\Services\FpdfService();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Complaints Summary Report', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(4);
        foreach ($complaints as $complaint) {
            $pdf->Cell(50, 8, 'Title:', 0, 0);
            $pdf->Cell(0, 8, $complaint->title, 0, 1);
            $pdf->Cell(50, 8, 'Status:', 0, 0);
            $pdf->Cell(0, 8, $complaint->status, 0, 1);
            $pdf->Cell(50, 8, 'Date:', 0, 0);
            $pdf->Cell(0, 8, $complaint->created_at->format('M d, Y'), 0, 1);
            $pdf->Ln(2);
        }
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(50, 10, 'Total Complaints:', 0, 0);
        $pdf->Cell(0, 10, $complaints->count(), 0, 1);
        return response($pdf->Output('S', 'complaints_summary.pdf'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="complaints_summary.pdf"',
        ]);
    }

    // Download: Amenity Usage Report (Operational, stub)
    public function downloadAmenityUsage(Request $request) {
        // TODO: Implement real amenity usage logic if data available
        $pdf = new \App\Services\FpdfService();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Amenity Usage Report', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(4);
        $pdf->Cell(0, 8, 'Amenity usage data is not implemented yet.', 0, 1);
        return response($pdf->Output('S', 'amenity_usage.pdf'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="amenity_usage.pdf"',
        ]);
    }
    // Download: Monthly Expenses Sheet
    public function downloadMonthlyExpenses(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $user = Auth::user();
        $expenses = Expense::where('created_by', $user->id)
            ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->where('status', 'approved')
            ->get();
        $pdf = new \App\Services\FpdfService();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Monthly Expenses Sheet', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(4);
        foreach ($expenses as $expense) {
            $pdf->Cell(50, 8, 'Title:', 0, 0);
            $pdf->Cell(0, 8, $expense->title, 0, 1);
            $pdf->Cell(50, 8, 'Amount:', 0, 0);
            $pdf->Cell(0, 8, 'Rs. ' . number_format($expense->amount, 2), 0, 1);
            $pdf->Cell(50, 8, 'Date:', 0, 0);
            $pdf->Cell(0, 8, \Illuminate\Support\Carbon::parse($expense->expense_date)->format('M d, Y'), 0, 1);
            $pdf->Ln(2);
        }
        return response($pdf->Output('S', 'monthly_expenses.pdf'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="monthly_expenses.pdf"',
        ]);
    }

    // Download: Maintenance Collections Report
    public function downloadMaintenanceCollections(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $user = Auth::user();
        $building = $user->building;
        // Get all successful payments for maintenance in the selected period
        $payments = \App\Models\Payment::where('building_id', $building->id)
            ->where('status', 'success')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        $pdf = new \App\Services\FpdfService();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Maintenance Collections Report', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(4);
        $total = 0;
        foreach ($payments as $payment) {
            $pdf->Cell(50, 8, 'User:', 0, 0);
            $pdf->Cell(0, 8, optional($payment->user)->name, 0, 1);
            $pdf->Cell(50, 8, 'Amount:', 0, 0);
            $pdf->Cell(0, 8, 'Rs. ' . number_format($payment->amount, 2), 0, 1);
            $pdf->Cell(50, 8, 'Date:', 0, 0);
            $pdf->Cell(0, 8, $payment->created_at->format('M d, Y'), 0, 1);
            $pdf->Ln(2);
            $total += $payment->amount;
        }
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(50, 10, 'Total Collected:', 0, 0);
        $pdf->Cell(0, 10, 'Rs. ' . number_format($total, 2), 0, 1);
        return response($pdf->Output('S', 'maintenance_collections.pdf'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="maintenance_collections.pdf"',
        ]);
    }

    // Download: Category-wise Expense Report
    public function downloadCategoryWiseExpenses(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $user = Auth::user();
        // Get all approved expenses for the selected period, grouped by category
        $expenses = \App\Models\Expense::where('created_by', $user->id)
            ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->where('status', 'approved')
            ->with('category')
            ->get()
            ->groupBy(function($exp) {
                return optional($exp->category)->name ?: 'Uncategorized';
            });
        $pdf = new \App\Services\FpdfService();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Category-wise Expense Report', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(4);
        foreach ($expenses as $category => $items) {
            $pdf->SetFont('Arial', 'B', 13);
            $pdf->Cell(0, 8, $category, 0, 1);
            $pdf->SetFont('Arial', '', 12);
            $catTotal = 0;
            foreach ($items as $expense) {
                $pdf->Cell(50, 8, 'Title:', 0, 0);
                $pdf->Cell(0, 8, $expense->title, 0, 1);
                $pdf->Cell(50, 8, 'Amount:', 0, 0);
                $pdf->Cell(0, 8, 'Rs. ' . number_format($expense->amount, 2), 0, 1);
                $pdf->Cell(50, 8, 'Date:', 0, 0);
                $pdf->Cell(0, 8, \Illuminate\Support\Carbon::parse($expense->expense_date)->format('M d, Y'), 0, 1);
                $pdf->Ln(2);
                $catTotal += $expense->amount;
            }
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(50, 8, 'Category Total:', 0, 0);
            $pdf->Cell(0, 8, 'Rs. ' . number_format($catTotal, 2), 0, 1);
            $pdf->Ln(4);
        }
        return response($pdf->Output('S', 'category_wise_expenses.pdf'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="category_wise_expenses.pdf"',
        ]);
    }

    // Download: Budget vs Actual Report
    public function downloadBudgetVsActual(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $user = Auth::user();
        $building = $user->building;
        // Get budget for the period
        $budget = \App\Models\Budget::where('building_id', $building->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();
        $budgetAmount = $budget ? $budget->amount : 0;
        // Get actual expenses for the period
        $actual = \App\Models\Expense::where('created_by', $user->id)
            ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->where('status', 'approved')
            ->sum('amount');
        $pdf = new \App\Services\FpdfService();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Budget vs Actual Report', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(4);
        $pdf->Cell(50, 10, 'Budgeted Amount:', 0, 0);
        $pdf->Cell(0, 10, 'Rs. ' . number_format($budgetAmount, 2), 0, 1);
        $pdf->Cell(50, 10, 'Actual Expenses:', 0, 0);
        $pdf->Cell(0, 10, 'Rs. ' . number_format($actual, 2), 0, 1);
        $diff = $budgetAmount - $actual;
        $pdf->Cell(50, 10, 'Difference:', 0, 0);
        $pdf->Cell(0, 10, 'Rs. ' . number_format($diff, 2), 0, 1);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 11);
        if ($budgetAmount > 0) {
            $percent = round(($actual / $budgetAmount) * 100, 1);
            $pdf->Cell(0, 8, 'Actual expenses are ' . $percent . '% of the budget.', 0, 1);
        } else {
            $pdf->Cell(0, 8, 'No budget set for this period.', 0, 1);
        }
        return response($pdf->Output('S', 'budget_vs_actual.pdf'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="budget_vs_actual.pdf"',
        ]);
    }

    // Download: Outstanding Dues Report
    public function downloadOutstandingDues(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $user = Auth::user();
        $building = $user->building;
        // Get all flats in the building
        $flats = \App\Models\Flat::where('building_id', $building->id)->get();
        // Get all successful payments for the period
        $payments = \App\Models\Payment::where('building_id', $building->id)
            ->where('status', 'success')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        // Assume each flat owes a fixed amount (from budget or config)
        $budget = \App\Models\Budget::where('building_id', $building->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();
        $duePerFlat = $budget ? $budget->amount : 0;
        $paidByFlat = $payments->groupBy('user_id');
        $pdf = new \App\Services\FpdfService();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Outstanding Dues Report', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(4);
        foreach ($flats as $flat) {
            $resident = $flat->resident;
            $userId = $resident ? $resident->id : null;
            $paid = $userId && isset($paidByFlat[$userId]) ? $paidByFlat[$userId]->sum('amount') : 0;
            $due = $duePerFlat - $paid;
            $pdf->Cell(50, 8, 'Flat:', 0, 0);
            $pdf->Cell(0, 8, $flat->flat_number, 0, 1);
            $pdf->Cell(50, 8, 'Resident:', 0, 0);
            $pdf->Cell(0, 8, $resident ? $resident->name : 'N/A', 0, 1);
            $pdf->Cell(50, 8, 'Due:', 0, 0);
            $pdf->Cell(0, 8, 'Rs. ' . number_format($due, 2), 0, 1);
            $pdf->Ln(2);
        }
        return response($pdf->Output('S', 'outstanding_dues.pdf'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="outstanding_dues.pdf"',
        ]);
    }

    // Download: Vendor Payments Report
    public function downloadVendorPayments(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $user = Auth::user();
        // Get all approved expenses with vendor for the selected period
        $expenses = \App\Models\Expense::where('created_by', $user->id)
            ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->where('status', 'approved')
            ->whereNotNull('vendor')
            ->get();
        $pdf = new \App\Services\FpdfService();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Vendor Payments Report', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(4);
        $vendors = $expenses->groupBy('vendor');
        foreach ($vendors as $vendor => $items) {
            $pdf->SetFont('Arial', 'B', 13);
            $pdf->Cell(0, 8, $vendor, 0, 1);
            $pdf->SetFont('Arial', '', 12);
            $vendorTotal = 0;
            foreach ($items as $expense) {
                $pdf->Cell(50, 8, 'Title:', 0, 0);
                $pdf->Cell(0, 8, $expense->title, 0, 1);
                $pdf->Cell(50, 8, 'Amount:', 0, 0);
                $pdf->Cell(0, 8, 'Rs. ' . number_format($expense->amount, 2), 0, 1);
                $pdf->Cell(50, 8, 'Date:', 0, 0);
                $pdf->Cell(0, 8, \Illuminate\Support\Carbon::parse($expense->expense_date)->format('M d, Y'), 0, 1);
                $pdf->Ln(2);
                $vendorTotal += $expense->amount;
            }
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(50, 8, 'Vendor Total:', 0, 0);
            $pdf->Cell(0, 8, 'Rs. ' . number_format($vendorTotal, 2), 0, 1);
            $pdf->Ln(4);
        }
        return response($pdf->Output('S', 'vendor_payments.pdf'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="vendor_payments.pdf"',
        ]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $building = $user->building;
        $buildingName = $building->name;
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);
        $selectedPeriod = date('F Y', mktime(0,0,0,$month,1,$year));

        // Filtered period
        $monthStart = now()->copy()->setYear($year)->setMonth($month)->startOfMonth();
        $monthEnd = now()->copy()->setYear($year)->setMonth($month)->endOfMonth();
        $expensesTotal = Expense::where('created_by', $user->id)
            ->whereBetween('expense_date', [$monthStart, $monthEnd])
            ->where('status', 'approved')
            ->sum('amount');
        // Change calculation (previous month)
        $prevMonth = $month - 1;
        $prevYear = $year;
        if ($prevMonth < 1) {
            $prevMonth = 12;
            $prevYear--;
        }
        $prevMonthStart = now()->setMonth($prevMonth)->setYear($prevYear)->startOfMonth();
        $prevMonthEnd = now()->setMonth($prevMonth)->setYear($prevYear)->endOfMonth();
        $prevExpensesTotal = Expense::where('created_by', $user->id)
            ->whereBetween('expense_date', [$prevMonthStart, $prevMonthEnd])
            ->where('status', 'approved')
            ->sum('amount');
        $expensesChange = $prevExpensesTotal > 0 ?
            round((($expensesTotal - $prevExpensesTotal) / $prevExpensesTotal) * 100, 1) . '%' : '+0%';

        $openComplaints = Complaint::where('building_id', $building->id)
            ->where('status', 'Open')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();
        $prevOpenComplaints = Complaint::where('building_id', $building->id)
            ->where('status', 'Open')
            ->whereBetween('created_at', [$prevMonthStart, $prevMonthEnd])
            ->count();
        $complaintsChange = $prevOpenComplaints > 0 ?
            round((($openComplaints - $prevOpenComplaints) / $prevOpenComplaints) * 100, 1) . '%' : '0%';

        $stats = [
            'expenses' => '₹' . number_format($expensesTotal, 0),
            'expenses_change' => $expensesChange,
            'open_complaints' => $openComplaints,
            'complaints_change' => $complaintsChange,
        ];

        // Financial Reports (dynamic with file size)
        $financialReports = [];
        // Monthly Expense Sheet
        $monthlyExpenses = Expense::where('created_by', $user->id)
            ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->where('status', 'approved')
            ->get();
        if ($monthlyExpenses->count() > 0) {
            $firstDate = optional($monthlyExpenses->sortBy('expense_date')->first())->expense_date;
            $dateRange = '';
            if ($firstDate) {
                $dateRange = \Illuminate\Support\Carbon::parse($firstDate)->format('F Y');
            }
            $monthlyUrl = route('building-admin.reports.download.monthly-expenses', ['month' => $month, 'year' => $year]);
            $monthlySize = $this->getReportFileSize('monthly-expenses', $month, $year, $user->id);
            $financialReports[] = (object)[
                'title' => 'Monthly Expense Sheet',
                'type' => 'PDF',
                'size' => $monthlySize,
                'date_range' => $dateRange,
                'download_url' => $monthlyUrl,
            ];
        }
        // Maintenance Collections (stub: add real data check when implemented)
        // $maintenanceCollections = ...
        // if ($maintenanceCollections->count() > 0) { ... }
        // Category-wise Expense Report (stub)
        // $categoryWise = ...
        // if ($categoryWise->count() > 0) { ... }
        // Budget vs Actual Report (stub)
        // $budgetVsActual = ...
        // if ($budgetVsActual->count() > 0) { ... }
        // Outstanding Dues Report (stub)
        // $outstandingDues = ...
        // if ($outstandingDues->count() > 0) { ... }
        // Vendor Payments Report (stub)
        // $vendorPayments = ...
        // if ($vendorPayments->count() > 0) { ... }

        // Dynamic Operational Reports
        $complaintsCount = \App\Models\Complaint::where('building_id', $building->id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();
        $operationalReports = [
            (object)[
                'title' => 'Complaints Summary',
                'type' => 'PDF',
                'icon' => 'report_problem',
                'icon_bg' => 'bg-orange-100 dark:bg-orange-900/30',
                'icon_color' => 'text-orange-600 dark:text-orange-400',
                'icon_border' => 'border-orange-100 dark:border-orange-800',
                'action' => 'download',
                'download_url' => route('building-admin.reports.download.complaints-summary', ['month' => $month, 'year' => $year]),
                'count' => $complaintsCount,
            ],
            (object)[
                'title' => 'Staff Attendance Log',
                'type' => 'Live View',
                'icon' => 'badge',
                'icon_bg' => 'bg-purple-50 dark:bg-purple-900/20',
                'icon_color' => 'text-purple-600',
                'icon_border' => 'border-purple-100 dark:border-purple-800',
                'action' => 'view',
                'view_url' => '#',
            ],
            (object)[
                'title' => 'Amenity Usage Report',
                'type' => 'PDF',
                'icon' => 'pool',
                'icon_bg' => 'bg-teal-50 dark:bg-teal-900/20',
                'icon_color' => 'text-teal-600',
                'icon_border' => 'border-teal-100 dark:border-teal-800',
                'action' => 'download',
                'download_url' => route('building-admin.reports.download.amenity-usage', ['month' => $month, 'year' => $year]),
            ],
        ];

        return view('building-admin.reports', compact('buildingName', 'stats', 'selectedPeriod', 'financialReports', 'operationalReports'));
    }

    // Show all available financial reports, grouped by month/year
    public function allFinancialReports(Request $request)
    {
        $user = Auth::user();
        $reports = [];
        // Get all months/years with approved expenses
        $allMonths = Expense::where('created_by', $user->id)
            ->where('status', 'approved')
            ->orderBy('expense_date')
            ->get()
            ->groupBy(function($exp) {
                return \Illuminate\Support\Carbon::parse($exp->expense_date)->format('Y-m');
            });
        foreach ($allMonths as $ym => $expenses) {
            $first = $expenses->first();
            $month = (int) \Illuminate\Support\Carbon::parse($first->expense_date)->format('m');
            $year = (int) \Illuminate\Support\Carbon::parse($first->expense_date)->format('Y');
            $dateLabel = \Illuminate\Support\Carbon::parse($first->expense_date)->format('F Y');
            $reports[] = [
                'title' => 'Monthly Expense Sheet - ' . $dateLabel,
                'count' => $expenses->count(),
                'size' => $this->getReportFileSize('monthly-expenses', $month, $year, $user->id),
                'date_range' => $dateLabel,
                'download_url' => route('building-admin.reports.download.monthly-expenses', ['month' => $month, 'year' => $year]),
            ];
        }
        return view('building-admin.all-financial-reports', compact('reports'));
    }

    /**
     * Get the file size of a generated report (in human readable format)
     * This will generate the report in memory and return its size.
     */
    private function getReportFileSize($type, $month, $year, $userId)
    {
        if ($type === 'monthly-expenses-all') {
            $expenses = Expense::where('created_by', $userId)
                ->where('status', 'approved')
                ->get();
            $pdf = new \App\Services\FpdfService();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Monthly Expenses Sheet (All History)', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 12);
            $pdf->Ln(4);
            foreach ($expenses as $expense) {
                $pdf->Cell(50, 8, 'Title:', 0, 0);
                $pdf->Cell(0, 8, $expense->title, 0, 1);
                $pdf->Cell(50, 8, 'Amount:', 0, 0);
                $pdf->Cell(0, 8, 'Rs. ' . number_format($expense->amount, 2), 0, 1);
                $pdf->Cell(50, 8, 'Date:', 0, 0);
                $pdf->Cell(0, 8, \Illuminate\Support\Carbon::parse($expense->expense_date)->format('M d, Y'), 0, 1);
                $pdf->Ln(2);
            }
            $raw = $pdf->Output('S');
            $bytes = strlen($raw);
            return $this->humanFileSize($bytes);
        }
        // Only implement for Monthly Expense Sheet for now
        if ($type === 'monthly-expenses') {
            $expenses = Expense::where('created_by', $userId)
                ->whereMonth('expense_date', $month)
                ->whereYear('expense_date', $year)
                ->where('status', 'approved')
                ->get();
            $pdf = new \App\Services\FpdfService();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Monthly Expenses Sheet', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 12);
            $pdf->Ln(4);
            foreach ($expenses as $expense) {
                $pdf->Cell(50, 8, 'Title:', 0, 0);
                $pdf->Cell(0, 8, $expense->title, 0, 1);
                $pdf->Cell(50, 8, 'Amount:', 0, 0);
                $pdf->Cell(0, 8, 'Rs. ' . number_format($expense->amount, 2), 0, 1);
                $pdf->Cell(50, 8, 'Date:', 0, 0);
                $pdf->Cell(0, 8, \Illuminate\Support\Carbon::parse($expense->expense_date)->format('M d, Y'), 0, 1);
                $pdf->Ln(2);
            }
            $raw = $pdf->Output('S');
            $bytes = strlen($raw);
            return $this->humanFileSize($bytes);
        }
        // For other reports, return '-'
        return '-';
    }

    /**
     * Convert bytes to human readable file size
     */
    private function humanFileSize($bytes, $decimals = 1)
    {
        if ($bytes < 1024) return $bytes . ' B';
        $size = array('B','KB','MB','GB','TB','PB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . $size[$factor];
    }
}

