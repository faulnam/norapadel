<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Key langsung pake potongan nama asli produk
        $bankReview = [
            'max protector' => [
                [
                    'name' => 'athena_shigen',
                    'rating' => 5,
                    'comment' => 'Raket jadi aman, bahan gel tebal terproteksi maksimal sampai ke samping.',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'mudhanovia84',
                    'rating' => 5,
                    'comment' => "Pengiriman cepat walaupun saat order statusnya pre order\nMantab sih dapat harga murah",
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'wilson overgrip perforated' => [
                [
                    'name' => 'trizkiawawaw',
                    'rating' => 5,
                    'comment' => 'Enak dipakai untuk dobel dg grip asli, tidak terlalu tebal, nyaman digenggam',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'slava8899',
                    'rating' => 5,
                    'comment' => 'Kualitas bagus 👍. Terima kasih',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'overgrip wilson racket padel' => [
                [
                    'name' => 'arvinsetiawan79',
                    'rating' => 5,
                    'comment' => 'Sesuai dengan kualitas, recommended seller',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'nox nerbo speed balls' => [
                [
                    'name' => 'yudhadara18',
                    'rating' => 5,
                    'comment' => 'Mantap pengiriman cepet , warbyasak',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'nox equation hard' => [
                [
                    'name' => 'widi_kendhi',
                    'rating' => 5,
                    'comment' => 'Sellernya baik banget....T O P pokoknya',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'nox equation soft' => [
                [
                    'name' => 'derichteha',
                    'rating' => 5,
                    'comment' => 'pengiriman sangat cepat, seller nya baik banget,, next klo order pasti disini lagiii',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'nox calzado ml10 hexa blue/silver' => [
                [
                    'name' => 'alamnh',
                    'rating' => 5,
                    'comment' => 'Cuakepop pollll',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'nox x - one casual' => [
                [
                    'name' => 'carlosardo',
                    'rating' => 5,
                    'comment' => 'Raket padle nya bagus',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'babolat technical viper 2024' => [
                [
                    'name' => 'filgi',
                    'rating' => 5,
                    'comment' => 'Barang sampai dengan aman, best pelayanan, makasih jugaaa udah di kasih bonus handgrip+protector🙏🏻',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'gandhigo',
                    'rating' => 5,
                    'comment' => 'Cepat delivery dan sesuai permintaan. Free overgrip dan protector rackethead',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'babolat technical viper 2025' => [
                [
                    'name' => 'srikandi_32',
                    'rating' => 5,
                    'comment' => 'Harga termurah dibanding online store lain maupun toko offline',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'babolat counter viper 2025' => [
                [
                    'name' => 'ryo_siregar',
                    'rating' => 5,
                    'comment' => 'carbon cukup keras, untuk smash mantap. finishing cat raket nya glossy tapi ada permukaan kasar sampai ke bagian samping raket nya',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'babolat air viper 2025' => [
                [
                    'name' => 'pleat_pleats',
                    'rating' => 5,
                    'comment' => 'Bagus dan keren\nPengiriman juga cepat same day delivery\nRekomen untuk beli dsini',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'karimnazri',
                    'rating' => 5,
                    'comment' => 'beli raket yg kedua kalinya di toko ini, dan dapat bonus banyak, auto langsung dipake maen wkwk',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'raksepatu.idn',
                    'rating' => 5,
                    'comment' => 'Cocok untuk pemain net. Placing ball accurate.\nKalibrasi new racket cepet karena easy to use but power dapet banget',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'bullpadel indiga women 2026' => [
                [
                    'name' => 'carlosardo',
                    'rating' => 5,
                    'comment' => 'Raketnya bagus dan ringan',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'bullpadel vertex 05 woman 2026' => [
                [
                    'name' => 'meryfu89',
                    'rating' => 5,
                    'comment' => 'bagus untuk yg butuh power dan ringan. original',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'bullpadel vertex 04 2025' => [
                [
                    'name' => 'rangganisa2431',
                    'rating' => 5,
                    'comment' => 'Dari build quality, pas diterima ditangan feelnya berasa original, keren!\nH-1 lebaran dikirim juga dan sampe di lebaran kedua',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'bullpadel vertex 04 hybrid 2025 raket padel' => [
                [
                    'name' => 'luzasby',
                    'rating' => 5,
                    'comment' => 'sellernya ramah powl, suabar meskipun nanyak ini itu dan fast respon',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'serasishop',
                    'rating' => 5,
                    'comment' => 'Pertama kali beli di Nora Padel. Sebelum beli sdh research cr bedakan raket asli dan palsu. Syukurnya dr nora padel ini ORIGINAL.\nEh dpt banyak freebies lagi...',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'bullpadel vertex 04 racket 2024' => [
                [
                    'name' => 'alfhyshop',
                    'rating' => 5,
                    'comment' => 'Mantap bagus banyak bonus nya juga .. seller nya juga enak bisa konsultasi buat pilih mana raket semua pertanyaan saya di jawab degan jelas.🙏',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'bullpadel bag paleteros pro line bpp26022' => [
                [
                    'name' => 'jason_nathan',
                    'rating' => 5,
                    'comment' => 'Packing aman, pengiriman cepat ntar di upload lagi setelah grip nya di pasang, thank you..',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'bullpadel xplo 25' => [
                [
                    'name' => 'hanry.tanto',
                    'rating' => 5,
                    'comment' => 'Keren sih…\nGak nyesel belinya…\nBagus, packaging aman, dikasi bonus grip nya juga…\nTerima kasih!!!',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'onartroy2000',
                    'rating' => 5,
                    'comment' => 'Barang ori 100%, pelayanan cepat.. Makasih',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'vanalbert88',
                    'rating' => 5,
                    'comment' => 'Recomend seller.. 👍🏽👍🏽👍🏽👍🏽\nBarang nya asli Original..\nTrusted seller ...',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'edge guard strip white leather' => [
                [
                    'name' => 'tokomimi18',
                    'rating' => 5,
                    'comment' => 'Tq seller sdh kedua kalinya order disini murah trs cepet juga, kirim instan langsung sampe. Bisa langsung di pake buat main padel sat set bgt… semoga semakin di perbanyak model2 raketnya',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'hanry.tanto',
                    'rating' => 5,
                    'comment' => 'Free protector buat raketnya…\nSimpel biasa sih transparan…\nYg penting bisa melindungi..\nMakasi',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'diahkaruniasari',
                    'rating' => 5,
                    'comment' => 'Yeay maaci bonusannya wrna pink pulan mntep deh luv skali ❤️🫶🩷',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'head zephyr pro blue black' => [
                [
                    'name' => 'putraadhik',
                    'rating' => 5,
                    'comment' => 'Mudah2an awet',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'alpha play blue black' => [
                [
                    'name' => 'carlosardo',
                    'rating' => 5,
                    'comment' => 'Raketnya bagus dan ringan',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'alpha game blue yellow' => [
                [
                    'name' => 'rendypastya',
                    'rating' => 5,
                    'comment' => 'Seller fast respon dan bisa memeberi rekomendasi, dan banyak hadiahhnyaaa, toko rekomended banget, good joob good seller 🥰',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'alpha padel ball' => [
                [
                    'name' => 'taufiqardiputra',
                    'rating' => 5,
                    'comment' => 'Sesuai',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'alpha padel vibe' => [
                [
                    'name' => 'taufiqardiputra',
                    'rating' => 5,
                    'comment' => 'Sesuai',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'hesacore arronax' => [
                [
                    'name' => 'ronnyrenaldy291',
                    'rating' => 5,
                    'comment' => 'Pas banget',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'pro spin strip' => [
                [
                    'name' => 'anissugeng',
                    'rating' => 5,
                    'comment' => 'Kemasannya aman banget. Barang perfect condition',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'ayu_andini2104',
                    'rating' => 5,
                    'comment' => 'Produknya sampai dengan aman. Order kemarin pagi, skrg sudah datang. Kemasan rapih',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ],
                [
                    'name' => 'mariam_fatimah',
                    'rating' => 5,
                    'comment' => 'Bahan berkualitas, produk original, pengiriman cepat. Makasi min🥰',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]

            ],
            'alpha kinesiology' => [
                [
                    'name' => 'iyz_236',
                    'rating' => 5,
                    'comment' => 'Mantappp raketny .. ORI 1000prsen',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
            'tambahan packing box' => [
                [
                    'name' => 'derichteha',
                    'rating' => 5,
                    'comment' => 'pengiriman sangat cepat, seller nya baik banget,, next klo order pasti disini lagiii',
                    'quality_rating' => 95,
                    'sizing_rating' => null,
                    'usual_size' => null,
                    'is_verified' => true
                ]
            ],
        ];
        

        // Ambil semua produk dari DB
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            $productNameLower = strtolower($product->name);
            $matchedKey = null;

            // Loop untuk cek apakah nama produk di DB mengandung salah satu key dari bankReview
            foreach ($bankReview as $key => $reviews) {
                if (str_contains($productNameLower, $key)) {
                    $matchedKey = $key;
                    break; // Keluar dari loop internal jika sudah ketemu yang cocok
                }
            }

            // Kalau tidak ada yang cocok di bankReview, skip ke produk selanjutnya

            
            if ($matchedKey === null) {
                            continue;
                        }
                        

            // Ambil review berdasarkan key yang cocok
            $reviews = $bankReview[$matchedKey];

            foreach ($reviews as $r) {
                $cleanedName = trim($r['name']); 

                DB::table('reviews')->insert([
                    'product_id'      => $product->id, 
                    'user_id'         => 2,
                    'reviewer_name'   => $cleanedName,       // Nama asli reviewer tetap muncul sesuai datamu (widi_kendhi, dll)
                    'order_id'        => null, 
                    'rating'          => $r['rating'],
                    'comment'         => $r['comment'],
                    
                    // Antisipasi eror tanda tanya (?) di rating fisik
                    'quality_rating'  => is_numeric($r['quality_rating'] ?? null) ? $r['quality_rating'] : null,
                    'sizing_rating'   => is_numeric($r['sizing_rating'] ?? null) ? $r['sizing_rating'] : null,
                    'usual_size'      => ($r['usual_size'] !== '?') ? ($r['usual_size'] ?? null) : null,
                    
                    'is_verified'     => $r['is_verified'] ?? 1, 
                    'is_approved'     => 1, 
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }
    }
}
