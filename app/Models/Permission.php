<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'permissions'];

    protected $casts = ['permissions' => 'array'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('role_id', 'asc');
    }

    public function setPermission(string $entity, string $action, bool $value): self
    {
        $permissions = $this->permissions ?? [];
        $permissions[$entity][$action] = $value ? '1' : '0';
        $this->permissions = $permissions;
        return $this;
    }

    public function hasPermission(string $entity, string $action): bool
    {
        return isset($this->permissions[$entity][$action]) 
            && $this->permissions[$entity][$action] === '1';
    }

    public function grantAll(string $entity): self
    {
        foreach (['read', 'create', 'update', 'delete'] as $action) {
            $this->setPermission($entity, $action, true);
        }
        return $this;
    }

    public function revokeAll(string $entity): self
    {
        foreach (['read', 'create', 'update', 'delete'] as $action) {
            $this->setPermission($entity, $action, false);
        }
        return $this;
    }

    public function syncPermissions(array $permissions): self
    {
        $this->permissions = $permissions;
        return $this;
    }

    public function clearAdminCache(): void
    {
        Cache::forget("admin_permissions_role_{$this->role_id}");
    }

    public function getFormattedPermissions(): array
    {
        $formatted = [];
        $permissions = $this->permissions ?? [];

        foreach ($permissions as $entity => $actions) {
            $active = array_filter($actions, fn($v) => $v === '1');
            if (!empty($active)) {
                $formatted[$entity] = array_keys($active);
            }
        }
        return $formatted;
    }
}