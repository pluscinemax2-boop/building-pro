<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalPolicy extends Model
{
    protected $fillable = [
        'type', 'title', 'content', 'status',
    ];
}
