<?php

namespace Tests\Feature;

use App\Mail\PaymentConfirmationMail;
use App\Mail\SubscriptionActivationMail;
use App\Models\User;
use App\Models\Payment;
use App\Models\Building;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    /** @test */
    public function it_can_send_payment_confirmation_email()
    {
        // Create test data
        $user = User::factory()->create();
        $building = Building::factory()->create(['building_admin_id' => $user->id]);
        
        $payment = Payment::create([
            'building_id' => $building->id,
            'amount' => 99900,
            'payment_method' => 'razorpay',
            'razorpay_payment_id' => 'pay_1234567890',
            'razorpay_order_id' => 'order_1234567890',
            'status' => 'completed',
        ]);

        // Send notification
        NotificationService::sendPaymentConfirmation($payment, $user);

        // Assert email was sent
        Mail::assertSent(PaymentConfirmationMail::class);
    }

    /** @test */
    public function it_can_send_subscription_activation_email()
    {
        // Create test data
        $user = User::factory()->create();
        $building = Building::factory()->create(['building_admin_id' => $user->id]);
        $plan = Plan::factory()->create();

        $subscription = Subscription::create([
            'building_id' => $building->id,
            'plan_id' => $plan->id,
            'status' => 'active',
            'started_at' => now(),
            'expires_at' => now()->addYear(),
        ]);

        // Send notification
        NotificationService::sendSubscriptionActivation($subscription, $user);

        // Assert email was sent
        Mail::assertSent(SubscriptionActivationMail::class);
    }

    /** @test */
    public function it_respects_user_notification_preferences()
    {
        $user = User::factory()->create();
        $user->update(['email_notifications_enabled' => false]);

        $building = Building::factory()->create(['building_admin_id' => $user->id]);
        
        $payment = Payment::create([
            'building_id' => $building->id,
            'amount' => 99900,
            'payment_method' => 'razorpay',
            'razorpay_payment_id' => 'pay_1234567890',
            'razorpay_order_id' => 'order_1234567890',
            'status' => 'completed',
        ]);

        // Try to send notification
        $sent = NotificationService::sendPaymentConfirmation($payment, $user);

        // Should still attempt to send but user has disabled globally
        // Service returns false when user has disabled notifications
        $this->assertFalse($sent);
    }

    /** @test */
    public function user_can_manage_notification_preferences()
    {
        $user = User::factory()->create();
        $prefs = $user->getNotificationPreferences();

        // Check default preferences
        $this->assertTrue($prefs->email_payment_confirmations);
        $this->assertTrue($prefs->email_subscription_updates);

        // Disable specific notification
        $prefs->updatePreference('payment_confirmations', false);

        // Verify change
        $this->assertFalse($prefs->fresh()->email_payment_confirmations);
        $this->assertTrue($prefs->fresh()->email_subscription_updates);
    }

    /** @test */
    public function user_can_enable_all_notifications()
    {
        $user = User::factory()->create();
        $prefs = $user->getNotificationPreferences();

        // Disable all
        $prefs->disableAllNotifications();
        $this->assertFalse($prefs->fresh()->email_payment_confirmations);

        // Enable all
        $prefs->enableAllNotifications();
        $this->assertTrue($prefs->fresh()->email_payment_confirmations);
        $this->assertTrue($prefs->fresh()->email_subscription_updates);
    }

    /** @test */
    public function it_can_check_if_notification_is_enabled()
    {
        $user = User::factory()->create();
        $prefs = $user->getNotificationPreferences();

        $this->assertTrue($prefs->isNotificationEnabled('payment_confirmations'));

        $prefs->updatePreference('payment_confirmations', false);
        $this->assertFalse($prefs->fresh()->isNotificationEnabled('payment_confirmations'));
    }
}
