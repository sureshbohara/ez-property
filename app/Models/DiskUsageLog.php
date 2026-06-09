<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskUsageLog extends Model
{
    use HasFactory;

    protected $fillable = ['log_date', 'used_bytes', 'total_bytes'];
    protected $casts = [
        'log_date' => 'date',
    ];
}