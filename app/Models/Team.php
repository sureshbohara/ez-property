<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasImages;

class Team extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        'name',
        'email',
        'address',
        'bio',
        'image',
        'facebook',
        'youtube',
        'tiktok',
        'instagram',
        'order_level',
        'status',
    ];

    protected $casts = [
        'status'      => 'boolean',
        'order_level' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_level', 'asc')
                    ->orderBy('created_at', 'desc');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
    }
}