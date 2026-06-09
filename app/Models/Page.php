<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasImages;
use App\Traits\Slugable;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, Slugable, HasImages;

    protected $fillable = [
        'title', 'slug', 'icon', 'image', 'short_content', 'content',
        'meta_title', 'meta_description', 'meta_keywords',
        'show_in_menu', 'show_in_footer', 'is_featured', 'order_level', 'status',
    ];

    protected $casts = [
        'status'         => 'boolean',
        'show_in_menu'   => 'boolean',
        'show_in_footer' => 'boolean',
        'is_featured'    => 'boolean',
        'order_level'    => 'integer',
    ];



    public function scopeActive($query){
        return $query->where('status', true);
    }
    

    public function scopeOrdered($query){
        return $query->orderBy('order_level', 'asc')->orderBy('created_at', 'desc');
    }

    public function scopeInMenu($query){
        return $query->where('show_in_menu', true);
    }

    public function scopeInFooter($query){
        return $query->where('show_in_footer', true);
    }
}