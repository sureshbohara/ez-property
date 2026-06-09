<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasImages;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasImages;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'mobile',
        'address',
        'gender',
        'image',
        'details',
        'status',
        'order_level',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'password'          => 'hashed',
        'status'            => 'boolean',
        'order_level'       => 'integer',
    ];



    // Relationships
    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function permissionRecord(){
        return $this->hasOne(Permission::class, 'role_id', 'role_id');
    }

    // Query Scopes
    public function scopeActive($query){
        return $query->where('status', true);
    }

    public function scopeOrdered($query){
        return $query->orderBy('order_level', 'asc')
                    ->orderBy('name', 'asc');
    }

    public function scopeSearch($query, string $term){
        return $query->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('mobile', 'like', "%{$term}%");
    }

    // Helper Methods
    public function isSuperAdmin(): bool
    {
        return $this->role?->name === 'super_admin';
    }

    public function hasPermission(string $entity, string $action): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        $permissions = $this->permissionRecord?->permissions ?? [];
        return isset($permissions[$entity][$action]) && $permissions[$entity][$action] === '1';
    }

    public function canDo(string $ability): bool
    {
        if (!str_contains($ability, '.')) {
            return false;
        }
        [$entity, $action] = explode('.', $ability, 2);
        return $this->hasPermission($entity, $action);
    }
}