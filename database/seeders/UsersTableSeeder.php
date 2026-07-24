<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'System Admin',
                'email' => 'admin@ezproperty.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+977-9800000000',
                'address' => 'Kathmandu, Nepal',
                'gender' => 'male',
                'details' => 'Main system administrator for frontend',
                'image' => null,
                'pan_number' => null,
                'citizenship_number' => null,
                'host_status' => 'none',
                'remember_token' => Str::random(60),
            ],
            [
                'name' => 'Ram Bahadur (Approved Host)',
                'email' => 'host@ezproperty.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'host', 
                'phone' => '+977-9801111111',
                'address' => 'Lakeside, Pokhara',
                'gender' => 'male',
                'details' => 'I am an approved host with a beautiful lakeside property.',
                'image' => null,
                'pan_number' => '123456789',
                'citizenship_number' => '12-34-56-789',
                'host_status' => 'approved', 
                'remember_token' => Str::random(60),
            ],
            [
                'name' => 'Sita Sharma (Pending Host)',
                'email' => 'pending@ezproperty.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'guest',
                'phone' => '+977-9802222222',
                'address' => 'Sauraha, Chitwan',
                'gender' => 'female',
                'details' => 'Applied to become a host for my jungle safari lodge.',
                'image' => null,
                'pan_number' => '987654321',
                'citizenship_number' => '98-76-54-321',
                'host_status' => 'pending', 
                'remember_token' => Str::random(60),
            ],
            [
                'name' => 'John Doe (Normal Guest)',
                'email' => 'guest@ezproperty.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'guest', 
                'phone' => '+977-9803333333',
                'address' => 'Thamel, Kathmandu',
                'gender' => 'male',
                'details' => 'Just a regular traveler looking for stays.',
                'image' => null,
                'pan_number' => null,
                'citizenship_number' => null,
                'host_status' => 'none',
                'remember_token' => Str::random(60),
            ],
            [
                'name' => 'Jane Smith (Rejected Host)',
                'email' => 'rejected@ezproperty.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'guest',
                'phone' => '+977-9804444444',
                'address' => 'Bhaktapur',
                'gender' => 'female',
                'details' => 'My host application was rejected.',
                'image' => null,
                'pan_number' => null,
                'citizenship_number' => null,
                'host_status' => 'rejected', 
                'remember_token' => Str::random(60),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('✓ Frontend Users (Admin, Host, Guest, Pending) seeded successfully!');
    }
}