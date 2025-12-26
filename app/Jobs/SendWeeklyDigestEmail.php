<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\NotificationPreference;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWeeklyDigestEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue('default');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all users with weekly digest enabled
        $users = User::whereHas('notificationPreferences', function ($query) {
            $query->where('digest_weekly', true);
        })->get();

        foreach ($users as $user) {
            try {
                // Collect all activity for the week
                $weeklyData = $this->collectWeeklyActivity($user);

                if (empty($weeklyData)) {
                    continue;
                }

                // Send the digest email
                Mail::view('emails.weekly-digest', $weeklyData)->send(function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Weekly Digest - Building Manager Pro');
                });

                // Update last digest sent timestamp
                $user->notificationPreferences->update([
                    'last_digest_sent_at' => now(),
                ]);

                \Log::info('Weekly digest sent to user', ['user_id' => $user->id]);
            } catch (\Exception $e) {
                \Log::error('Failed to send weekly digest', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Collect all activity for the past week
     */
    private function collectWeeklyActivity($user): array
    {
        $weekAgo = now()->subWeek();

        $data = [
            'user' => $user,
            'period' => $weekAgo->format('M d') . ' - ' . now()->format('M d, Y'),
            'payments' => [],
            'complaints' => [],
            'maintenance' => [],
            'announcements' => [],
            'hasActivity' => false,
        ];

        // Add payment data if enabled
        if ($user->canReceiveNotification('payment_confirmations')) {
            $data['payments'] = \App\Models\Payment::where('building_id', $user->building?->id)
                ->where('created_at', '>=', $weekAgo)
                ->get();
            if ($data['payments']->count() > 0) {
                $data['hasActivity'] = true;
            }
        }

        return $data['hasActivity'] ? $data : [];
    }
}
