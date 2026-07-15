<?php

namespace App\Models;

use App\Traits\Slugable;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, Slugable, HasImages, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'brand_id', 'category_id', 'name', 'slug', 'sku', 'barcode', 'product_type',
        'regular_price', 'sale_price', 'sale_price_start', 'sale_price_end',
        'manage_stock', 'stock_quantity', 'stock_status', 'low_stock_threshold',
        'short_description', 'description', 'tags',
        'thumbnail', 'gallery',
        'downloadable_file', 'download_limit', 'download_expiry_days',
        'is_featured', 'is_virtual', 'view_count', 'order_level', 'status',
        'meta_title','meta_description','video_url','faqs'
    ];

    protected $casts = [
        'tags' => 'array',
        'gallery' => 'array',
        'regular_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'manage_stock' => 'boolean',
        'is_featured' => 'boolean',
        'is_virtual' => 'boolean',
        'status' => 'boolean',
        'stock_quantity' => 'integer',
        'order_level' => 'integer',
        'sale_price_start' => 'date',
        'sale_price_end' => 'date',
        'faqs' => 'array',
    ];

    // Relationships
    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function bundleItems() {
        return $this->hasMany(ProductBundle::class, 'parent_product_id');
    }

    // Accessors
    public function getFinalPriceAttribute() {
        if ($this->sale_price && $this->sale_price < $this->regular_price) {
            $now = now();
            if ($this->sale_price_start && $now->lt($this->sale_price_start)) return $this->regular_price;
            if ($this->sale_price_end && $now->gt($this->sale_price_end)) return $this->regular_price;
            return $this->sale_price;
        }
        return $this->regular_price;
    }

    public function getIsOnSaleAttribute() {
        if (!$this->sale_price) return false;
        $now = now();
        if ($this->sale_price_start && $now->lt($this->sale_price_start)) return false;
        if ($this->sale_price_end && $now->gt($this->sale_price_end)) return false;
        return $this->sale_price < $this->regular_price;
    }

    // Scopes
    public function scopeActive($query): void {
        $query->where('status', true);
    }

    public function scopeOrdered($query): void {
        $query->orderBy('order_level', 'asc')->orderBy('created_at', 'desc');
    }

    public function scopeOfType($query, string $type): void {
        $query->where('product_type', $type);
    }

 

    public function getThumbnailUrlAttribute(): string {
        return $this->resolveImage($this->thumbnail);
    }


    public function getPhotoUrlAttribute(): string {
        return $this->resolveImage($this->photo);
    }

}