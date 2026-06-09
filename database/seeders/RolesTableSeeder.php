<?php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Administrator',
                'description' => 'Full system access - cannot be modified or deleted',
                'status' => true,
            ],
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Standard admin access with most permissions',
                'status' => true,
            ],
            [
                'name' => 'sub_admin',
                'display_name' => 'Sub Administrator',
                'description' => 'Limited admin access for specific modules',
                'status' => true,
            ],
            [
                'name' => 'normal_user',
                'display_name' => 'Normal User',
                'description' => 'Basic read-only access to public content',
                'status' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}