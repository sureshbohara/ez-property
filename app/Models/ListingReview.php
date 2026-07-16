<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListingReview extends Model
{
    use HasFactory;

    protected $table = 'listing_reviews'; 

    protected $fillable = [
        'listing_id', 'user_id', 'guest_name', 'overall_rating', 'cleanliness',
        'accuracy', 'check_in', 'location', 'value', 'comment', 'stay_date', 'is_approved',
    ];

    protected $casts = [
        'listing_id'     => 'integer',
        'user_id'        => 'integer',
        'overall_rating' => 'decimal:1',
        'cleanliness'    => 'decimal:1',
        'accuracy'       => 'decimal:1',
        'check_in'       => 'decimal:1',
        'location'       => 'decimal:1',
        'value'          => 'decimal:1',
        'stay_date'      => 'date',
        'is_approved'    => 'boolean',
    ];

    public function listing(): BelongsTo {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeApproved($query) {
        return $query->where('is_approved', true);
    }

    public function scopeLatestFirst($query) {
        return $query->orderBy('created_at', 'desc');
    }
    
}