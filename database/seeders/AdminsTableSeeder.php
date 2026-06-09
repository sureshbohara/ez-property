<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    public function run(): void
    {
        $superRole = Role::where('name', 'super_admin')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $subRole = Role::where('name', 'sub_admin')->first();
        $normalRole = Role::where('name', 'normal_user')->first();

        if (!$superRole || !$adminRole || !$subRole) {
            $this->command->error('❌ Roles not found! Run RolesTableSeeder first.');
            return;
        }

        $admins = [
            [
                'name' => 'White Transportation LLC ',
                'email' => 'info@whitetransportllc.com',
                'email_verified_at' => now(),
                'password' => Hash::make('whitetransportllc'),
                'role_id' => $superRole->id,
                'address' => ' New Orleans, LA',
                'mobile' => '(504) 327-6880',
                'details' => 'Primary system administrator with full access',
                'image' => null,
                'gender' => 'male',
                'status' => true,
                'order_level' => 1,
                'last_login_at' => now(),
                'remember_token' => Str::random(60),
            ],
            [
                'name' => 'Content Administrator',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin@123'),
                'role_id' => $adminRole->id,
                'address' => 'Marketing Dept, Tech City',
                'mobile' => '+1234567891',
                'details' => 'Manages content, products, and orders',
                'image' => null,
                'gender' => 'female',
                'status' => true,
                'order_level' => 2,
                'last_login_at' => now(),
                'remember_token' => Str::random(60),
            ],
            [
                'name' => 'Product Manager',
                'email' => 'subadmin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('subadmin@123'),
                'role_id' => $subRole->id,
                'address' => 'Warehouse, Tech City',
                'mobile' => '+1234567892',
                'details' => 'Manages product catalog and categories',
                'image' => null,
                'gender' => 'male',
                'status' => true,
                'order_level' => 3,
                'last_login_at' => null,
                'remember_token' => Str::random(60),
            ],
            [
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('demo@123'),
                'role_id' => $normalRole?->id,
                'address' => null,
                'mobile' => null,
                'details' => 'Demo account for testing user permissions',
                'image' => null,
                'gender' => null,
                'status' => true,
                'order_level' => 99,
                'last_login_at' => null,
                'remember_token' => Str::random(60),
            ],
        ];

        foreach ($admins as $adminData) {
            Admin::firstOrCreate(
                ['email' => $adminData['email']],
                $adminData
            );
        }

        $this->command->info('✓ Admin users seeded successfully!');
    }
}