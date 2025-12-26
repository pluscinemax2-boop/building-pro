<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'flat_number',
        'floor',
        'type',
        'status',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
    public function resident()
    {
        return $this->hasOne(\App\Models\Resident::class);
    }
    public function complaints()
    {
        return $this->hasMany(\App\Models\Complaint::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function meterReadings()
    {
        return $this->hasMany(MeterReading::class);
    }

}
