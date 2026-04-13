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
            'name' => 'Admin Nora Padel',
            'email' => 'admin@norapadel.id',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1, Surabaya',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Customer User
        User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@norapadel.id',
            'phone' => '081234567891',
            'address' => 'Jl. Customer No. 1, Surabaya',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'is_active' => true,
        ]);

        // Create Courier Users
        User::create([
            'name' => 'Kurir Satu',
            'email' => 'kurir1@norapadel.id',
            'phone' => '081234567892',
            'address' => 'Jl. Kurir No. 1, Surabaya',
            'password' => Hash::make('password'),
            'role' => 'courier',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Kurir Dua',
            'email' => 'kurir2@norapadel.id',
            'phone' => '081234567893',
            'address' => 'Jl. Kurir No. 2, Surabaya',
            'password' => Hash::make('password'),
            'role' => 'courier',
            'is_active' => true,
        ]);

        // Create Products - Raket Padel
        $racketProducts = [
            [
                'name' => 'Nora Pro Carbon Attack 3K',
                'slug' => 'nora-pro-carbon-attack-3k',
                'description' => 'Raket padel premium dengan permukaan carbon 3K, sweet spot luas, dan kontrol stabil untuk permainan menyerang.',
                'price' => 1850000,
                'weight' => 360,
            ],
            [
                'name' => 'Nora Control Master 365',
                'slug' => 'nora-control-master-365',
                'description' => 'Raket all-round untuk pemula hingga intermediate dengan handling ringan dan akurasi pukulan tinggi.',
                'price' => 1290000,
                'weight' => 365,
            ],
            [
                'name' => 'Nora Elite Hybrid 370',
                'slug' => 'nora-elite-hybrid-370',
                'description' => 'Kombinasi power dan kontrol untuk pemain kompetitif, dilengkapi inti EVA medium density.',
                'price' => 2150000,
                'weight' => 370,
            ],
            [
                'name' => 'Nora Beginner Soft Touch 355',
                'slug' => 'nora-beginner-soft-touch-355',
                'description' => 'Raket nyaman untuk pemain baru dengan vibration dampening agar lengan tidak cepat lelah.',
                'price' => 890000,
                'weight' => 355,
            ],
            [
                'name' => 'Nora Power Smash 375',
                'slug' => 'nora-power-smash-375',
                'description' => 'Raket head-heavy untuk pukulan smash eksplosif, cocok untuk pemain ofensif.',
                'price' => 2390000,
                'weight' => 375,
            ],
        ];

        foreach ($racketProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => 100,
                'weight' => $product['weight'],
                'category' => 'original',
                'is_active' => true,
            ]);
        }

        // Create Products - Aksesori Padel
        $accessoryProducts = [
            [
                'name' => 'Nora Match Ball Pro (3 Balls)',
                'slug' => 'nora-match-ball-pro-3',
                'description' => 'Bola padel bertekanan tinggi dengan daya tahan optimal untuk latihan intens dan pertandingan.',
                'price' => 95000,
                'weight' => 300,
            ],
            [
                'name' => 'Nora Tour Padel Bag 6R',
                'slug' => 'nora-tour-padel-bag-6r',
                'description' => 'Tas padel kapasitas 6 raket dengan kompartemen sepatu dan bahan tahan air.',
                'price' => 650000,
                'weight' => 900,
            ],
            [
                'name' => 'Nora Court Grip Pack (6 pcs)',
                'slug' => 'nora-court-grip-pack-6',
                'description' => 'Overgrip anti-slip untuk kontrol maksimal dan kenyamanan genggaman saat rally panjang.',
                'price' => 135000,
                'weight' => 300,
            ],
            [
                'name' => 'Nora Motion Padel Shoes',
                'slug' => 'nora-motion-padel-shoes',
                'description' => 'Sepatu padel dengan outsole herringbone, grip kuat, dan stabilitas tinggi di lapangan sintetis.',
                'price' => 1190000,
                'weight' => 1000,
            ],
            [
                'name' => 'Nora Wristband DryFit Pair',
                'slug' => 'nora-wristband-dryfit-pair',
                'description' => 'Wristband ringan berbahan DryFit untuk menyerap keringat dan menjaga fokus permainan.',
                'price' => 69000,
                'weight' => 300,
            ],
        ];

        foreach ($accessoryProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
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
                'title' => 'Tips Bermain Padel untuk Pemula',
                'description' => 'Panduan teknik dasar positioning, volley, dan servis yang efektif.',
                'type' => 'image',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Review Raket Padel 2026',
                'description' => 'Perbandingan raket attack, control, dan hybrid untuk semua level pemain.',
                'type' => 'image',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Nora Padel Open Weekend Event',
                'description' => 'Dokumentasi event komunitas, coaching clinic, dan mini tournament.',
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
