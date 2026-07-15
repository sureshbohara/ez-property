<?php

namespace App\Models;

use App\Traits\Slugable;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, Slugable, HasImages;

    protected $table = 'brands';

    protected $fillable = [
        'name', 'slug', 'logo', 'description', 'website',
        'order_level', 'status', 'meta_title', 'meta_keywords', 'meta_description',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order_level' => 'integer',
    ];


    public function getLogoUrlAttribute(): string
    {
        return $this->resolveImage($this->logo);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query): void {
        $query->where('status', true);
    }

    public function scopeOrdered($query): void {
        $query->orderBy('order_level', 'asc')->orderBy('name', 'asc');
    }
}