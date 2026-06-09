<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasImages;

class Banner extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        'title',
        'subtitle', 
        'image',
        'description',
        'order_level',
        'status',
    ];

    protected $casts = [
        'status'      => 'boolean',
        'order_level' => 'integer',
    ];

    // Query scope to filter only enabled/active banners
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Query scope to sort by display order ascending, then newest first
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_level', 'asc')
                    ->orderBy('created_at', 'desc');
    }

    // Query scope to search banners by matching title or subtitle
    public function scopeSearch($query, string $term)
    {
        return $query->where('title', 'like', "%{$term}%")
                    ->orWhere('subtitle', 'like', "%{$term}%");
    }
}