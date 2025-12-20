<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promo;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        Promo::create([
            'code' => 'KOPI10',
            'title' => 'Diskon 10%',
            'description' => 'Diskon 10% untuk pembelian minimal Rp 50.000',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'min_purchase' => 50000,
            'max_discount' => 20000,
            'start_date' => $now->copy()->subDays(5),
            'end_date' => $now->copy()->addDays(30),
            'active' => true,
        ]);

        Promo::create([
            'code' => 'KOPIMURAH',
            'title' => 'Potongan Rp 15.000',
            'description' => 'Potongan langsung Rp 15.000 untuk pembelian minimal Rp 100.000',
            'discount_type' => 'fixed',
            'discount_value' => 15000,
            'min_purchase' => 100000,
            'max_discount' => null,
            'start_date' => $now->copy()->subDays(3),
            'end_date' => $now->copy()->addDays(20),
            'active' => true,
        ]);

        Promo::create([
            'code' => 'MEMBER20',
            'title' => 'Diskon Member 20%',
            'description' => 'Diskon 20% untuk member, maksimal diskon Rp 50.000',
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'min_purchase' => 75000,
            'max_discount' => 50000,
            'start_date' => $now->copy()->subDays(10),
            'end_date' => $now->copy()->addDays(60),
            'active' => true,
        ]);

        Promo::create([
            'code' => 'WELCOME',
            'title' => 'Selamat Datang',
            'description' => 'Diskon 5% untuk pelanggan baru',
            'discount_type' => 'percentage',
            'discount_value' => 5,
            'min_purchase' => 30000,
            'max_discount' => 10000,
            'start_date' => $now->copy()->subDays(1),
            'end_date' => $now->copy()->addDays(90),
            'active' => true,
        ]);
    }
}
