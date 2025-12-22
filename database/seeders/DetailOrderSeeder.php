<?php

namespace Database\Seeders;

use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DetailOrderSeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::first();
        $products = Product::take(3)->get();

        if (!$order || $products->isEmpty()) {
            return;
        }

        $details = [
            [
                'id_order' => $order->id_order,
                'id_product' => $products[0]->id_product,
                'jumlah' => 2,
                'subtotal' => $products[0]->harga * 2,
            ],
            [
                'id_order' => $order->id_order,
                'id_product' => $products[1]->id_product,
                'jumlah' => 1,
                'subtotal' => $products[1]->harga,
            ],
        ];

        foreach ($details as $detail) {
            DetailOrder::firstOrCreate(
                ['id_order' => $detail['id_order'], 'id_product' => $detail['id_product']],
                $detail
            );
        }
    }
}