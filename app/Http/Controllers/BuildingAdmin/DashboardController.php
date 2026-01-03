<?php
namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function recentActivities(Request $request)
    {
        $user = Auth::user();
        $building = $user->building;
        
        // Get filter and search parameters
        $filter = $request->get('filter', 'all');
        $search = $request->get('search', '');
        
        // Build query for SecurityLog
        $query = \App\Models\SecurityLog::where('building_id', $building->id)
            ->with('user')
            ->latest();
        
        // Apply filter based on action type
        switch ($filter) {
            case 'expenses':
                $query->where('action', 'like', '%expense%');
                break;
            case 'complaints':
                $query->where('action', 'like', '%complaint%');
                break;
            case 'documents':
                $query->where('action', 'like', '%document%');
                break;
            case 'notices':
                $query->where('action', 'like', '%notice%');
                break;
        }
        
        // Apply search if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('action', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Fetch last 20 activities from SecurityLog for this building
        $recentLogs = $query->take(20)->get();
        
        $recentActivity = [];
        foreach ($recentLogs as $log) {
            // Determine icon based on action type
            $icon = 'history';
            $iconBg = 'bg-blue-50 dark:bg-blue-900/20';
            $iconText = 'text-blue-600 dark:text-blue-400';
            
            if (str_contains(strtolower($log->action), 'expense')) {
                $icon = 'payments';
                $iconBg = 'bg-green-50 dark:bg-green-900/20';
                $iconText = 'text-green-600 dark:text-green-400';
            } elseif (str_contains(strtolower($log->action), 'complaint')) {
                $icon = 'report';
                $iconBg = 'bg-red-50 dark:bg-red-900/20';
                $iconText = 'text-red-600 dark:text-red-400';
            } elseif (str_contains(strtolower($log->action), 'document')) {
                $icon = 'folder';
                $iconBg = 'bg-purple-50 dark:bg-purple-900/20';
                $iconText = 'text-purple-600 dark:text-purple-400';
            } elseif (str_contains(strtolower($log->action), 'notice')) {
                $icon = 'campaign';
                $iconBg = 'bg-orange-50 dark:bg-orange-900/20';
                $iconText = 'text-orange-600 dark:text-orange-400';
            }
            
            $recentActivity[] = [
                'icon' => $icon,
                'iconBg' => $iconBg,
                'iconText' => $iconText,
                'title' => $log->action,
                'time' => $log->created_at->diffForHumans(),
                'desc' => $log->description ?? 'By ' . ($log->user->name ?? 'System'),
            ];
        }
        return view('building-admin.recent-activities', [
            'recentActivity' => $recentActivity,
        ]);
    }
    public function index()
    {
        $user = Auth::user();
        $building = $user->building;
        $adminProfilePic = null; // Add logic if you have profile pic field
        $buildingName = $building->name ?? 'Building';
        // Check if notifications table exists before querying
        try {
            $unreadNotifications = Schema::hasTable('notifications') ? $user->unreadNotifications()->count() > 0 : false;
        } catch (\Exception $e) {
            $unreadNotifications = false;
        }

            // Subscription
            $activeSubscription = $building->activeSubscription()->first();
            if (!$activeSubscription) {
                // No active subscription: show payment required dashboard
                return view('building-admin.dashboard-payment-required');
            }
            $subscriptionTier = $activeSubscription ? ($activeSubscription->plan->name ?? 'Active') : 'No Active Plan';
            $subscriptionExpiresIn = $activeSubscription ? $activeSubscription->end_date->diffForHumans() : 'Expired';

        // Metrics
        $totalFlats = $building->flats()->count();
        $totalResidents = \App\Models\Resident::whereIn('flat_id', $building->flats()->pluck('id'))->count();
        $openComplaints = \App\Models\Complaint::where('building_id', $building->id)->where('status', 'Open')->count();
        $highPriorityComplaints = \App\Models\Complaint::where('building_id', $building->id)
            ->where('priority', 'High')
            ->whereIn('status', ['Open', 'In Progress'])
            ->count();

        // Expenses (current month)
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();
        $monthlyExpenses = \App\Models\Expense::whereBetween('expense_date', [$monthStart, $monthEnd])
            ->whereIn('created_by', $building->flats()->pluck('id'))
            ->sum('amount');
        $monthlyExpenses = '$' . number_format($monthlyExpenses, 2);
        $expensesChange = '';

        // Recent Activity (last 3)
            // Recent Activity (last 12) from SecurityLog
            $recentLogs = \App\Models\SecurityLog::where('building_id', $building->id)
                ->with('user')
                ->latest()->take(12)->get();
        $recentActivity = [];
        foreach ($recentLogs as $log) {
            // Determine icon based on action type
            $icon = 'history';
            $iconBg = 'bg-blue-50 dark:bg-blue-900/20';
            $iconText = 'text-blue-600 dark:text-blue-400';
            
            if (str_contains(strtolower($log->action), 'expense')) {
                $icon = 'payments';
                $iconBg = 'bg-green-50 dark:bg-green-900/20';
                $iconText = 'text-green-600 dark:text-green-400';
            } elseif (str_contains(strtolower($log->action), 'complaint')) {
                $icon = 'report';
                $iconBg = 'bg-red-50 dark:bg-red-900/20';
                $iconText = 'text-red-600 dark:text-red-400';
            } elseif (str_contains(strtolower($log->action), 'document')) {
                $icon = 'folder';
                $iconBg = 'bg-purple-50 dark:bg-purple-900/20';
                $iconText = 'text-purple-600 dark:text-purple-400';
            } elseif (str_contains(strtolower($log->action), 'notice')) {
                $icon = 'campaign';
                $iconBg = 'bg-orange-50 dark:bg-orange-900/20';
                $iconText = 'text-orange-600 dark:text-orange-400';
            }
            
            $recentActivity[] = [
                'icon' => $icon,
                'iconBg' => $iconBg,
                'iconText' => $iconText,
                'title' => $log->action,
                'time' => $log->created_at->diffForHumans(),
                'desc' => $log->description ?? 'By ' . ($log->user->name ?? 'System'),
            ];
        }

        return view('building-admin.dashboard', [
            'adminProfilePic' => $adminProfilePic,
            'buildingName' => $buildingName,
            'unreadNotifications' => $unreadNotifications,
            'subscriptionTier' => $subscriptionTier,
            'subscriptionExpiresIn' => $subscriptionExpiresIn,
            'totalFlats' => $totalFlats,
            'totalResidents' => $totalResidents,
            'openComplaints' => $openComplaints,
            'highPriorityComplaints' => $highPriorityComplaints,
            'monthlyExpenses' => $monthlyExpenses,
            'expensesChange' => $expensesChange,
            'recentActivity' => $recentActivity,
        ]);
    }
}
