<?php

namespace App\Models;

use App\Traits\Slugable;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Listing extends Model {
    use HasFactory, Slugable, HasImages;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'description', 'address', 'city', 'province', 'country',
        'latitude', 'longitude', 'image', 'gallery', 'highlight_key',
        'guests', 'bedrooms', 'beds', 'bathrooms','display_on',
        'listing_type', 'base_price', 'cleaning_fee', 'service_fee', 'minimum_nights', 'cancellation_policy',
        'instant_bookable', 'status', 'views', 'order_level', 'meta_title', 'meta_description'
    ];

    protected $casts = [
        'gallery' => 'array',
        'highlight_key' => 'array',
        'latitude' => 'decimal:7', 
        'longitude' => 'decimal:7',
        'base_price' => 'decimal:2', 
        'cleaning_fee' => 'decimal:2', 
        'service_fee' => 'decimal:2',
        'instant_bookable' => 'boolean', 
        'status' => 'boolean',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function amenities() { return $this->belongsToMany(Amenity::class, 'amenity_listing'); }
    public function availabilities() { return $this->hasMany(Availability::class); }
    public function pricingRules() { return $this->hasMany(PricingRule::class); }

    public function scopeActive($query) { return $query->where('status', true); }
    public function scopeOrdered($query) { return $query->orderBy('order_level', 'asc')->orderBy('created_at', 'desc'); }

    public function getImageUrlAttribute(): string {
        return $this->resolveImage($this->image);
    }
}