<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id', 'sku', 'price', 'sale_price', 'stock_quantity', 'attributes', 'image', 'status'
    ];

    protected $casts = [
        'attributes' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'status' => 'boolean',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getFinalPriceAttribute() {
        if ($this->sale_price && $this->sale_price < $this->price) {
            return $this->sale_price;
        }
        return $this->price;
    }

    public function scopeActive($query): void {
        $query->where('status', true);
    }
}