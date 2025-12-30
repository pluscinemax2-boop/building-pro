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

            $user = Auth::user();

            // ✅ Check if 2FA is enabled
            if ($user->two_factor_enabled) {
                // Store user ID in session temporarily for 2FA verification
                $request->session()->put('2fa_temp_user_id', $user->id);
                Auth::logout();
                
                return redirect()->route('verify-2fa')->with('email', $request->email);
            }

            $request->session()->regenerate();

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

    // ✅ SHOW 2FA VERIFICATION FORM
    public function show2FAForm()
    {
        $tempUserId = session('2fa_temp_user_id');
        
        if (!$tempUserId) {
            return redirect('/login')->with('error', 'Invalid 2FA session');
        }

        $user = \App\Models\User::find($tempUserId);
        
        return view('auth.verify-2fa', compact('user'));
    }

    // ✅ VERIFY 2FA CODE
    public function verify2FA(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        $tempUserId = session('2fa_temp_user_id');
        
        if (!$tempUserId) {
            return redirect('/login')->with('error', 'Invalid 2FA session');
        }

        $user = \App\Models\User::find($tempUserId);

        if (!$user || !$user->two_factor_enabled) {
            return redirect('/login')->with('error', 'Invalid user or 2FA not enabled');
        }

        // Use the TOTP verification from ProfileController trait or copied method
        if ($this->verifyTwoFactorCode($request->code, $user->two_factor_secret)) {
            Auth::login($user, true);
            $request->session()->forget('2fa_temp_user_id');
            $request->session()->regenerate();

            // Ensure notification preferences exist
            $user->getNotificationPreferences();

            // Role-based redirect
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
                return redirect('/resident');
            }

            return redirect('/');
        }

        return back()->withErrors(['code' => 'Invalid 2FA code. Please check and try again.']);
    }

    // ✅ TOTP VERIFICATION (copied from ProfileController)
    private function verifyTwoFactorCode($code, $secret)
    {
        $currentTime = floor(time() / 30);
        
        for ($i = -1; $i <= 1; $i++) {
            $timeWindow = $currentTime + $i;
            $expectedCode = $this->generateTOTPCode($secret, $timeWindow);
            
            if ((string)$code === (string)$expectedCode) {
                return true;
            }
        }
        
        return false;
    }

    private function generateTOTPCode($secret, $time = null)
    {
        if ($time === null) {
            $time = floor(time() / 30);
        }

        $secretBinary = $this->base32Decode($secret);
        $counter = pack('J', $time);
        $hmac = hash_hmac('sha1', $counter, $secretBinary, true);
        
        $offset = ord($hmac[19]) & 0x0f;
        $code = (
            ((ord($hmac[$offset]) & 0x7f) << 24) |
            ((ord($hmac[$offset + 1]) & 0xff) << 16) |
            ((ord($hmac[$offset + 2]) & 0xff) << 8) |
            (ord($hmac[$offset + 3]) & 0xff)
        );
        
        $otp = $code % 1000000;
        
        return str_pad($otp, 6, '0', STR_PAD_LEFT);
    }

    private function base32Decode($input)
    {
        $input = strtoupper($input);
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $output = '';
        $v = 0;
        $vbits = 0;

        for ($i = 0; $i < strlen($input); $i++) {
            $c = $input[$i];
            if ($c === '=') {
                break;
            }
            
            $pos = strpos($alphabet, $c);
            if ($pos === false) {
                continue;
            }
            
            $v = ($v << 5) | $pos;
            $vbits += 5;
            
            if ($vbits >= 8) {
                $vbits -= 8;
                $output .= chr(($v >> $vbits) & 0xff);
            }
        }

        return $output;
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
