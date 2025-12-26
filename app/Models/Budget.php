<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'year',
        'amount',
        'building_id',
    ];

    // Get the building for this budget (if needed)
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
