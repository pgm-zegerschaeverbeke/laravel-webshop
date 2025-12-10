<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Fixed users met bekende emails
        $testUsers = [
            ['first_name' => 'Alice', 'last_name' => 'Scammer', 'email' => 'alice@example.com'],
            ['first_name' => 'Bob', 'last_name' => 'Fraudster', 'email' => 'bob@example.com'],
            ['first_name' => 'Carol', 'last_name' => 'Conman', 'email' => 'carol@example.com'],
            ['first_name' => 'Dave', 'last_name' => 'Deceiver', 'email' => 'dave@example.com'],
            ['first_name' => 'Eve', 'last_name' => 'Exploiter', 'email' => 'eve@example.com'],
        ];

        foreach ($testUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name'],
                    'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                    'is_admin' => false,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }

        // Random users
        User::factory()->count(5)->create(['is_admin' => false]);
    }
}
