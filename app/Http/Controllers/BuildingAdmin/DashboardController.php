<?php
namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function recentActivities()
    {
        $user = \Auth::user();
        $building = $user->building;
        // Fetch last 20 complaints for this building (expand to more types as needed)
        $recentComplaints = \App\Models\Complaint::where('building_id', $building->id)
            ->latest()->take(20)->get();
        $recentActivity = [];
        foreach ($recentComplaints as $complaint) {
            $recentActivity[] = [
                'icon' => 'plumbing',
                'iconBg' => 'bg-red-50 dark:bg-red-900/20',
                'iconText' => 'text-red-600 dark:text-red-400',
                'title' => $complaint->title,
                'time' => $complaint->created_at->diffForHumans(),
                'desc' => 'Flat ' . ($complaint->flat->flat_number ?? '-') . ' • ' . ($complaint->resident->name ?? 'Resident'),
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
            // Recent Activity (last 12)
            $recentComplaints = \App\Models\Complaint::where('building_id', $building->id)
                ->latest()->take(12)->get();
        $recentActivity = [];
        foreach ($recentComplaints as $complaint) {
            $recentActivity[] = [
                'icon' => 'plumbing',
                'iconBg' => 'bg-red-50 dark:bg-red-900/20',
                'iconText' => 'text-red-600 dark:text-red-400',
                'title' => $complaint->title,
                'time' => $complaint->created_at->diffForHumans(),
                'desc' => 'Flat ' . ($complaint->flat->flat_number ?? '-') . ' • ' . ($complaint->resident->name ?? 'Resident'),
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
