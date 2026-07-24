<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingTableSeeder::class,
            RolesTableSeeder::class,
            RolePermissionSeeder::class,
            AdminsTableSeeder::class,
            ServiceTableSeeder::class,
            FleetTableSeeder::class,
            ReviewTableSeeder::class,
            PageTableSeeder::class,
            CategoryTableSeeder::class,
            AmenityTableSeeder::class,
            PropertyTableSeeder::class,
            FaqTableSeeder::class,
            UsersTableSeeder::class,
        ]);
        $this->command->info("\n🎉 All RBAC seeders completed successfully!");
    }
}