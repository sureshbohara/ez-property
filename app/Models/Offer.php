<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';

    protected $fillable = [
        'name', 'description', 'offer_type',
        'buy_quantity', 'get_quantity', 'discount_value',
        'apply_on', 'product_ids', 'category_ids',
        'min_order_amount', 'max_uses', 'used_count', 'max_uses_per_user',
        'start_date', 'end_date',
        'status', 'priority',
    ];

    protected $casts = [
        'product_ids' => 'array',
        'category_ids' => 'array',
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
        'priority' => 'integer',
        'buy_quantity' => 'integer',
        'get_quantity' => 'integer',
        'used_count' => 'integer',
        'max_uses' => 'integer',
        'max_uses_per_user' => 'integer',
    ];

    public function getIsActiveAttribute() {
        if (!$this->status) return false;
        $now = now();
        if ($this->start_date && $now->lt($this->start_date)) return false;
        if ($this->end_date && $now->gt($this->end_date)) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        return true;
    }

    public function scopeActive($query): void {
        $query->where('status', true)
              ->where(function($q) {
                  $q->whereNull('start_date')->orWhere('start_date', '<=', now());
              })
              ->where(function($q) {
                  $q->whereNull('end_date')->orWhere('end_date', '>=', now());
              });
    }
}