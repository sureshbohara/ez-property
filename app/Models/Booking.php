<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'listing_id', 'check_in', 'check_out', 'guests', 
        'total_price', 'status', 'payment_status'
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'total_price' => 'decimal:2',
    ];


    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

 
    public function listing(): BelongsTo {
        return $this->belongsTo(Listing::class, 'listing_id');
    }
}