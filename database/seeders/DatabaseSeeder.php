<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed reference data first
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
        ]);

        // Seed products (depends on brands and categories)
        $this->call([
            ProductSeeder::class,
        ]);

        // Ensure an admin user exists (keeps existing password if already present)
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD', 'password');

        $admin = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        if (!$admin->is_admin) {
            $admin->is_admin = true;
            $admin->save();
        }

        // Seed a few regular users for reviews, carts, etc.
        $this->call([
            UserSeeder::class,
        ]);

        // Seed reviews for existing products
        $this->call([
            ReviewSeeder::class,
        ]);
    }
}
