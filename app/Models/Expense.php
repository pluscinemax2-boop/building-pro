<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public function file()
    {
        return $this->morphOne(\App\Models\File::class, 'fileable');
    }
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'category_id',
        'expense_date',
        'description',
        'vendor',
        'bill_url',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
