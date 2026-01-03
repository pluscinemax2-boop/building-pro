<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'building_id',
        'role',
        'action',
        'ip_address',
        'url',
    ];
    
    public function building()
    {
        return $this->belongsTo(\App\Models\Building::class);
    }
    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
