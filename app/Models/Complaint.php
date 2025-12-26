<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'flat_id',
        'resident_id',
        'title',
        'description',
        'status',
        'priority',
        'image',
    ];

    public function building()
    {
        return $this->belongsTo(\App\Models\Building::class);
    }

    public function flat()
    {
        return $this->belongsTo(\App\Models\Flat::class);
    }

    public function resident()
    {
        return $this->belongsTo(\App\Models\Resident::class);
    }
}
