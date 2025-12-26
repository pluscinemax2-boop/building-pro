<?php

namespace App\Providers;

use App\Events\PaymentCompleted;
use App\Events\SubscriptionActivated;
use App\Events\ComplaintUpdated;
use App\Events\MaintenanceAssigned;
use App\Listeners\SendPaymentConfirmationNotification;
use App\Listeners\SendSubscriptionActivationNotification;
use App\Listeners\SendComplaintUpdateNotification;
use App\Listeners\SendMaintenanceNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PaymentCompleted::class => [
            SendPaymentConfirmationNotification::class,
        ],
        SubscriptionActivated::class => [
            SendSubscriptionActivationNotification::class,
        ],
        ComplaintUpdated::class => [
            SendComplaintUpdateNotification::class,
        ],
        MaintenanceAssigned::class => [
            SendMaintenanceNotification::class,
        ],
    ];

    /**
     * Discover events and listeners in the application.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
