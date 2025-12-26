<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Show analytics dashboard data (JSON for charts)
     */
    public function dashboard(Request $request)
    {
        // Example: cache for 10 minutes
        $data = Cache::remember('dashboard.analytics', 600, function () {
            return [
                'payments' => DB::table('payments')
                    ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get(),
                'complaints' => DB::table('complaints')
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get(),
                // Add more queries as needed
            ];
        });
        return response()->json($data);
    }
}
