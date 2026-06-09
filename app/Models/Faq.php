<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_on',
        'question',
        'answer',
        'order_level',
        'status',
    ];

    protected $casts = [
        'order_level' => 'integer',
        'status'      => 'boolean',
    ];

 
    public function scopeActive($query): void
    {
        $query->where('status', true);
    }


    public function scopeOrdered($query): void
    {
        $query->orderBy('order_level', 'asc')
              ->orderBy('created_at', 'desc');
    }
}