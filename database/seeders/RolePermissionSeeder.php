<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    private const ENTITIES = [
        'user', 'role', 'permission',
        'banner', 'category', 'service','fleet','team','page','review','gallery','faq','setting','blog'
    ];

    private const ACTIONS = ['read', 'create', 'update', 'delete'];

    public function run(): void
    {
        $this->seedRole('super_admin', self::ENTITIES, []);
        
        $this->seedRole('admin', 
            ['banner', 'category', 'service'],
            ['user' => ['read', 'update'], 'role' => ['read'], 'permission' => ['read']]
        );
        
        $this->seedRole('sub_admin',
            ['category', 'service', 'banner'],
            []
        );
        
        $this->seedRole('normal_user', [], [
            'category' => ['read'],
            'service' => ['read'],
            'banner' => ['read']
        ]);

        $this->command->info('✓ All role permissions seeded!');
    }

    private function seedRole(string $roleName, array $fullAccess, array $partialAccess): void
    {
        $role = Role::where('name', $roleName)->first();
        
        if (!$role) {
            $this->command->warn("⚠️ Role '{$roleName}' not found");
            return;
        }

        $permission = Permission::firstOrNew(['role_id' => $role->id]);
        $perms = $permission->permissions ?? []; 

        foreach ($fullAccess as $entity) {
            $perms[$entity] = ['read' => '1', 'create' => '1', 'update' => '1', 'delete' => '1'];
        }

        foreach ($partialAccess as $entity => $actions) {
            $perms[$entity] = [
                'read'   => in_array('read', $actions) ? '1' : '0',
                'create' => in_array('create', $actions) ? '1' : '0',
                'update' => in_array('update', $actions) ? '1' : '0',
                'delete' => in_array('delete', $actions) ? '1' : '0'
            ];
        }

        $permission->permissions = $perms; 
        $permission->save();
        
        $this->command->info("✓ {$role->display_name} permissions set");
    }
}