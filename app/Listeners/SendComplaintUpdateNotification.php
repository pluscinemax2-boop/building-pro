<?php

namespace App\Listeners;

use App\Events\ComplaintUpdated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendComplaintUpdateNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ComplaintUpdated $event): void
    {
        // Send complaint update email
        NotificationService::sendComplaintUpdate($event->complaint, $event->updateType);

        // Log the notification sent
        \Log::info('Complaint update notification sent', [
            'complaint_id' => $event->complaint->id,
            'update_type' => $event->updateType,
        ]);
    }
}
