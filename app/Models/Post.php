<?php

namespace App\Models;

use App\Traits\Slugable;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   use HasFactory, Slugable, HasImages;

   protected $fillable = [
        'category_id', 'title', 'slug', 'image', 'excerpt', 'description',
        'meta_title', 'meta_description', 'views', 'is_featured', 'status', 'order_level'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];


    public function scopeActive($query): void
    {
        $query->where('status', 'active');
    }

    public function scopeOrdered($query): void
    {
        $query->orderBy('order_level', 'asc')->orderBy('created_at', 'desc');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}