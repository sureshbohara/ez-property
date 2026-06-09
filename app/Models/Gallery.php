<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasImages;

class Gallery extends Model
{
    use HasFactory, SoftDeletes, HasImages;

    protected $fillable = [
        'name',
        'display_on',
        'image',
        'alt',
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