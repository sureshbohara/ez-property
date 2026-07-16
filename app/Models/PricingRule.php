<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model {
    
    protected $fillable = ['listing_id', 'start_date', 'end_date', 'price_per_night', 'minimum_nights'];
    
    protected $casts = [
        'price_per_night' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function listing() {return $this->belongsTo(Listing::class); }
}