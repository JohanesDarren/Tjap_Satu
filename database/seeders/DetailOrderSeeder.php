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
        // Ambil Order pertama/terbaru
        $order = Order::first();

        // Ambil Produk berdasarkan nama agar ID-nya tepat
        $prod1 = Product::where('nama_produk', 'Kopi Susu Tjap Satu')->first();
        $prod2 = Product::where('nama_produk', 'Americano')->first();

        if ($order && $prod1 && $prod2) {
            DetailOrder::create([
                'id_order' => $order->id_order,
                'id_product' => $prod1->id_product,
                'jumlah' => 2,
                'subtotal' => 36000,
            ]);

            DetailOrder::create([
                'id_order' => $order->id_order,
                'id_product' => $prod2->id_product,
                'jumlah' => 1,
                'subtotal' => 15000,
            ]);
        }
    }
}