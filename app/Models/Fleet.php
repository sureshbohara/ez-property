<?php

namespace App\Models;
use App\Traits\Slugable;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Fleet extends Model
{
    
    use HasFactory, Slugable, HasImages;
    protected $table = 'fleets';

    protected $fillable = [
        'title',
        'subtitle',
        'short_content',
        'slug',
        'image',
        'feature_image',
        'bags',
        'passengers',
        'highlight',
        'order_level',
        'status',
    ];

    protected $casts = [
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
