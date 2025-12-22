<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customer = Customer::first();

        if (!$customer) {
            return;
        }

        $orders = [
            [
                'tanggal_order' => Carbon::now()->subDays(3),
                'subtotal_produk' => 40000,
                'ongkir' => 0,
                'biaya_layanan' => 0,
                'total_harga' => 40000,
                'tipe_pesanan' => 'dine-in',
                'status_pesanan' => 'selesai',
                'id_cust' => $customer->id_cust,
                'catatan' => 'Tolong dibuatkan panas',
            ],
            [
                'tanggal_order' => Carbon::now(),
                'subtotal_produk' => 42000,
                'ongkir' => 10000,
                'biaya_layanan' => 2000,
                'total_harga' => 54000,
                'tipe_pesanan' => 'delivery',
                'status_pesanan' => 'proses',
                'id_cust' => $customer->id_cust,
            ],
        ];

        foreach ($orders as $order) {
            Order::firstOrCreate(
                ['id_cust' => $order['id_cust'], 'tanggal_order' => $order['tanggal_order']],
                $order
            );
        }
    }
}