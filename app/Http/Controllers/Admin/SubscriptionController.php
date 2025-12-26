<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    // show plan selection for current building admin's building
    public function showSetup(Request $request)
    {
        $user = Auth::user();

        // find building for this admin
        $building = \App\Models\Building::where('building_admin_id', $user->id)->first();

        if (! $building) {
            return redirect('/')->withErrors('No building found for your account.');
        }

        // if building already has active subscription, redirect to dashboard
        if ($building->activeSubscription) {
            return redirect('/admin/buildings')->with('success','You already have an active plan.');
        }

        $plans = Plan::where('is_active', true)->get();

        return view('admin.subscription.setup', compact('plans','building'));
    }
}

