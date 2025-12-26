<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalCompliance extends Model
{
    protected $fillable = [
        'gdpr_enabled', 'notes',
    ];
}
