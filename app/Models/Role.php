<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_id');
    }

    public function permission()
    {
        return $this->hasOne(Permission::class, 'role_id');
    }

    public function scopeActive($query): void
    {
        $query->where('status', true);
    }

    public function scopeOrdered($query): void
    {
        $query->orderBy('name');
    }

    public function isSuperAdmin(): bool
    {
        return $this->name === 'super_admin';
    }

    public function canDelete(): bool
    {
        return !$this->isSuperAdmin() && $this->admins()->count() === 0;
    }

    public function getPermissionsArray(): array
    {
        return $this->permission?->permissions ?? [];
    }

    public function hasPermission(string $entity, string $action): bool
    {
        $permissions = $this->getPermissionsArray();
        return isset($permissions[$entity][$action]) && $permissions[$entity][$action] === '1';
    }
}