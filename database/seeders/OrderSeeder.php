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
            'total_harga'    => 40000,
            'tipe_pesanan'   => 'Take-away',
            'status_pesanan' => 'Selesai',
            'id_cust'        => $cust->id_cust,
            'id_kurir'       => null, // Tidak ada kurir
        ]);

        // --- DATA 2: Delivery (Butuh Kurir) ---
        // Beli: 1 Arabika Gayo Wine (42.000)
        Order::create([
            'tanggal_order'  => Carbon::now()->subDays(1), // Kemarin
            'total_harga'    => 42000,
            'tipe_pesanan'   => 'Delivery',
            'status_pesanan' => 'dibatalkan', // Sedang diantar
            'id_cust'        => $cust->id_cust,
            'id_kurir'       => $kurir ? $kurir->id_kurir : null,
        ]);

        // --- DATA 3: Take-away (Bungkus sendiri, tidak butuh kurir) ---
        // Beli: 1 Arabika Flores (25.000) + 1 Arabika Toraja (28.000) = 53.000
        Order::create([
            'tanggal_order'  => Carbon::now(), // Hari ini
            'total_harga'    => 53000,
            'tipe_pesanan'   => 'Take-away',
            'status_pesanan' => 'selesai', // Baru pesan
            'id_cust'        => $cust->id_cust,
            'id_kurir'       => null,
        ]);

        // --- DATA 4: Delivery (Butuh Kurir) ---
        // Beli: 2 Arabika Bali Kintamani (35.000 x 2 = 70.000)
        Order::create([
            'tanggal_order'  => Carbon::now(),
            'total_harga'    => 70000,
            'tipe_pesanan'   => 'Delivery',
            'status_pesanan' => 'proses',
            'id_cust'        => $cust->id_cust,
            'id_kurir'       => $kurir ? $kurir->id_kurir : null,
        ]);
    }
}