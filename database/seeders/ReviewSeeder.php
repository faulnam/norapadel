<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereIn('role', ['customer', 'admin'])->pluck('id');
        if ($users->isEmpty()) {
            $users = collect([1, 2]);
        }

        $products = Product::pluck('id');
        if ($products->isEmpty()) {
            $this->command->warn('Tidak ada produk untuk di-review.');
            return;
        }

        // Hapus review lama agar tidak ada data nama user akun tersisa
        Review::truncate();
        $this->command->info('Review lama dihapus.');

        // Pool data review real yang akan dirotasi untuk semua produk
        $reviewPool = [
            [
                'name' => 'Andi Wijaya',
                'rating' => 5,
                'comment' => 'Produknya sangat bagus dan sesuai deskripsi. Kualitas premium, recommended banget!',
                'quality_rating' => 92,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Rina Susanti',
                'rating' => 4,
                'comment' => 'Build quality oke, finishing rapi. Cukup puas dengan pembelian ini, worth it.',
                'quality_rating' => 85,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Budi Santoso',
                'rating' => 5,
                'comment' => 'Pelayanan cepat dan aman. Barang sampai dalam kondisi sempurna. Langsung dipakai dan performa maksimal.',
                'quality_rating' => 95,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Dian Kusuma',
                'rating' => 5,
                'comment' => 'Suka banget sama produk ini. Nyaman dipakai dan hasilnya sesuai ekspektasi. Worth the price!',
                'quality_rating' => 90,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => false,
            ],
            [
                'name' => 'Eko Prasetyo',
                'rating' => 4,
                'comment' => 'Desainnya elegan dan enak dipakai. Pengiriman cepat ke Jakarta. Overall puas.',
                'quality_rating' => 80,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Fani Mulyani',
                'rating' => 5,
                'comment' => 'Ini salah satu produk terbaik yang pernah saya beli. Teman-teman pada nanya beli di mana.',
                'quality_rating' => 94,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => false,
            ],
            [
                'name' => 'Gilang Ramadhan',
                'rating' => 4,
                'comment' => 'Kualitas solid, bahan terasa premium. Stabil saat dipakai, meski perlu sedikit penyesuaian.',
                'quality_rating' => 88,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Hani Putri',
                'rating' => 5,
                'comment' => 'Sangat nyaman dipakai, tidak licin. Sizing pas sesuai dengan ukuran biasa saya.',
                'quality_rating' => 90,
                'sizing_rating' => 70,
                'usual_size' => '40',
                'is_verified' => true,
            ],
            [
                'name' => 'Indra Lesmana',
                'rating' => 4,
                'comment' => 'Material bagus, muat banyak perlengkapan. Packaging rapi dan aman sampai rumah.',
                'quality_rating' => 82,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Joko Tanto',
                'rating' => 5,
                'comment' => 'Enak dipakai, tidak licin meski berkeringat. Durabilitas bagus, sudah 2 bulan masih oke.',
                'quality_rating' => 86,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => false,
            ],
            [
                'name' => 'Kartika Sari',
                'rating' => 5,
                'comment' => 'Langganan beli di sini. Produk original, packing aman, dan admin responsif. Top!',
                'quality_rating' => 96,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Lukman Hakim',
                'rating' => 4,
                'comment' => 'Ringan dan enak dipakai. Anak saya jadi lebih semangat latihan. Harga terjangkau.',
                'quality_rating' => 78,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Maya Anggraini',
                'rating' => 5,
                'comment' => 'Warna dan desainnya keren. Performa konsisten, jadi andalan saat main.',
                'quality_rating' => 91,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => false,
            ],
            [
                'name' => 'Nanda Perkasa',
                'rating' => 4,
                'comment' => 'Mudah dipasang dan melindungi dengan baik. Tidak mengganggu keseimbangan saat pakai.',
                'quality_rating' => 75,
                'sizing_rating' => null,
                'usual_size' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Olivia Hartanto',
                'rating' => 5,
                'comment' => 'Comfort level tinggi dan support oke banget. Pertama kali coba dan langsung puas.',
                'quality_rating' => 89,
                'sizing_rating' => 55,
                'usual_size' => '38',
                'is_verified' => true,
            ],
        ];

        $productIds = $products->values()->all();
        $userIds = $users->values()->all();
        $totalCreated = 0;

        // Assign minimal 10 reviews ke SETIAP produk
        foreach ($productIds as $productId) {
            for ($i = 0; $i < 10; $i++) {
                $template = $reviewPool[$i % count($reviewPool)];
                Review::create([
                    'product_id' => $productId,
                    'user_id' => $userIds[$totalCreated % count($userIds)],
                    'reviewer_name' => $template['name'],
                    'order_id' => null,
                    'rating' => $template['rating'],
                    'comment' => $template['comment'],
                    'quality_rating' => $template['quality_rating'],
                    'sizing_rating' => $template['sizing_rating'],
                    'usual_size' => $template['usual_size'],
                    'is_verified' => $template['is_verified'],
                    'is_approved' => true,
                ]);
                $totalCreated++;
            }
        }

        $this->command->info('Berhasil seed ' . $totalCreated . ' reviews untuk ' . count($productIds) . ' produk.');
    }
}
