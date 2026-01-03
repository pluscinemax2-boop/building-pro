<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Get the authenticated manager user
        $user = request()->user();
        
        return view('manager.profile.index', compact('user'));
    }
}
