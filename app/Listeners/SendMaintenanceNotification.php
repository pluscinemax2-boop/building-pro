<?php

namespace App\Listeners;

use App\Events\MaintenanceAssigned;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMaintenanceNotification implements ShouldQueue
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
    public function handle(MaintenanceAssigned $event): void
    {
        // Send maintenance request email
        NotificationService::sendMaintenanceRequest($event->maintenanceRequest, $event->updateType);

        // Log the notification sent
        \Log::info('Maintenance notification sent', [
            'maintenance_id' => $event->maintenanceRequest->id,
            'update_type' => $event->updateType,
        ]);
    }
}
