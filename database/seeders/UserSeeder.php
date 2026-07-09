<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@hotel.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create Manager
        User::create([
            'name' => 'Hotel Manager',
            'email' => 'manager@hotel.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
        ]);

        // Create Maintenance Staff
        User::create([
            'name' => 'Maintenance Staff',
            'email' => 'staff@hotel.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        // Create Receptionist
        User::create([
            'name' => 'Receptionist',
            'email' => 'reception@hotel.com',
            'password' => Hash::make('password123'),
            'role' => 'receptionist',
        ]);

        $this->command->info('✅ Users created successfully!');
    }
}
