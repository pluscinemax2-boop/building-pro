<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Building;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        // Notifications (same as dashboard)
        $notifications = collect();
        $latestPayments = Payment::latest('created_at')->limit(5)->get();
        foreach ($latestPayments as $payment) {
            $notifications->push([
                'icon' => $payment->status === 'success' ? 'payments' : 'report',
                'title' => $payment->status === 'success' ? 'Payment Success' : 'Payment Failed',
                'desc' => 'Txn #' . $payment->id . ' - ' . ($payment->building->name ?? 'Unknown'),
                'time' => $payment->created_at->diffForHumans(),
            ]);
        }
        $latestBuildings = Building::latest('created_at')->limit(3)->get();
        foreach ($latestBuildings as $building) {
            $notifications->push([
                'icon' => 'person_add',
                'title' => 'New Society Onboarded',
                'desc' => $building->name . ' joined',
                'time' => $building->created_at->diffForHumans(),
            ]);
        }
        $notifications = $notifications->sortByDesc('time')->take(5);
    {
        // Date range setup
        $range = $request->input('range', 'month');
        $now = Carbon::now();
        $start = null;
        $end = $now->copy();

        if ($range === 'month') {
            $start = $now->copy()->startOfMonth();
        } elseif ($range === '30days') {
            $start = $now->copy()->subDays(30);
        } elseif ($range === 'custom' && $request->has(['from', 'to'])) {
            $start = Carbon::parse($request->input('from'));
            $end = Carbon::parse($request->input('to'));
        } else {
            $start = $now->copy()->startOfMonth();
        }

        // Churn Rate (dynamic)
        // Churn = (Lost societies in period) / (Total at start of period)
        $startOfPeriod = $start->copy()->startOfDay();
        $endOfPeriod = $end->copy()->endOfDay();
        $totalAtStart = Building::where('created_at', '<', $startOfPeriod)->count();
        // Lost = societies that were active before period, but have no active subscription (status=active, end_date >= end) at end of period
        $lostSocieties = Building::where('created_at', '<', $startOfPeriod)
            ->whereDoesntHave('subscriptions', function($q) use ($endOfPeriod) {
                $q->where('status', 'active')
                  ->where(function($sq) use ($endOfPeriod) {
                      $sq->whereNull('end_date')->orWhere('end_date', '>=', $endOfPeriod);
                  });
            })->count();
        $churnRate = $totalAtStart > 0 ? round(($lostSocieties / $totalAtStart) * 100, 2) : null;

        // Revenue
        $totalRevenue = Payment::where('status', 'success')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');
        $prevRevenue = Payment::where('status', 'success')
            ->whereBetween('created_at', [$start->copy()->subMonth(), $start->copy()->subDay()])
            ->sum('amount');
        $revenueGrowth = $prevRevenue > 0 ? round((($totalRevenue - $prevRevenue) / $prevRevenue) * 100, 1) : null;

        // Revenue trend data for chart
        $revenueLabels = [];
        $revenueData = [];
        $period = null;
        if ($range === 'month' || $range === '30days') {
            // Group by day
            $period = new \DatePeriod($start, new \DateInterval('P1D'), $end->copy()->addDay());
            foreach ($period as $date) {
                $label = $date->format('d M');
                $revenueLabels[] = $label;
                $sum = Payment::where('status', 'success')
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->sum('amount');
                $revenueData[] = (float)$sum;
            }
        } elseif ($range === 'custom' && $start->diffInDays($end) > 60) {
            // If custom range is long, group by month
            $period = new \DatePeriod($start->copy()->startOfMonth(), new \DateInterval('P1M'), $end->copy()->addMonth()->startOfMonth());
            foreach ($period as $date) {
                $label = $date->format('M Y');
                $revenueLabels[] = $label;
                $sum = Payment::where('status', 'success')
                    ->whereYear('created_at', $date->format('Y'))
                    ->whereMonth('created_at', $date->format('m'))
                    ->sum('amount');
                $revenueData[] = (float)$sum;
            }
        } else {
            // Default: group by day
            $period = new \DatePeriod($start, new \DateInterval('P1D'), $end->copy()->addDay());
            foreach ($period as $date) {
                $label = $date->format('d M');
                $revenueLabels[] = $label;
                $sum = Payment::where('status', 'success')
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->sum('amount');
                $revenueData[] = (float)$sum;
            }
        }

        // Users
        $totalUsers = User::whereBetween('created_at', [$start, $end])->count();
        $prevUsers = User::whereBetween('created_at', [$start->copy()->subMonth(), $start->copy()->subDay()])->count();
        $userGrowth = $prevUsers > 0 ? round((($totalUsers - $prevUsers) / $prevUsers) * 100, 1) : null;

        // Buildings
        $totalBuildings = Building::whereBetween('created_at', [$start, $end])->count();
        $prevBuildings = Building::whereBetween('created_at', [$start->copy()->subMonth(), $start->copy()->subDay()])->count();
        $buildingGrowth = $prevBuildings > 0 ? round((($totalBuildings - $prevBuildings) / $prevBuildings) * 100, 1) : null;
        // New buildings in selected period
        $newBuildings = Building::whereBetween('created_at', [$start, $end])->count();

        // New Buildings bar chart data
        $buildingLabels = [];
        $buildingData = [];
        $buildingLabelsMonth = [];
        $buildingDataMonth = [];
        // Week-wise (default)
        $period = [];
        $current = $start->copy()->startOfWeek();
        $endWeek = $end->copy()->endOfWeek();
        while ($current <= $endWeek) {
            $period[] = $current->copy();
            $current->addWeek();
        }
        foreach ($period as $weekStart) {
            $weekEnd = $weekStart->copy()->endOfWeek();
            $label = 'W' . $weekStart->format('W');
            $buildingLabels[] = $label;
            $count = Building::whereBetween('created_at', [$weekStart, $weekEnd])->count();
            $buildingData[] = $count;
        }
        // Month-wise (always for toggle)
        $periodMonth = new \DatePeriod($start->copy()->startOfYear(), new \DateInterval('P1M'), $end->copy()->addMonth()->startOfYear());
        foreach ($periodMonth as $date) {
            $label = $date->format('M Y');
            $buildingLabelsMonth[] = $label;
            $count = Building::whereYear('created_at', $date->format('Y'))
                ->whereMonth('created_at', $date->format('m'))
                ->count();
            $buildingDataMonth[] = $count;
        }

        // Active Subscriptions
        $activeSubscriptions = Subscription::where('status', 'active')
            ->whereBetween('created_at', [$start, $end])
            ->count();
        $prevActiveSubscriptions = Subscription::where('status', 'active')
            ->whereBetween('created_at', [$start->copy()->subMonth(), $start->copy()->subDay()])
            ->count();
        $subscriptionGrowth = $prevActiveSubscriptions > 0 ? round((($activeSubscriptions - $prevActiveSubscriptions) / $prevActiveSubscriptions) * 100, 1) : null;

        // Recent Activity: last 5 payments, buildings, or subscriptions
        $recentActivities = collect();
        $recentPayments = Payment::latest('created_at')->limit(5)->get();
        foreach ($recentPayments as $payment) {
            $recentActivities->push([
                'type' => $payment->status === 'success' ? 'payment-success' : 'payment-failed',
                'title' => $payment->status === 'success' ? 'Payment Success' : 'Payment Failed',
                'desc' => 'Txn #' . $payment->id . ' - ' . ($payment->building->name ?? 'Unknown'),
                'time' => $payment->created_at,
            ]);
        }
        $recentBuildings = Building::latest('created_at')->limit(3)->get();
        foreach ($recentBuildings as $building) {
            $recentActivities->push([
                'type' => 'new-building',
                'title' => 'New Society Onboarded',
                'desc' => $building->name . ' joined',
                'time' => $building->created_at,
            ]);
        }
        $recentActivities = $recentActivities->sortByDesc('time')->take(5);

        return view('admin.reports', compact(
            'totalRevenue', 'revenueGrowth',
            'totalUsers', 'userGrowth',
            'totalBuildings', 'buildingGrowth',
            'activeSubscriptions', 'subscriptionGrowth',
            'range', 'start', 'end',
            'revenueLabels', 'revenueData',
            'buildingLabels', 'buildingData',
            'buildingLabelsMonth', 'buildingDataMonth',
            'churnRate', 'newBuildings',
            'recentActivities', 'notifications'
        ));
    }
}
}