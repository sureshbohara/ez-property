<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'location',
        'status',
        'order_level'
    ];

    protected $casts = [
        'status' => 'boolean',
        'order_level' => 'integer'
    ];

    public const LOCATIONS = [
        'header' => 'Header Menu',
        'footer' => 'Footer Menu',
        'sidebar' => 'Sidebar Menu',
    ];

    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('order', 'asc');
    }

    public function topLevelItems()
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('order', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', $location);
    }
}