<?php

namespace App\Services\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    protected array $entities = [
        'user', 'role', 'permission', 'setting', 
        'banner', 'category', 'service', 'review', 'gallery', 'faq','team','fleet','page','blog'
    ];

    protected array $actions = ['read', 'create', 'update', 'delete'];

    public function __construct(protected Permission $permission) {}

    public function getPermissionData(?int $roleId = null): array
    {
        $perm = $roleId ? $this->permission->where('role_id', $roleId)->first() : null;
        
        return [
            'entities'    => $this->entities,
            'actions'     => $this->actions,
            'permissions' => $perm?->permissions ?? $this->getDefaultPermissions(),
            'roles'       => Role::active()->orderBy('name')->get(),
        ];
    }

    public function validatePermissions(array $input): array
    {
        $validated = [];
        foreach ($this->entities as $entity) {
            foreach ($this->actions as $action) {
                $validated[$entity][$action] = 
                    ($input[$entity][$action] ?? '') === '1' ? '1' : '0';
            }
        }
        return $validated;
    }

    public function createPermissions(int $roleId, array $input): Permission
    {
        $permissions = $this->validatePermissions($input);
        return $this->permission->updateOrCreate(
            ['role_id' => $roleId],
            ['permissions' => $permissions]
        );
    }

    public function updatePermissions(int $permissionId, array $input): Permission
    {
        $perm = $this->permission->findOrFail($permissionId);
        $permissions = $this->validatePermissions($input);
        $perm->update(['permissions' => $permissions]);
        $perm->clearAdminCache();
        return $perm->fresh();
    }

    public function deletePermissions(int $id): bool
    {
        $perm = $this->permission->findOrFail($id);
        if ($perm->role?->name === 'super_admin') {
            throw new \Exception('Super Admin permissions are locked.');
        }
        $perm->clearAdminCache();
        return $perm->delete();
    }

    public function grantAllToRole(int $roleId, ?string $entity = null): Permission
    {
        return DB::transaction(function () use ($roleId, $entity) {
            $perm = $this->permission->firstOrNew(['role_id' => $roleId]);
            if ($entity) {
                $perm->grantAll($entity);
            } else {
                foreach ($this->entities as $ent) {
                    $perm->grantAll($ent);
                }
            }
            $perm->save();
            $perm->clearAdminCache();
            return $perm;
        });
    }

    public function revokeAllFromRole(int $roleId, ?string $entity = null): Permission
    {
        return DB::transaction(function () use ($roleId, $entity) {
            $perm = $this->permission->firstOrNew(['role_id' => $roleId]);
            if ($entity) {
                $perm->revokeAll($entity);
            } else {
                foreach ($this->entities as $ent) {
                    $perm->revokeAll($ent);
                }
            }
            $perm->save();
            $perm->clearAdminCache();
            return $perm;
        });
    }

    protected function getDefaultPermissions(): array
    {
        $default = [];
        foreach ($this->entities as $entity) {
            $default[$entity] = array_fill_keys($this->actions, '0');
        }
        $default['user']['read'] = '1';
        $default['setting']['read'] = '1';
        return $default;
    }

    public function getEntities(): array { return $this->entities; }
    public function getActions(): array { return $this->actions; }
}