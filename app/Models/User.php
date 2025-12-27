<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar_url',
        'password',
        'role_id',
        'status',
        'email_notifications_enabled',
        'building_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'email_notifications_enabled' => 'boolean',
        ];
    }

    public function building()
    {
        return $this->hasOne(\App\Models\Building::class, 'building_admin_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user's notification preferences
     */
    public function notificationPreferences()
    {
        return $this->hasOne(NotificationPreference::class);
    }

    /**
     * Get or create notification preferences
     */
    public function getNotificationPreferences()
    {
        return $this->notificationPreferences()->firstOrCreate([
            'user_id' => $this->id,
        ]);
    }

    /**
     * Check if user can receive a specific notification
     */
    public function canReceiveNotification(string $type): bool
    {
        if (!$this->email_notifications_enabled) {
            return false;
        }

        $prefs = $this->getNotificationPreferences();
        return $prefs->isNotificationEnabled($type);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'Admin';
    }

}
