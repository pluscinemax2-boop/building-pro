<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    // Handle subscription renewal from dashboard
    public function renew(Request $request)
    {
        $user = Auth::user();
        $building = $user->building;
        $activeSubscription = $building->activeSubscription()->first();
        if (!$activeSubscription) {
            return redirect()->route('building-admin.dashboard')->with('error', 'No active subscription to renew.');
        }

        // Extend subscription by 1 month (example logic)
        $activeSubscription->end_date = $activeSubscription->end_date->addMonth();
        $activeSubscription->save();

        // Auto-generate invoice for renewal
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad($activeSubscription->id, 4, '0', STR_PAD_LEFT);
        $amount = $activeSubscription->plan ? $activeSubscription->plan->price : 0;
        $issueDate = now();
        $dueDate = $issueDate->copy()->addDays(7); // 7 days to pay
        \App\Models\Invoice::create([
            'subscription_id' => $activeSubscription->id,
            'building_id' => $building->id,
            'user_id' => $user->id,
            'invoice_number' => $invoiceNumber,
            'amount' => $amount,
            'issue_date' => $issueDate,
            'due_date' => $dueDate,
            'status' => 'pending',
            'meta' => null,
        ]);

        return redirect()->route('building-admin.dashboard')->with('success', 'Subscription renewed successfully! Invoice generated.');
    }
    // Show available subscription plans
    public function showPlans()
    {
        $user = Auth::user();
        $building = $user->building;
        $activeSubscription = $building->activeSubscription()->with('plan')->first();
        $plan = $activeSubscription ? $activeSubscription->plan : null;

        // Prepare plan details for the view
        $planData = null;
        if ($activeSubscription && $plan) {
            $now = now();
            $start = $activeSubscription->start_date;
            $end = $activeSubscription->end_date;
            $expired = $end && $end->isPast();
            $totalDays = ($start && $end) ? $start->diffInDays($end) : 0;
            $usedDays = ($start && $end) ? $start->diffInDays(min($now, $end)) : 0;
            $usagePercent = ($totalDays > 0) ? round(($usedDays / $totalDays) * 100) : 0;
            if ($usagePercent > 100) $usagePercent = 100;

            // Integer days remaining (force int, no decimals)
            $daysRemaining = $end ? ($expired ? 0 : (int) floor($now->floatDiffInDays($end))) : 0;

            $planData = [
                'name' => $plan->name,
                'price' => $plan->price,
                'billing_cycle' => $plan->billing_cycle,
                'max_flats' => $plan->max_flats,
                'features' => $plan->features,
                'status' => $expired ? 'Expired' : ucfirst($activeSubscription->status),
                'start_date' => $start ? $start->format('d M Y') : '-',
                'expiry_date' => $end ? $end->format('d M Y') : '-',
                'days_remaining' => $end ? ($expired ? 'Expired' : ($daysRemaining . ' Days Remaining')) : '-',
                'renew_date' => $end ? $end->format('d M Y') : '-',
                'usage_percent' => $usagePercent . '%',
                'interval' => $plan->billing_cycle,
                'next_invoice' => $expired ? '-' : ('#INV-' . str_pad($activeSubscription->id, 4, '0', STR_PAD_LEFT)),
            ];
        }

        // Payment history (real data)
        $payments = \App\Models\Payment::with(['subscription.plan'])
            ->where('building_id', $building->id)
            ->latest()
            ->get();

        return view('building-admin.subscription', [
            'plan' => $planData,
            'payments' => $payments,
        ]);
    }

    // User clicks on "Select Plan"
    public function selectPlan(Request $request)
    {
        $request->validate([
            'plan_id' => 'required',
        ]);

        session(['selected_plan' => $request->plan_id]);

        return redirect('/building-admin/payment');
    }
}
