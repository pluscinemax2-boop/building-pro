<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'building_id',
        'plan_id',
        'start_date',
        'end_date',
        'status', // active, expired, cancelled
        'price_per_unit',
        'units',
        'total_amount',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price_per_unit' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    // Subscription belongs to Building
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    // Subscription belongs to Plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Helper: Check if subscription is currently active
    public function isActive()
    {
        return $this->status === 'active' && $this->end_date > now();
    }
}
