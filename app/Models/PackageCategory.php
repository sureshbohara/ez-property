<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageCategory extends Model
{
    use HasFactory;

    protected $table = 'package_categories';
    protected $fillable = ['category_id', 'package_id'];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function package(){
        return $this->belongsTo(Package::class, 'package_id');
    }
}