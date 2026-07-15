<?php

namespace App\Models;

use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model
{
    use HasFactory, Slugable;

    protected $table = 'product_attributes';

    protected $fillable = ['name', 'slug', 'type', 'values', 'order_level', 'status'];

    protected $casts = [
        'values' => 'array',
        'status' => 'boolean',
        'order_level' => 'integer',
    ];

    public function scopeActive($query): void {
        $query->where('status', true);
    }

    public function scopeOrdered($query): void {
        $query->orderBy('order_level', 'asc')->orderBy('name', 'asc');
    }
}