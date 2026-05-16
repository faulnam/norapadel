<?php

namespace Database\Seeders;

use App\Models\Voucher;
use App\Models\User;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?: User::first();

        if (!$admin) {
            $this->command->warn('No admin user found. Skipping voucher seeder.');
            return;
        }

        $vouchers = [
            [
                'title' => 'Diskon Rp10.000',
                'slug' => 'diskon-rp-10-000',
                'code' => 'VOU-DISC10',
                'description' => 'Dapatkan diskon Rp10.000 untuk pembelian minimum Rp200.000',
                'type' => 'fixed',
                'discount_value' => 10000.00,
                'minimum_purchase' => 200000.00,
                'maximum_discount' => null,
                'cashback_coin' => 0,
                'quota' => 100,
                'used' => 0,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'thumbnail' => null,
                'is_active' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Diskon 20%',
                'slug' => 'diskon-20-persen',
                'code' => 'VOU-20PER',
                'description' => 'Dapatkan diskon 20% hingga Rp50.000 untuk pembelian minimum Rp200.000',
                'type' => 'percent',
                'discount_value' => 20.00,
                'minimum_purchase' => 200000.00,
                'maximum_discount' => 50000.00,
                'cashback_coin' => 0,
                'quota' => 50,
                'used' => 0,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'thumbnail' => null,
                'is_active' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Cashback 100 Coin',
                'slug' => 'cashback-100-coin',
                'code' => 'VOU-CASH100',
                'description' => 'Dapatkan 100 coin untuk pembelian minimum Rp150.000',
                'type' => 'cashback',
                'discount_value' => 0.00,
                'minimum_purchase' => 150000.00,
                'maximum_discount' => null,
                'cashback_coin' => 100,
                'quota' => 30,
                'used' => 0,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'thumbnail' => null,
                'is_active' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Diskon Rp50.000',
                'slug' => 'diskon-rp-50-000',
                'code' => 'VOU-DISC50',
                'description' => 'Dapatkan diskon Rp50.000 untuk pembelian minimum Rp500.000',
                'type' => 'fixed',
                'discount_value' => 50000.00,
                'minimum_purchase' => 500000.00,
                'maximum_discount' => null,
                'cashback_coin' => 0,
                'quota' => 20,
                'used' => 0,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'thumbnail' => null,
                'is_active' => true,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::updateOrCreate(
                ['code' => $voucher['code']],
                $voucher
            );
        }

        $this->command->info('Vouchers seeded successfully!');
    }
}
