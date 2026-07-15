<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model {

    protected $fillable = ['listing_id', 'date', 'status', 'custom_price'];

    protected $casts = ['custom_price' => 'decimal:2'];

    public function listing() { return $this->belongsTo(Listing::class); }
    
}
