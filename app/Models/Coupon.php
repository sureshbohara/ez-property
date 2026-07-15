<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'code', 'description', 'discount_type', 'discount_value',
        'min_order_amount', 'max_discount',
        'usage_limit', 'used_count', 'usage_limit_per_user',
        'start_date', 'end_date', 'status',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'usage_limit_per_user' => 'integer',
    ];

    public function getIsActiveAttribute() {
        if (!$this->status) return false;
        $now = now();
        if ($this->start_date && $now->lt($this->start_date)) return false;
        if ($this->end_date && $now->gt($this->end_date)) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
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