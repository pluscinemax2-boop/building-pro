<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureBuildingHasActiveSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (! $user) return redirect('/login');

        // allow super admins always (role name 'Admin' is super admin)
        if ($user->role && $user->role->name === 'Admin') {
            return $next($request);
        }

        // if building admin: check building or subscription
        $building = \App\Models\Building::where('building_admin_id', $user->id)->first();

        // if manager/resident, find their building via relations (implement accordingly)
        if (!$building && $user->role->name === 'Manager') {
            $building = $user->manager_of_building ?? null; // if you have relation
        }

        if (!$building) {
            // no building linked yet, allow only the subscription/setup route
            if ($request->is('admin/subscription/*') || $request->is('admin/subscription')) {
                return $next($request);
            }
            return redirect('/admin/subscription/setup')->withErrors('Please setup your building subscription first.');
        }

        // if building has active subscription allow; else redirect to setup
        if ($building->activeSubscription && $building->activeSubscription->status === 'active') {
            return $next($request);
        }

        // allow only subscription routes
        if ($request->is('admin/subscription/*') || $request->is('admin/subscription')) {
            return $next($request);
        }

        return redirect('/admin/subscription/setup')->withErrors('Your building subscription is not active. Please select a plan.');
    }
}
