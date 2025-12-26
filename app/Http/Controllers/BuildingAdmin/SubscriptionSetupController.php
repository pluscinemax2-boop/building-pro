<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SubscriptionSetupController extends Controller
{
    /**
     * Show subscription setup page with available plans
     */
    public function showSetup()
    {
        $user = Auth::user();
        $building = Building::where('building_admin_id', $user->id)->firstOrFail();


        // If ?renew=1, redirect to checkout for current plan
        if (request()->has('renew') && $building->activeSubscription && $building->activeSubscription->status === 'active') {
            $plan = $building->activeSubscription->plan;
            if ($plan) {
                return redirect()->route('building-admin.subscription.checkout', [
                    'plan_id' => $plan->id,
                    'building_id' => $building->id,
                ]);
            }
        }

        // Only redirect to dashboard if not upgrading and already has active subscription
        if (!request()->has('upgrade') && $building->activeSubscription && $building->activeSubscription->status === 'active') {
            return redirect('/building-admin/dashboard')->with('success', 'You already have an active subscription.');
        }

        // Get all active plans
        $plans = Plan::where('is_active', true)->get();

        return view('building-admin.subscription-setup', compact('building', 'plans'));
    }

    /**
     * Activate a plan - redirect to payment checkout
     */
    public function activatePlan(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $user = Auth::user();
        $building = Building::where('building_admin_id', $user->id)->firstOrFail();

        $plan = Plan::findOrFail($request->plan_id);

        // Redirect to payment checkout page
        return redirect()->route('building-admin.subscription.checkout', [
            'plan_id' => $plan->id,
            'building_id' => $building->id,
        ]);
    }
}
