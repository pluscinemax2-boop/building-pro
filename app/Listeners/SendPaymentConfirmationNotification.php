<?php

namespace App\Listeners;

use App\Events\PaymentCompleted;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPaymentConfirmationNotification implements ShouldQueue
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
    public function handle(PaymentCompleted $event): void
    {
        // Send payment confirmation email
        NotificationService::sendPaymentConfirmation($event->payment);

        // Log the notification sent
        \Log::info('Payment confirmation notification sent', [
            'payment_id' => $event->payment->id,
            'building_id' => $event->payment->building_id,
        ]);
    }
}
