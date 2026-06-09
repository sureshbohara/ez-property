<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasImages;

class Review extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        'name',
        'email',
        'address',
        'rating',
        'review',
        'content',
        'image',
        'display_on',
        'order_level',
        'status',
    ];

    protected $casts = [
        'rating'      => 'integer',
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