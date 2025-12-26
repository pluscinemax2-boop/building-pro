<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // ✅ LOGIN REQUIRED
        if (!Auth::check()) {
            return redirect('/login');
        }

        // ✅ ROLE REQUIRED (role_id based)
        // 1 = Super Admin, 2 = Building Admin, 3 = Manager, 4 = Resident
        $roleMap = [
            'Super Admin' => 1,
            'Building Admin' => 2,
            'Manager' => 3,
            'Resident' => 4,
        ];
        if (!Auth::user()->role_id || !isset($roleMap[$role]) || Auth::user()->role_id !== $roleMap[$role]) {
            abort(403, 'Access Denied');
        }

        return $next($request);
    }
}
