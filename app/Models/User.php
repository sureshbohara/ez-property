<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasImages;

    protected $fillable = [
        'name', 'email', 'phone', 'address','gender','details', 'image', 'role', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['image_url'];

    public function bookings() {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function sentMessages() {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages() {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function listings() {
        return $this->hasMany(Listing::class, 'user_id');
    }

   public function savedListings() {
     return $this->belongsToMany(Listing::class, 'saved_listings')->withTimestamps();
   }
   

}