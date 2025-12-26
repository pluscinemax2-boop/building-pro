<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ✅ SHOW LOGIN FORM
    public function showLogin()
    {
        return view('auth.login');
    }

    // ✅ HANDLE LOGIN (FINAL SAFE VERSION)
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], true)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // ✅ Ensure notification preferences exist
            $user->getNotificationPreferences();

            // ✅ FINAL ROLE BASED REDIRECT (role_id based)
            // 1 = Super Admin, 2 = Building Admin, 3 = Manager, 4 = Resident
            if ($user->role_id == 1) {
                return redirect('/admin/dashboard');
            }
            if ($user->role_id == 2) {
                $building = \App\Models\Building::where('building_admin_id', $user->id)->first();
                if ($building && $building->activeSubscription && $building->activeSubscription->status === 'active') {
                    return redirect('/building-admin/dashboard');
                } else {
                    return redirect('/building-admin/subscription');
                }
            }
            if ($user->role_id == 3) {
                return redirect('/manager');
            }
            if ($user->role_id == 4) {
                return redirect('/resident/emergency');
            }
            return redirect('/login')->withErrors(['email' => 'Invalid role']);

        }

        return back()->withErrors([
            'email' => 'Invalid login credentials',
        ]);
    }

    // ✅ LOGOUT METHOD (MISSING ERROR FIX)
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/login');
    }
}
