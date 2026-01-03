<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = request()->user();
        
        // Get notifications for the user
        $notifications = Notification::where('notifiable_id', $user->id)
                                    ->latest()
                                    ->paginate(10);
        
        return view('manager.notifications.index', compact('notifications'));
    }
}
