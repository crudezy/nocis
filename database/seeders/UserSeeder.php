<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        // Create customer user
        User::updateOrCreate(
            ['username' => 'customer'],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => Hash::make('customer123'),
                'role' => 'customer'
            ]
        );

        // Create additional test customer
        User::updateOrCreate(
            ['username' => 'john_doe'],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer'
            ]
        );
    }
}