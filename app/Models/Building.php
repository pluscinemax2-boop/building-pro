<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'name',
        'address',
        'total_floors',
        'total_flats',
        'building_admin_id',
        'status',
        'image_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Building belongs to Building Admin (User)
    public function admin()
    {
        return $this->belongsTo(User::class, 'building_admin_id');
    }

    // Building has many flats
    public function flats()
    {
        return $this->hasMany(Flat::class);
    }

    // Building has many subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Get active subscription for the building
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->latest();
    }

    // Helper: Check if building has active subscription
    public function hasActiveSubscription()
    {
        return $this->activeSubscription() !== null;
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
