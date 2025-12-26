<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\NotificationPreference;
use Illuminate\Database\Seeder;

class NotificationPreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users without notification preferences
        $users = User::whereDoesntHave('notificationPreferences')->get();

        foreach ($users as $user) {
            NotificationPreference::create([
                'user_id' => $user->id,
                'email_payment_confirmations' => true,
                'email_subscription_updates' => true,
                'email_complaint_updates' => true,
                'email_maintenance_updates' => true,
                'email_announcements' => true,
                'email_emergency_alerts' => true,
                'email_forum_replies' => true,
                'digest_weekly' => false,
                'digest_monthly' => false,
            ]);
        }

        $this->command->info('Notification preferences seeded for ' . $users->count() . ' users.');
    }
}
