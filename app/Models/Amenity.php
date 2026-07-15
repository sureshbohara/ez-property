<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Amenity extends Model {
    use HasFactory;
    protected $fillable = ['name', 'slug', 'icon', 'description', 'order_level', 'status'];
    protected $casts = ['status' => 'boolean'];
    
    public function listings() { return $this->belongsToMany(Listing::class, 'amenity_listing'); }

    public function scopeActive($query) { return $query->where('status', true); }

    public function scopeOrdered($query) { return $query->orderBy('order_level', 'asc'); }
    
}