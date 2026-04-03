<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ecfa.com',
            'password' => Hash::make('password'),
            'phone' => '9876543210',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@ecfa.com',
            'password' => Hash::make('password'),
            'phone' => '9876543211',
            'email_verified_at' => now(),
        ]);
    }
}
