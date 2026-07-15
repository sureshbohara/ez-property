<?php

namespace App\Models;

use App\Traits\Slugable;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory, Slugable, HasImages;

    protected $table = 'packages';

    protected $fillable = [
        'name', 'slug', 'image', 'feature_image', 'gallery', 'map', 
        'trip_previous_price', 'trip_price', 'excerpt', 'description', 'content', 
        'group_size_price', 'highlight_key', 'included_data', 'excluded_data', 
        'faqs', 'itinerary_data', 'general', 'lower_body', 'upper_body', 
        'footwear', 'accessories', 'duration', 'transportation', 'trip_grading', 
        'max_altitude', 'accommodation', 'meals', 'best_season', 'view_count', 
        'status', 'order_level', 'display_on', 'meta_title', 'meta_keywords', 'meta_description',
        'activities',
    ];

    protected $casts = [
        'gallery' => 'array', 'group_size_price' => 'array', 'highlight_key' => 'array',
        'included_data' => 'array', 'excluded_data' => 'array', 'faqs' => 'array',
        'itinerary_data' => 'array', 'general' => 'array', 'lower_body' => 'array',
        'upper_body' => 'array', 'footwear' => 'array', 'accessories' => 'array',
        'activities' => 'array',
        'status' => 'boolean', 'order_level' => 'integer', 'view_count' => 'integer',
        'trip_previous_price' => 'decimal:2', 'trip_price' => 'decimal:2',
    ];

    public function scopeActive($query): void { 
        $query->where('status', true); 
    }
    
    public function scopeOrdered($query): void {
        $query->orderBy('order_level', 'asc')->orderBy('created_at', 'desc');
    }

    // Relationship with Fixed Departures
    public function fixedDepartures() {
        return $this->hasMany(FixedDeparture::class);
    }

    // Relationship with Categories (Many-to-Many)
    public function categories() {
        return $this->belongsToMany(Category::class, 'package_categories');
    }
}