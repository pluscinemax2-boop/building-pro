<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'flat_id',
        'reading_date',
        'reading_value',
        'unit',
        'type',
    ];

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }
}
