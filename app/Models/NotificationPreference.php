<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    protected $fillable = [
        'user_id',
        'email_payment_confirmations',
        'email_subscription_updates',
        'email_complaint_updates',
        'email_maintenance_updates',
        'email_announcements',
        'email_emergency_alerts',
        'email_forum_replies',
        'digest_weekly',
        'digest_monthly',
        'last_digest_sent_at',
    ];

    protected $casts = [
        'email_payment_confirmations' => 'boolean',
        'email_subscription_updates' => 'boolean',
        'email_complaint_updates' => 'boolean',
        'email_maintenance_updates' => 'boolean',
        'email_announcements' => 'boolean',
        'email_emergency_alerts' => 'boolean',
        'email_forum_replies' => 'boolean',
        'digest_weekly' => 'boolean',
        'digest_monthly' => 'boolean',
        'last_digest_sent_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification preference
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if email notifications are enabled for a specific type
     */
    public function isNotificationEnabled(string $type): bool
    {
        $attribute = 'email_' . $type;
        return $this->getAttribute($attribute) ?? true;
    }

    /**
     * Update notification preference
     */
    public function updatePreference(string $type, bool $enabled): self
    {
        $attribute = 'email_' . $type;
        $this->update([$attribute => $enabled]);
        return $this;
    }

    /**
     * Enable all notifications
     */
    public function enableAllNotifications(): self
    {
        return $this->update([
            'email_payment_confirmations' => true,
            'email_subscription_updates' => true,
            'email_complaint_updates' => true,
            'email_maintenance_updates' => true,
            'email_announcements' => true,
            'email_emergency_alerts' => true,
            'email_forum_replies' => true,
        ]);
    }

    /**
     * Disable all notifications
     */
    public function disableAllNotifications(): self
    {
        return $this->update([
            'email_payment_confirmations' => false,
            'email_subscription_updates' => false,
            'email_complaint_updates' => false,
            'email_maintenance_updates' => false,
            'email_announcements' => false,
            'email_emergency_alerts' => false,
            'email_forum_replies' => false,
        ]);
    }
}
