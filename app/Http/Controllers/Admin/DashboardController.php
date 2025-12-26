<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\User;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Search logic
        $search = $request->input('search');

        // Stats
        $totalBuildings = Building::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $totalUsers = User::count();
        $expiredSubscriptions = Subscription::where('status', 'expired')->count();

        // Revenue history for last 8 months (for graph)
        $revenueHistory = [];
        for ($i = 7; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenueHistory[] = [
                'label' => $month->format('M'),
                'value' => Payment::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('amount'),
            ];
        }
        $monthlyRevenue = $revenueHistory[7]['value'];
        $prevMonthRevenue = $revenueHistory[6]['value'];
        $revenueChange = $prevMonthRevenue > 0 ? round((($monthlyRevenue - $prevMonthRevenue) / $prevMonthRevenue) * 100) : 0;

        // Recent activity (last 5 complaints, buildings, users)
        $recentActivities = collect([]);
        $recentActivities = $recentActivities->merge(
            Complaint::latest()->take(2)->get()->map(function($c) {
                return [
                    'type' => 'complaint',
                    'title' => $c->title ?? 'Complaint',
                    'desc' => $c->status,
                    'time' => $c->created_at->diffForHumans(),
                ];
            })
        );
        $recentActivities = $recentActivities->merge(
            Building::latest()->take(2)->get()->map(function($b) {
                return [
                    'type' => 'building',
                    'title' => $b->name,
                    'desc' => 'New property registration',
                    'time' => $b->created_at->diffForHumans(),
                ];
            })
        );
        $recentActivities = $recentActivities->merge(
            User::latest()->take(1)->get()->map(function($u) {
                return [
                    'type' => 'user',
                    'title' => 'New Admin: ' . $u->name,
                    'desc' => 'System access granted',
                    'time' => $u->created_at->diffForHumans(),
                ];
            })
        );
        $recentActivities = $recentActivities->sortByDesc('time')->take(5);

        // Notifications (dynamic)
        $notifications = collect([]);
        $notifications = $notifications->merge(
            Complaint::latest()->take(2)->get()->map(function($c) {
                return [
                    'icon' => 'report',
                    'title' => 'New Complaint Submitted',
                    'desc' => $c->title ?? 'Complaint',
                    'time' => $c->created_at->diffForHumans(),
                ];
            })
        );
        $notifications = $notifications->merge(
            Payment::latest()->take(2)->get()->map(function($p) {
                return [
                    'icon' => 'payments',
                    'title' => 'Payment Received',
                    'desc' => '₹' . number_format($p->amount, 0) . ' from ' . ($p->building->name ?? 'Unknown'),
                    'time' => $p->created_at->diffForHumans(),
                ];
            })
        );
        $notifications = $notifications->merge(
            User::latest()->take(1)->get()->map(function($u) {
                return [
                    'icon' => 'person_add',
                    'title' => 'New User Registered',
                    'desc' => $u->name . ' joined as ' . ($u->role->name ?? 'User'),
                    'time' => $u->created_at->diffForHumans(),
                ];
            })
        );
        $notifications = $notifications->sortByDesc('time')->take(5);

        // Search filter (optional, for demo)
        if ($search) {
            $recentActivities = $recentActivities->filter(function($item) use ($search) {
                return str_contains(strtolower($item['title']), strtolower($search))
                    || str_contains(strtolower($item['desc']), strtolower($search));
            });
        }

        return view('admin.dashboard', [
            'totalBuildings' => $totalBuildings,
            'activeSubscriptions' => $activeSubscriptions,
            'totalUsers' => $totalUsers,
            'expiredSubscriptions' => $expiredSubscriptions,
            'monthlyRevenue' => $monthlyRevenue,
            'revenueChange' => $revenueChange,
            'revenueHistory' => $revenueHistory,
            'recentActivities' => $recentActivities,
            'notifications' => $notifications,
            'search' => $search,
        ]);
    }
}
