<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent; 

class LoginActivity extends Model
{
    use HasFactory;

    protected $table = 'login_activities';

    protected $fillable = [
        'admin_id',
        'ip_address',
        'user_agent',
        'os',
        'browser',
        'device_type',
        'login_at',
        'logout_at',
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

   
    public static function recordLogin(Admin $admin, Request $request): void
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        self::create([
            'admin_id'    => $admin->id,
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'os'          => $agent->platform(),
            'browser'     => $agent->browser(),
            'device_type' => $agent->deviceType(), 
            'login_at'    => now(),
        ]);
    }
}