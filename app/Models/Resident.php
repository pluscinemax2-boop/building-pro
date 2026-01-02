<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'flat_id',
    ];

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    
    public function complaints()
    {
        return $this->hasMany(\App\Models\Complaint::class);
    }

}
