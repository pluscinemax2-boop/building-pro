<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'flat_id',
        'resident_id',
        'title',
        'description',
        'status',
        'contractor_id',
        'requested_date',
        'completed_date',
    ];

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }
}
