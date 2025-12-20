<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Kurir;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Ambil data Customer dan Kurir (Pastikan seeder Customer & Kurir sudah dijalankan)
        $cust = Customer::first(); 
        $kurir = Kurir::first();

        if (!$cust) {
            $this->command->info("Data Customer kosong! Jalankan CustomerSeeder dulu.");
            return;
        }

        // --- DATA 1: Dine-in (Makan di tempat, tidak butuh kurir) ---
        // Beli: 2 Robusta Gn. Puntang (20.000 x 2 = 40.000)
        Order::create([
            'tanggal_order'  => Carbon::now()->subDays(3), // 3 hari lalu
            'subtotal_produk' => 40000,
            'ongkir' => 0,
            'biaya_layanan' => 0,
            'total_harga'    => 40000,
            'tipe_pesanan'   => 'pickup',
            'status_pesanan' => 'Selesai',
            'id_cust'        => $cust->id_cust,
            'id_kurir'       => null, // Tidak ada kurir
            'catatan'        => 'Tolong dibuatkan panas',
        ]);

        // --- DATA 2: Delivery (Butuh Kurir) ---
        // Beli: 1 Arabika Gayo Wine (42.000)
        Order::create([
            'tanggal_order'  => Carbon::now()->subDays(1), // Kemarin
            'subtotal_produk' => 42000,
            'ongkir' => 10000,
            'biaya_layanan' => 2000,
            'total_harga'    => 54000,
            'tipe_pesanan'   => 'delivery',
            'status_pesanan' => 'dibatalkan',
            'id_cust'        => $cust->id_cust,
            'id_kurir'       => $kurir ? $kurir->id_kurir : null,
            'catatan'        => null,
        ]);

        // --- DATA 3: Take-away (Bungkus sendiri, tidak butuh kurir) ---
        // Beli: 1 Arabika Flores (25.000) + 1 Arabika Toraja (28.000) = 53.000
        Order::create([
            'tanggal_order'  => Carbon::now(), // Hari ini
            'subtotal_produk' => 53000,
            'ongkir' => 0,
            'biaya_layanan' => 2000,
            'total_harga'    => 55000,
            'tipe_pesanan'   => 'pickup',
            'status_pesanan' => 'selesai',
            'id_cust'        => $cust->id_cust,
            'id_kurir'       => null,
            'catatan'        => 'Gula sedikit, es banyak',
        ]);

        // --- DATA 4: Delivery (Butuh Kurir) dengan Promo ---
        // Beli: 2 Arabika Bali Kintamani (35.000 x 2 = 70.000)
        Order::create([
            'tanggal_order'  => Carbon::now(),
            'subtotal_produk' => 70000,
            'promo_code' => 'KOPI10',
            'promo_discount' => 7000,
            'ongkir' => 10000,
            'biaya_layanan' => 2000,
            'total_harga'    => 75000, // 70000 - 7000 + 10000 + 2000
            'tipe_pesanan'   => 'delivery',
            'status_pesanan' => 'proses',
            'id_cust'        => $cust->id_cust,
            'id_kurir'       => $kurir ? $kurir->id_kurir : null,
            'catatan'        => 'Mohon dikemas rapi, untuk hadiah',
        ]);
    }
}