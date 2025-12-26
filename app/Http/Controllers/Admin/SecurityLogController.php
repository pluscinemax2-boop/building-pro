<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecurityLog;

class SecurityLogController extends Controller
{
    public function index()
    {
        $logs = SecurityLog::latest()->get();
        return view('admin.security.index', compact('logs'));
    }
}
