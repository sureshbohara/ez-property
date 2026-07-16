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

 
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order_level');
    }


    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }


    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function packages() 
    {
        return $this->belongsToMany(Package::class, 'package_categories');
    }


    public function scopeActive($query): void
    {
        $query->where('status', true);
    }


    public function scopeOrdered($query): void
    {
        $query->orderBy('order_level', 'asc')
              ->orderBy('name', 'asc');
    }

    /**
     * Get all descendant category IDs efficiently in a single query.
     * Replaces the old recursive method to prevent N+1 query issues.
     */
    public function getAllDescendantIds(): array
    {
        $categories = Category::select('id', 'parent_id')->get();
        
        $ids = [];
        $queue = [$this->id];

        while ($queue) {
            $parentId = array_shift($queue);
            foreach ($categories as $category) {
                if ((int) $category->parent_id === (int) $parentId) {
                    $ids[] = $category->id;
                    $queue[] = $category->id;
                }
            }
        }

        return $ids;
    }

 
    public static function getCategories($depth = 3) {
        return self::with(['children' => function ($query) use ($depth) {
            if ($depth > 0) {
                $query->with(['children' => fn($q) => $q->with('children')->active()->ordered()])->active()->ordered();
            }
        }])
        ->where('parent_id', null)
        ->select('id', 'parent_id', 'name', 'image', 'slug')
        ->active()
        ->ordered()
        ->get(); 
    }
}