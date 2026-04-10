<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@kayla.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Regular User
        User::create([
            'name' => 'Kayla Customer',
            'email' => 'user@kayla.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Dummy Products
        Product::insert([
            [
                'name' => 'Laptop Asus ROG Strix',
                'description' => 'Laptop gaming dengan performa tinggi untuk gamer profesional.',
                'price' => 25000000,
                'brand' => 'Asus',
                'stock' => 10,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MacBook Pro M2',
                'description' => 'Laptop Apple dengan chip M2 untuk produktivitas maksimal.',
                'price' => 30000000,
                'brand' => 'Apple',
                'stock' => 5,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Smartphone flagship terbaru dengan material titanium.',
                'price' => 20000000,
                'brand' => 'Apple',
                'stock' => 15,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Smartphone premium dengan fitur AI canggih dari Samsung.',
                'price' => 22000000,
                'brand' => 'Samsung',
                'stock' => 12,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
