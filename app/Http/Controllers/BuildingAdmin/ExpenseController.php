<?php
namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Budget;
use Illuminate\Http\Request;


use Illuminate\Support\Carbon;



class ExpenseController extends Controller
{
    // Show edit form for budget (sets showEdit session)
    public function editBudget(Request $request)
    {
        session(['showEdit' => true]);
        return redirect()->route('building-admin.expenses.index', [
            'month' => $request->month ?? now()->month,
            'year' => $request->year ?? now()->year,
        ]);
    }
    public function pdf($id)
    {
        $expense = Expense::with('category', 'file')->findOrFail($id);
        $pdf = new \App\Services\FpdfService();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Expense Details', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(4);
        $pdf->Cell(50, 8, 'Title:', 0, 0);
        $pdf->Cell(0, 8, $expense->title, 0, 1);
        $pdf->Cell(50, 8, 'Category:', 0, 0);
        $pdf->Cell(0, 8, $expense->category->name ?? '-', 0, 1);
        $pdf->Cell(50, 8, 'Vendor:', 0, 0);
        $pdf->Cell(0, 8, $expense->vendor ?? '-', 0, 1);
        $pdf->Cell(50, 8, 'Amount:', 0, 0);
        $pdf->Cell(0, 8, '₹' . number_format($expense->amount, 2), 0, 1);
        $pdf->Cell(50, 8, 'Expense Date:', 0, 0);
        $pdf->Cell(0, 8, \Illuminate\Support\Carbon::parse($expense->expense_date)->format('M d, Y'), 0, 1);
        $pdf->Cell(50, 8, 'Description:', 0, 0);
        $pdf->MultiCell(0, 8, $expense->description ?? '-');
        $pdf->Cell(50, 8, 'Status:', 0, 0);
        $pdf->Cell(0, 8, 'Approved', 0, 1);
        $pdf->Cell(50, 8, 'Approved At:', 0, 0);
        $pdf->Cell(0, 8, $expense->approved_at ? \Illuminate\Support\Carbon::parse($expense->approved_at)->format('M d, Y h:i A') : '-', 0, 1);
        if ($expense->file && \Str::startsWith($expense->file->file_type, 'image/')) {
            $imagePath = public_path('storage/' . $expense->file->file_path);
            if (file_exists($imagePath)) {
                $pdf->Ln(4);
                $pdf->Cell(50, 8, 'Bill Image:', 0, 1);
                $pdf->Image($imagePath, null, null, 60, 60, '', '', true, 300);
            }
        }
        return response($pdf->Output('S', 'expense_'.$expense->id.'.pdf'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="expense_'.$expense->id.'.pdf"',
        ]);
    }
    public function show($id)
    {
        $expense = Expense::with('category')->findOrFail($id);
        return view('building-admin.expenses.show', compact('expense'));
    }
    public function exportCsv(Request $request)
    {
        $query = Expense::with(['category', 'file'])->where('status', 'approved');
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('expense_date', [$request->from, $request->to]);
        }
        $expenses = $query->orderByDesc('expense_date')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="approved_expenses.csv"',
        ];

        $callback = function() use ($expenses) {
            $file = fopen('php://output', 'w');
            // Header row
            fputcsv($file, ['ID', 'Title', 'Amount', 'Category', 'Vendor', 'Expense Date', 'Description', 'Approved At', 'Bill Image/File URL']);
            foreach ($expenses as $expense) {
                $billUrl = null;
                if ($expense->file) {
                    $billUrl = asset('storage/' . $expense->file->file_path);
                } elseif (!empty($expense->bill_url)) {
                    $billUrl = $expense->bill_url;
                }
                fputcsv($file, [
                    $expense->id,
                    $expense->title,
                    $expense->amount,
                    $expense->category->name ?? '',
                    $expense->vendor ?? '',
                    $expense->expense_date,
                    $expense->description,
                    $expense->approved_at,
                    $billUrl,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function pending()
    {
        $expenses = \App\Models\Expense::with('category')
            ->where('status', 'pending')
            ->orderByDesc('expense_date')
            ->paginate(20);
        return view('building-admin.expenses.pending', compact('expenses'));
    }
    public function history()
    {
        $expenses = \App\Models\Expense::with('category')
            ->where('status', 'approved')
            ->orderByDesc('expense_date')
            ->paginate(20);
        return view('building-admin.expenses.history', compact('expenses'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'category_id' => 'required',
            'expense_date' => 'required|date',
            'bill' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $expense = Expense::findOrFail($id);
        $expense->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'expense_date' => $request->expense_date,
            'description' => $request->description,
            'vendor' => $request->vendor,
        ]);

        if ($request->hasFile('bill')) {
            // Delete old file if exists
            if ($expense->file) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($expense->file->file_path);
                $expense->file()->delete();
            }
            $file = $request->file('bill');
            $path = $file->store('expenses/bills', 'public');
            $expense->file()->create([
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'original_name' => $file->getClientOriginalName(),
            ]);
        }

        return redirect()->route('building-admin.expenses.index')->with('success', 'Expense updated successfully.');
    }
    public function edit($id)
    {
        $expense = \App\Models\Expense::findOrFail($id);
        $categories = \App\Models\ExpenseCategory::all();
        return view('building-admin.expenses.edit', compact('expense', 'categories'));
    }

    public function index(Request $request)
    {
        $expenses = Expense::with(['category', 'creator', 'approver'])->orderByDesc('expense_date')->get();
        $allPendingExpenses = $expenses->where('status', 'pending')->sortByDesc('expense_date');
        $pendingExpenses = $allPendingExpenses->take(5);
        $historyExpenses = $expenses->whereIn('status', ['approved', 'rejected']);
        $pendingAmount = $allPendingExpenses->sum('amount');
        $pendingCount = $allPendingExpenses->count();
        $historyExpenses = $historyExpenses->take(10);

        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
            $buildingId = \Illuminate\Support\Facades\Auth::user()->building_id ?? null;
        $budget = Budget::where('month', $month)->where('year', $year)->where('building_id', $buildingId)->first();
        $totalBudget = $budget ? $budget->amount : 0;
        $budgetUsed = $expenses->where('status', 'approved')->where(function($expense) use ($month, $year) {
            return 
                \Carbon\Carbon::parse($expense->expense_date)->month == $month &&
                \Carbon\Carbon::parse($expense->expense_date)->year == $year;
        })->sum('amount');
        $budgetUsedPercent = $totalBudget > 0 ? round(($budgetUsed / $totalBudget) * 100) . '%' : '0%';

        $stats = [
            'pending_amount' => '₹' . number_format($pendingAmount, 2),
            'pending_count' => $pendingCount . ' Requests',
            'budget_used' => $budgetUsedPercent,
            'budget_amount' => $totalBudget,
            'budget_id' => $budget ? $budget->id : null,
        ];

        return view('building-admin.expenses.index', compact('stats', 'pendingExpenses', 'historyExpenses', 'budget', 'month', 'year'));
    }

    public function saveBudget(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
            'budget_amount' => 'required|numeric|min:0',
        ]);
        $buildingId = \Illuminate\Support\Facades\Auth::user()->building_id ?? null;
        $budget = Budget::updateOrCreate(
            [
                'month' => $request->month,
                'year' => $request->year,
                'building_id' => $buildingId,
            ],
            [
                'amount' => $request->budget_amount,
            ]
        );
        session()->forget('showEdit');
        return redirect()->route('building-admin.expenses.index', ['month' => $request->month, 'year' => $request->year])
            ->with('success', 'Monthly budget saved successfully.');
    }


    public function reject(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->status = 'rejected';
        $expense->approved_by = \Illuminate\Support\Facades\Auth::id();
        $expense->approved_at = now();
        $expense->save();
        return redirect()->route('building-admin.expenses.index')->with('success', 'Expense rejected.');
    }

    public function filter($status)
    {
        $expenses = Expense::with(['category', 'creator', 'approver'])
            ->where('status', $status)
            ->orderByDesc('expense_date')
            ->get();

        $pendingExpenses = $expenses->where('status', 'pending');
        $historyExpenses = $expenses->whereIn('status', ['approved', 'rejected']);
        $pendingAmount = $pendingExpenses->sum('amount');
        $pendingCount = $pendingExpenses->count();
        $totalBudget = 100000;
        $budgetUsed = $expenses->sum('amount');
        $budgetUsedPercent = $totalBudget > 0 ? round(($budgetUsed / $totalBudget) * 100) . '%' : '0%';

        $stats = [
            'pending_amount' => '₹' . number_format($pendingAmount, 2),
            'pending_count' => $pendingCount . ' Requests',
            'budget_used' => $budgetUsedPercent,
        ];

        return view('building-admin.expenses.index', compact('stats', 'pendingExpenses', 'historyExpenses'));
    }

    public function create()
    {
        $categories = ExpenseCategory::all();
        return view('building-admin.expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'category_id' => 'required',
            'expense_date' => 'required|date',
            'bill' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $expense = Expense::create([
            'vendor' => $request->vendor,
            'title' => $request->title,
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'expense_date' => $request->expense_date,
            'description' => $request->description,
            'status' => 'pending',
            'created_by' => \Illuminate\Support\Facades\Auth::id(),
        ]);

        if ($request->hasFile('bill')) {
            $file = $request->file('bill');
            $path = $file->store('expenses/bills', 'public');
            $expense->file()->create([
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'original_name' => $file->getClientOriginalName(),
            ]);
        }

        return redirect()->route('building-admin.expenses.index')->with('success', 'Expense submitted for approval.');
    }

    public function approve(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->status = $request->status ?? 'approved';
        $expense->approved_by = \Illuminate\Support\Facades\Auth::id();
        $expense->approved_at = now();
        $expense->save();
        return redirect()->route('building-admin.expenses.index')->with('success', 'Expense status updated.');
    }
}
