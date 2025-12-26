<?php

use App\Models\SecurityLog;
use Illuminate\Support\Facades\Auth;

function logActivity($action)
{
    try {
        SecurityLog::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role->name ?? null,
            'action' => $action,
            'ip_address' => request()->ip(),
            'url' => request()->fullUrl(),
        ]);
    } catch (\Exception $e) {
        // Fail silently (kabhi error aaye to app na ruthe)
    }
}
