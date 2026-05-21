<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua review lama
        Review::truncate();
        $this->command->info('Review lama dihapus.');

        // ================================================
        // BANK REVIEW SPESIFIK PER PRODUK
        // ================================================
        $bankReview = [
            'max protector' => [
                ['name' => 'athena_shigen', 'rating' => 5, 'comment' => 'Raket jadi aman, bahan gel tebal terproteksi maksimal sampai ke samping.', 'is_verified' => true],
                ['name' => 'mudhanovia84', 'rating' => 5, 'comment' => "Pengiriman cepat walaupun saat order statusnya pre order\nMantab sih dapat harga murah", 'is_verified' => true],
            ],
            'wilson overgrip perforated' => [
                ['name' => 'trizkiawawaw', 'rating' => 5, 'comment' => 'Enak dipakai untuk dobel dg grip asli, tidak terlalu tebal, nyaman digenggam', 'is_verified' => true],
                ['name' => 'slava8899', 'rating' => 5, 'comment' => 'Kualitas bagus 👍. Terima kasih', 'is_verified' => true],
            ],
            'overgrip wilson racket padel' => [
                ['name' => 'arvinsetiawan79', 'rating' => 5, 'comment' => 'Sesuai dengan kualitas, recommended seller', 'is_verified' => true],
            ],
            'nox nerbo speed balls' => [
                ['name' => 'yudhadara18', 'rating' => 5, 'comment' => 'Mantap pengiriman cepet , warbyasak', 'is_verified' => true],
            ],
            'nox equation hard' => [
                ['name' => 'widi_kendhi', 'rating' => 5, 'comment' => 'Sellernya baik banget....T O P pokoknya', 'is_verified' => true],
            ],
            'nox equation soft' => [
                ['name' => 'derichteha', 'rating' => 5, 'comment' => 'pengiriman sangat cepat, seller nya baik banget,, next klo order pasti disini lagiii', 'is_verified' => true],
            ],
            'nox calzado ml10 hexa blue/silver' => [
                ['name' => 'alamnh', 'rating' => 5, 'comment' => 'Cuakepop pollll', 'is_verified' => true],
            ],
            'nox x - one casual' => [
                ['name' => 'carlosardo', 'rating' => 5, 'comment' => 'Raket padle nya bagus', 'is_verified' => true],
            ],
            'babolat technical viper 2024' => [
                ['name' => 'filgi', 'rating' => 5, 'comment' => 'Barang sampai dengan aman, best pelayanan, makasih jugaaa udah di kasih bonus handgrip+protector🙏🏻', 'is_verified' => true],
                ['name' => 'gandhigo', 'rating' => 5, 'comment' => 'Cepat delivery dan sesuai permintaan. Free overgrip dan protector rackethead', 'is_verified' => true],
            ],
            'babolat technical viper 2025' => [
                ['name' => 'srikandi_32', 'rating' => 5, 'comment' => 'Harga termurah dibanding online store lain maupun toko offline', 'is_verified' => true],
            ],
            'babolat counter viper 2025' => [
                ['name' => 'ryo_siregar', 'rating' => 5, 'comment' => 'carbon cukup keras, untuk smash mantap. finishing cat raket nya glossy tapi ada permukaan kasar sampai ke bagian samping raket nya', 'is_verified' => true],
            ],
            'babolat air viper 2025' => [
                ['name' => 'pleat_pleats', 'rating' => 5, 'comment' => "Bagus dan keren\nPengiriman juga cepat same day delivery\nRekomen untuk beli dsini", 'is_verified' => true],
                ['name' => 'karimnazri', 'rating' => 5, 'comment' => 'beli raket yg kedua kalinya di toko ini, dan dapat bonus banyak, auto langsung dipake maen wkwk', 'is_verified' => true],
                ['name' => 'raksepatu.idn', 'rating' => 5, 'comment' => "Cocok untuk pemain net. Placing ball accurate.\nKalibrasi new racket cepet karena easy to use but power dapet banget", 'is_verified' => true],
            ],
            'bullpadel indiga women 2026' => [
                ['name' => 'carlosardo', 'rating' => 5, 'comment' => 'Raketnya bagus dan ringan', 'is_verified' => true],
            ],
            'bullpadel vertex 05 woman 2026' => [
                ['name' => 'meryfu89', 'rating' => 5, 'comment' => 'bagus untuk yg butuh power dan ringan. original', 'is_verified' => true],
            ],
            'bullpadel vertex 04 2025' => [
                ['name' => 'rangganisa2431', 'rating' => 5, 'comment' => "Dari build quality, pas diterima ditangan feelnya berasa original, keren!\nH-1 lebaran dikirim juga dan sampe di lebaran kedua", 'is_verified' => true],
            ],
            'bullpadel vertex 04 hybrid 2025 raket padel' => [
                ['name' => 'luzasby', 'rating' => 5, 'comment' => 'sellernya ramah powl, suabar meskipun nanyak ini itu dan fast respon', 'is_verified' => true],
                ['name' => 'serasishop', 'rating' => 5, 'comment' => "Pertama kali beli di Nora Padel. Sebelum beli sdh research cr bedakan raket asli dan palsu. Syukurnya dr nora padel ini ORIGINAL.\nEh dpt banyak freebies lagi...", 'is_verified' => true],
            ],
            'bullpadel vertex 04 racket 2024' => [
                ['name' => 'alfhyshop', 'rating' => 5, 'comment' => 'Mantap bagus banyak bonus nya juga .. seller nya juga enak bisa konsultasi buat pilih mana raket semua pertanyaan saya di jawab degan jelas.🙏', 'is_verified' => true],
            ],
            'bullpadel bag paleteros pro line bpp26022' => [
                ['name' => 'jason_nathan', 'rating' => 5, 'comment' => 'Packing aman, pengiriman cepat ntar di upload lagi setelah grip nya di pasang, thank you..', 'is_verified' => true],
            ],
            'bullpadel xplo 25' => [
                ['name' => 'hanry.tanto', 'rating' => 5, 'comment' => "Keren sih…\nGak nyesel belinya…\nBagus, packaging aman, dikasi bonus grip nya juga…\nTerima kasih!!!", 'is_verified' => true],
                ['name' => 'onartroy2000', 'rating' => 5, 'comment' => 'Barang ori 100%, pelayanan cepat.. Makasih', 'is_verified' => true],
                ['name' => 'vanalbert88', 'rating' => 5, 'comment' => "Recomend seller.. 👍🏽👍🏽👍🏽👍🏽\nBarang nya asli Original..\nTrusted seller ...", 'is_verified' => true],
            ],
            'edge guard strip white leather' => [
                ['name' => 'tokomimi18', 'rating' => 5, 'comment' => 'Tq seller sdh kedua kalinya order disini murah trs cepet juga, kirim instan langsung sampe.', 'is_verified' => true],
                ['name' => 'hanry.tanto', 'rating' => 5, 'comment' => "Free protector buat raketnya…\nSimpel biasa sih transparan…\nYg penting bisa melindungi..\nMakasi", 'is_verified' => true],
                ['name' => 'diahkaruniasari', 'rating' => 5, 'comment' => 'Yeay maaci bonusannya wrna pink pulan mntep deh luv skali ❤️🫶🩷', 'is_verified' => true],
            ],
            'head zephyr pro blue black' => [
                ['name' => 'putraadhik', 'rating' => 5, 'comment' => 'Mudah2an awet', 'is_verified' => true],
            ],
            'alpha play blue black' => [
                ['name' => 'carlosardo', 'rating' => 5, 'comment' => 'Raketnya bagus dan ringan', 'is_verified' => true],
            ],
            'alpha game blue yellow' => [
                ['name' => 'rendypastya', 'rating' => 5, 'comment' => 'Seller fast respon dan bisa memeberi rekomendasi, dan banyak hadiahhnyaaa, toko rekomended banget, good joob good seller 🥰', 'is_verified' => true],
            ],
            'alpha padel ball' => [
                ['name' => 'taufiqardiputra', 'rating' => 5, 'comment' => 'Sesuai', 'is_verified' => true],
            ],
            'alpha padel vibe' => [
                ['name' => 'taufiqardiputra', 'rating' => 5, 'comment' => 'Sesuai', 'is_verified' => true],
            ],
            'hesacore arronax' => [
                ['name' => 'ronnyrenaldy291', 'rating' => 5, 'comment' => 'Pas banget', 'is_verified' => true],
            ],
            'pro spin strip' => [
                ['name' => 'anissugeng', 'rating' => 5, 'comment' => 'Kemasannya aman banget. Barang perfect condition', 'is_verified' => true],
                ['name' => 'ayu_andini2104', 'rating' => 5, 'comment' => 'Produknya sampai dengan aman. Order kemarin pagi, skrg sudah datang. Kemasan rapih', 'is_verified' => true],
                ['name' => 'mariam_fatimah', 'rating' => 5, 'comment' => 'Bahan berkualitas, produk original, pengiriman cepat. Makasi min🥰', 'is_verified' => true],
            ],
            'alpha kinesiology' => [
                ['name' => 'iyz_236', 'rating' => 5, 'comment' => 'Mantappp raketny .. ORI 1000prsen', 'is_verified' => true],
            ],
            'tambahan packing box' => [
                ['name' => 'derichteha', 'rating' => 5, 'comment' => 'pengiriman sangat cepat, seller nya baik banget,, next klo order pasti disini lagiii', 'is_verified' => true],
            ],
        ];

        // ================================================
        // POOL REVIEW FALLBACK (untuk produk yg tidak ada di bankReview)
        // Dibuat bervariasi per produk menggunakan product_id sebagai seed
        // ================================================
        $fallbackPool = [
            ['name' => 'andi_wijaya88', 'rating' => 5, 'comment' => 'Produknya sangat bagus dan sesuai deskripsi. Kualitas premium, recommended banget!', 'is_verified' => true],
            ['name' => 'rina_susanti21', 'rating' => 4, 'comment' => 'Build quality oke, finishing rapi. Cukup puas dengan pembelian ini, worth it.', 'is_verified' => true],
            ['name' => 'budi_santoso', 'rating' => 5, 'comment' => 'Pelayanan cepat dan aman. Barang sampai dalam kondisi sempurna. Langsung dipakai dan performa maksimal.', 'is_verified' => true],
            ['name' => 'dian_kusuma77', 'rating' => 5, 'comment' => 'Suka banget sama produk ini. Nyaman dipakai dan hasilnya sesuai ekspektasi. Worth the price!', 'is_verified' => false],
            ['name' => 'eko_prasetyo', 'rating' => 4, 'comment' => 'Desainnya elegan dan enak dipakai. Pengiriman cepat. Overall puas.', 'is_verified' => true],
            ['name' => 'fani_mulyani', 'rating' => 5, 'comment' => 'Ini salah satu produk terbaik yang pernah saya beli. Teman-teman pada nanya beli di mana.', 'is_verified' => false],
            ['name' => 'gilang_rama', 'rating' => 4, 'comment' => 'Kualitas solid, bahan terasa premium. Stabil saat dipakai, meski perlu sedikit penyesuaian.', 'is_verified' => true],
            ['name' => 'hani_putri03', 'rating' => 5, 'comment' => 'Sangat nyaman dipakai, tidak licin. Sizing pas sesuai dengan ukuran biasa saya.', 'is_verified' => true],
            ['name' => 'indra_lesmana', 'rating' => 4, 'comment' => 'Material bagus, muat banyak perlengkapan. Packaging rapi dan aman sampai rumah.', 'is_verified' => true],
            ['name' => 'joko_tanto99', 'rating' => 5, 'comment' => 'Enak dipakai, tidak licin meski berkeringat. Durabilitas bagus, sudah 2 bulan masih oke.', 'is_verified' => false],
            ['name' => 'kartika_sari', 'rating' => 5, 'comment' => 'Langganan beli di sini. Produk original, packing aman, dan admin responsif. Top!', 'is_verified' => true],
            ['name' => 'lukman_hakim', 'rating' => 4, 'comment' => 'Ringan dan enak dipakai. Anak saya jadi lebih semangat latihan. Harga terjangkau.', 'is_verified' => true],
            ['name' => 'maya_anggraini', 'rating' => 5, 'comment' => 'Warna dan desainnya keren. Performa konsisten, jadi andalan saat main.', 'is_verified' => false],
            ['name' => 'nanda_perkasa', 'rating' => 4, 'comment' => 'Mudah dipasang dan melindungi dengan baik. Tidak mengganggu keseimbangan saat pakai.', 'is_verified' => true],
            ['name' => 'olivia_hart', 'rating' => 5, 'comment' => 'Comfort level tinggi dan support oke banget. Pertama kali coba dan langsung puas.', 'is_verified' => true],
            ['name' => 'ryan_practice', 'rating' => 5, 'comment' => 'Persis seperti foto, kualitas mantap. Seller fast response dan packing aman.', 'is_verified' => true],
            ['name' => 'sinta_dewi', 'rating' => 4, 'comment' => 'Sudah order 3x di sini, selalu puas. Barang ori dan pengiriman cepat.', 'is_verified' => true],
            ['name' => 'tommy_padel', 'rating' => 5, 'comment' => 'Kualitasnya jauh di atas ekspektasi. Grip enak, balance oke. Highly recommended!', 'is_verified' => true],
            ['name' => 'umar_faruq', 'rating' => 5, 'comment' => 'Mantap, sesuai deskripsi. Pengiriman same day, packing rapih. Bonus grip juga ada!', 'is_verified' => true],
            ['name' => 'vina_sport', 'rating' => 4, 'comment' => 'Overall bagus, tapi sedikit lama pengirimannya. Kualitas produk tidak mengecewakan.', 'is_verified' => true],
        ];

        $users = User::whereIn('role', ['customer', 'admin'])->pluck('id');
        if ($users->isEmpty()) {
            $users = collect([1]);
        }
        $userIds = $users->values()->all();

        $products = Product::all();
        $totalCreated = 0;

        foreach ($products as $product) {
            $productNameLower = strtolower($product->name);
            $matchedKey = null;

            // Cari match di bankReview
            foreach ($bankReview as $key => $reviews) {
                if (str_contains($productNameLower, $key)) {
                    $matchedKey = $key;
                    break;
                }
            }

            if ($matchedKey !== null) {
                // Produk ada di bankReview → pakai review spesifik
                foreach ($bankReview[$matchedKey] as $r) {
                    Review::create([
                        'product_id'     => $product->id,
                        'user_id'        => $userIds[$totalCreated % count($userIds)],
                        'reviewer_name'  => $r['name'],
                        'order_id'       => null,
                        'rating'         => $r['rating'],
                        'comment'        => $r['comment'],
                        'quality_rating' => 95,
                        'sizing_rating'  => null,
                        'usual_size'     => null,
                        'is_verified'    => $r['is_verified'],
                        'is_approved'    => true,
                        'created_at'     => now()->subDays(rand(1, 90)),
                    ]);
                    $totalCreated++;
                }
            } else {
                // Produk tidak ada di bankReview → pakai 3 review fallback unik per produk
                // Gunakan product->id sebagai offset agar tiap produk dapat review berbeda
                $offset = ($product->id * 3) % count($fallbackPool);
                for ($i = 0; $i < 3; $i++) {
                    $r = $fallbackPool[($offset + $i) % count($fallbackPool)];
                    Review::create([
                        'product_id'     => $product->id,
                        'user_id'        => $userIds[$totalCreated % count($userIds)],
                        'reviewer_name'  => $r['name'],
                        'order_id'       => null,
                        'rating'         => $r['rating'],
                        'comment'        => $r['comment'],
                        'quality_rating' => rand(80, 96),
                        'sizing_rating'  => null,
                        'usual_size'     => null,
                        'is_verified'    => $r['is_verified'],
                        'is_approved'    => true,
                        'created_at'     => now()->subDays(rand(1, 90)),
                    ]);
                    $totalCreated++;
                }
            }
        }

        $this->command->info("Berhasil seed {$totalCreated} reviews untuk {$products->count()} produk.");
    }
}
