<?php

namespace Database\Seeders;

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

        // Create Products
        $products = [
            [
                'name' => 'Kerupuk Pakcoy Original',
                'slug' => 'kerupuk-pakcoy-original',
                'description' => 'Kerupuk renyah berbahan dasar pakcoy segar pilihan. Diproduksi dengan cara tradisional tanpa pengawet dan pewarna buatan. Cocok sebagai camilan sehat untuk keluarga.',
                'price' => 25000,
                'stock' => 100,
                'category' => 'pakcoy',
                'is_active' => true,
            ],
            [
                'name' => 'Kerupuk Pakcoy Pedas',
                'slug' => 'kerupuk-pakcoy-pedas',
                'description' => 'Variasi kerupuk pakcoy dengan tambahan bumbu pedas yang menggugah selera. Tingkat kepedasan pas untuk pecinta makanan pedas.',
                'price' => 28000,
                'stock' => 75,
                'category' => 'pakcoy',
                'is_active' => true,
            ],
            [
                'name' => 'Kerupuk Tahu Crispy',
                'slug' => 'kerupuk-tahu-crispy',
                'description' => 'Kerupuk tahu dengan tekstur super crispy. Terbuat dari tahu berkualitas tinggi yang diproses secara higienis. Kaya protein dan rendah lemak.',
                'price' => 22000,
                'stock' => 120,
                'category' => 'tahu',
                'is_active' => true,
            ],
            [
                'name' => 'Kerupuk Tahu Keju',
                'slug' => 'kerupuk-tahu-keju',
                'description' => 'Perpaduan unik kerupuk tahu dengan taburan keju. Gurih, renyah, dan cocok untuk semua usia. Favorit anak-anak!',
                'price' => 30000,
                'stock' => 60,
                'category' => 'tahu',
                'is_active' => true,
            ],
            [
                'name' => 'Kerupuk Mix Pakcoy Tahu',
                'slug' => 'kerupuk-mix-pakcoy-tahu',
                'description' => 'Kombinasi terbaik kerupuk pakcoy dan tahu dalam satu kemasan. Dapatkan dua rasa sekaligus dengan harga hemat!',
                'price' => 35000,
                'stock' => 80,
                'category' => 'mix',
                'is_active' => true,
            ],
            [
                'name' => 'Kerupuk Mix Premium',
                'slug' => 'kerupuk-mix-premium',
                'description' => 'Paket premium berisi 3 varian kerupuk: pakcoy original, tahu crispy, dan mix special. Kemasan eksklusif cocok untuk hadiah.',
                'price' => 50000,
                'stock' => 40,
                'category' => 'mix',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
