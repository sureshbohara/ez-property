<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBundle extends Model
{
    protected $table = 'product_bundles';

    protected $fillable = ['parent_product_id', 'child_product_id', 'quantity', 'sort_order'];

    public function parent() {
        return $this->belongsTo(Product::class, 'parent_product_id');
    }

    public function child() {
        return $this->belongsTo(Product::class, 'child_product_id');
    }
}