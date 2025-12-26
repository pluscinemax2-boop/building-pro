<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMonthlyDigestEmail implements ShouldQueue
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
        // Get all users with monthly digest enabled
        $users = User::whereHas('notificationPreferences', function ($query) {
            $query->where('digest_monthly', true);
        })->get();

        foreach ($users as $user) {
            try {
                // Collect all activity for the month
                $monthlyData = $this->collectMonthlyActivity($user);

                if (empty($monthlyData)) {
                    continue;
                }

                // Send the digest email
                Mail::view('emails.monthly-digest', $monthlyData)->send(function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Monthly Summary - Building Manager Pro');
                });

                // Update last digest sent timestamp
                $user->notificationPreferences->update([
                    'last_digest_sent_at' => now(),
                ]);

                \Log::info('Monthly digest sent to user', ['user_id' => $user->id]);
            } catch (\Exception $e) {
                \Log::error('Failed to send monthly digest', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Collect all activity for the past month
     */
    private function collectMonthlyActivity($user): array
    {
        $monthAgo = now()->subMonth();

        $data = [
            'user' => $user,
            'period' => $monthAgo->format('M') . ' ' . $monthAgo->year,
            'totalActivity' => 0,
            'summary' => [
                'payments' => 0,
                'complaints' => 0,
                'maintenance' => 0,
                'announcements' => 0,
            ],
            'hasActivity' => false,
        ];

        // Count activities if enabled
        if ($user->canReceiveNotification('payment_confirmations')) {
            $count = \App\Models\Payment::where('building_id', $user->building?->id)
                ->where('created_at', '>=', $monthAgo)
                ->count();
            $data['summary']['payments'] = $count;
            $data['totalActivity'] += $count;
        }

        if ($data['totalActivity'] > 0) {
            $data['hasActivity'] = true;
        }

        return $data['hasActivity'] ? $data : [];
    }
}
