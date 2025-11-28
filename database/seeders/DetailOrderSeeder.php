<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Product;

class DetailOrderSeeder extends Seeder
{
    public function run()
    {
        // Mengambil 4 Order Terakhir yang baru saja dibuat oleh OrderSeeder
        // Urutan: Data 4 (Index 0), Data 3 (Index 1), Data 2 (Index 2), Data 1 (Index 3) karena DESC
        $orders = Order::orderBy('id_order', 'desc')->take(4)->get();

        // Pastikan ada minimal 4 order
        if ($orders->count() < 4) {
            $this->command->info("Data Order kurang dari 4. Jalankan OrderSeeder dulu.");
            return;
        }

        // --- Ambil Produk untuk referensi ID ---
        // Menggunakan LIKE agar pencarian nama lebih fleksibel sesuai data di ProductSeeder
        $p_robusta_puntang = Product::where('nama_produk', 'like', '%Robusta Gn. Puntang%')->first();
        $p_gayo = Product::where('nama_produk', 'like', '%Gayo%')->first();
        $p_flores = Product::where('nama_produk', 'like', '%Flores%')->first();
        $p_toraja = Product::where('nama_produk', 'like', '%Toraja%')->first();
        $p_bali = Product::where('nama_produk', 'like', '%Bali%')->first();

        // --- ISI DETAIL ORDER ---

        // 1. Untuk Order DATA 4 (Delivery - Total 70.000)
        // Item: 2 Arabika Bali (35rb x 2)
        if ($p_bali) {
            DetailOrder::create([
                'id_order'   => $orders[0]->id_order, // Order terakhir (paling baru)
                'id_product' => $p_bali->id_product,
                'jumlah'     => 2,
                'subtotal'   => 70000,
            ]);
        }

        // 2. Untuk Order DATA 3 (Take-away - Total 53.000)
        // Item A: 1 Arabika Flores (25rb)
        if ($p_flores) {
            DetailOrder::create([
                'id_order'   => $orders[1]->id_order,
                'id_product' => $p_flores->id_product,
                'jumlah'     => 1,
                'subtotal'   => 25000,
            ]);
        }
        // Item B: 1 Arabika Toraja (28rb)
        if ($p_toraja) {
            DetailOrder::create([
                'id_order'   => $orders[1]->id_order, // ID Order yang sama dengan atas
                'id_product' => $p_toraja->id_product,
                'jumlah'     => 1,
                'subtotal'   => 28000,
            ]);
        }

        // 3. Untuk Order DATA 2 (Delivery - Total 42.000)
        // Item: 1 Arabika Gayo Wine (42rb)
        if ($p_gayo) {
            DetailOrder::create([
                'id_order'   => $orders[2]->id_order,
                'id_product' => $p_gayo->id_product,
                'jumlah'     => 1,
                'subtotal'   => 42000,
            ]);
        }

        // 4. Untuk Order DATA 1 (Dine-in - Total 40.000)
        // Item: 2 Robusta Gn Puntang (20rb x 2)
        if ($p_robusta_puntang) {
            DetailOrder::create([
                'id_order'   => $orders[3]->id_order,
                'id_product' => $p_robusta_puntang->id_product,
                'jumlah'     => 2,
                'subtotal'   => 40000,
            ]);
        }
    }
}