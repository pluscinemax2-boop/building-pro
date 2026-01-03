<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_path',
        'mime_type',
        'size',
        'uploaded_by',
        'building_id',
        'access',
        'version',
        'parent_id',
    ];
    
    public function building()
    {
        return $this->belongsTo(\App\Models\Building::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function parent()
    {
        return $this->belongsTo(Document::class, 'parent_id');
    }

    public function versions()
    {
        return $this->hasMany(Document::class, 'parent_id');
    }
}
