<?php

namespace App\Listeners;

use App\Events\SubscriptionActivated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSubscriptionActivationNotification implements ShouldQueue
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
    public function handle(SubscriptionActivated $event): void
    {
        // Send subscription activation email
        NotificationService::sendSubscriptionActivation($event->subscription);

        // Log the notification sent
        \Log::info('Subscription activation notification sent', [
            'subscription_id' => $event->subscription->id,
            'building_id' => $event->subscription->building_id,
        ]);
    }
}
