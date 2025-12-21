<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin PATAH',
            'email' => 'admin@patah.com',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1, Surabaya',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Customer User
        User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@patah.com',
            'phone' => '081234567891',
            'address' => 'Jl. Customer No. 1, Surabaya',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'is_active' => true,
        ]);

        // Create Courier Users
        User::create([
            'name' => 'Kurir Satu',
            'email' => 'kurir1@patah.com',
            'phone' => '081234567892',
            'address' => 'Jl. Kurir No. 1, Surabaya',
            'password' => Hash::make('password'),
            'role' => 'courier',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Kurir Dua',
            'email' => 'kurir2@patah.com',
            'phone' => '081234567893',
            'address' => 'Jl. Kurir No. 2, Surabaya',
            'password' => Hash::make('password'),
            'role' => 'courier',
            'is_active' => true,
        ]);

        // Create Products - Original variants
        $originalProducts = [
            ['weight' => 50, 'price' => 10000],
            ['weight' => 100, 'price' => 18000],
            ['weight' => 250, 'price' => 40000],
            ['weight' => 500, 'price' => 75000],
            ['weight' => 1000, 'price' => 140000],
        ];

        foreach ($originalProducts as $product) {
            $weightLabel = $product['weight'] >= 1000 ? ($product['weight'] / 1000) . ' kg' : $product['weight'] . ' gram';
            Product::create([
                'name' => 'Kerupuk PATAH Original ' . $weightLabel,
                'slug' => 'kerupuk-patah-original-' . $product['weight'] . 'g',
                'description' => 'Kerupuk PATAH rasa Original dengan berat ' . $weightLabel . '. Terbuat dari pakcoy dan tahu pilihan, diproses secara higienis tanpa pengawet. Renyah, gurih, dan sehat!',
                'price' => $product['price'],
                'stock' => 100,
                'weight' => $product['weight'],
                'category' => 'original',
                'is_active' => true,
            ]);
        }

        // Create Products - Pedas variants
        $pedasProducts = [
            ['weight' => 50, 'price' => 12000],
            ['weight' => 100, 'price' => 20000],
            ['weight' => 250, 'price' => 45000],
            ['weight' => 500, 'price' => 85000],
            ['weight' => 1000, 'price' => 160000],
        ];

        foreach ($pedasProducts as $product) {
            $weightLabel = $product['weight'] >= 1000 ? ($product['weight'] / 1000) . ' kg' : $product['weight'] . ' gram';
            Product::create([
                'name' => 'Kerupuk PATAH Pedas ' . $weightLabel,
                'slug' => 'kerupuk-patah-pedas-' . $product['weight'] . 'g',
                'description' => 'Kerupuk PATAH rasa Pedas dengan berat ' . $weightLabel . '. Perpaduan pakcoy, tahu, dan bumbu pedas pilihan. Sensasi pedas yang bikin nagih!',
                'price' => $product['price'],
                'stock' => 100,
                'weight' => $product['weight'],
                'category' => 'pedas',
                'is_active' => true,
            ]);
        }

        // Create sample galleries
        $galleries = [
            [
                'title' => 'Kerupuk PATAH Fresh dari Oven',
                'description' => 'Proses pembuatan kerupuk PATAH yang higienis',
                'type' => 'image',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Bahan Baku Pilihan',
                'description' => 'Pakcoy dan tahu segar berkualitas tinggi',
                'type' => 'image',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Packaging PATAH',
                'description' => 'Kemasan praktis dan higienis',
                'type' => 'image',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::create($gallery);
        }
    }
}
