<?php

namespace App\Http\Controllers;

use App\Models\NotificationPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationPreferenceController extends Controller
{
    /**
     * Show the notification preferences page
     */
    public function show()
    {
        $user = Auth::user();
        $preferences = $user->getNotificationPreferences();

        return view('settings.notification-preferences', compact('preferences'));
    }

    /**
     * Update notification preferences
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $preferences = $user->getNotificationPreferences();

        $validated = $request->validate([
            'email_notifications_enabled' => 'boolean',
            'email_payment_confirmations' => 'boolean',
            'email_subscription_updates' => 'boolean',
            'email_complaint_updates' => 'boolean',
            'email_maintenance_updates' => 'boolean',
            'email_announcements' => 'boolean',
            'email_emergency_alerts' => 'boolean',
            'email_forum_replies' => 'boolean',
            'digest_weekly' => 'boolean',
            'digest_monthly' => 'boolean',
        ]);

        // Update user's global email notification setting
        if (isset($validated['email_notifications_enabled'])) {
            $user->update(['email_notifications_enabled' => $validated['email_notifications_enabled']]);
        }

        // Update preferences
        $preferences->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Notification preferences updated successfully',
            'preferences' => $preferences,
        ]);
    }

    /**
     * Enable all notifications
     */
    public function enableAll()
    {
        $user = Auth::user();
        $user->update(['email_notifications_enabled' => true]);
        $preferences = $user->getNotificationPreferences();
        $preferences->enableAllNotifications();

        return response()->json([
            'success' => true,
            'message' => 'All notifications enabled',
        ]);
    }

    /**
     * Disable all notifications
     */
    public function disableAll()
    {
        $user = Auth::user();
        $user->update(['email_notifications_enabled' => false]);
        $preferences = $user->getNotificationPreferences();
        $preferences->disableAllNotifications();

        return response()->json([
            'success' => true,
            'message' => 'All notifications disabled',
        ]);
    }

    /**
     * Toggle a specific notification type
     */
    public function toggle(Request $request, string $type)
    {
        $user = Auth::user();
        $preferences = $user->getNotificationPreferences();

        $enabled = $request->boolean('enabled', true);
        $preferences->updatePreference($type, $enabled);

        return response()->json([
            'success' => true,
            'message' => "Notification '" . str_replace('_', ' ', $type) . "' " . ($enabled ? 'enabled' : 'disabled'),
        ]);
    }
}
