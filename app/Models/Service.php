<?php

namespace App\Models;

use App\Traits\Slugable;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, Slugable, HasImages;

    protected $table = 'services';

    protected $fillable = [
        'title',
        'subtitle',
        'icon',
        'short_content',
        'long_content',
        'slug',
        'image',
        'feature_image',
        'process_title',
        'process_sub_title',
        'process_item',
        'highlight',
        'order_level',
        'status',
        'meta_keywords',
        'meta_description',
    ];

    protected $casts = [
        'process_item'  => 'array',
        'highlight'     => 'array',
        'status'        => 'boolean',
        'order_level'   => 'integer',
    ];

    public function scopeActive($query): void
    {
        $query->where('status', true);
    }

    public function scopeOrdered($query): void
    {
        $query->orderBy('order_level', 'asc')
              ->orderBy('created_at', 'desc');
    }
}