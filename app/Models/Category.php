<?php

namespace App\Models;

use App\Traits\Slugable;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Slugable, HasImages;

    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'excerpt',
        'description',
        'image',
        'font_icon',
        'order_level',
        'display_on',
        'meta_keywords',
        'meta_description',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status'      => 'boolean',
        'order_level' => 'integer',
    ];

    /**
     * Get the parent category.
     */
    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children(){
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order_level');
    }

    /**
     * Get the admin who created this category.
     */
    public function creator(){
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Get the admin who last updated this category.
     */
    public function updater(){
        return $this->belongsTo(Admin::class, 'updated_by');
    }


     // Relationship with Packages
    public function packages() {
        return $this->belongsToMany(Package::class, 'package_categories');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query): void
    {
        $query->where('status', true);
    }

    /**
     * Scope a query to order by display order and name.
     */
    public function scopeOrdered($query): void
    {
        $query->orderBy('order_level', 'asc')
              ->orderBy('name', 'asc');
    }
}