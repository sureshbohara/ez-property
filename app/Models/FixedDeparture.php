<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FixedDeparture extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id', 'start_date', 'end_date', 'discount_price', 
        'max_seats', 'booked_seats', 'description', 'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'discount_price' => 'decimal:2',
    ];

    public function package() {
        return $this->belongsTo(Package::class);
    }
}