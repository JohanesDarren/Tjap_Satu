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
        // Ambil data Customer pertama yang ada di database
        $cust = Customer::first();
        
        // Ambil data Kurir pertama
        $kurir = Kurir::first();

        // Pastikan data ada sebelum membuat order untuk menghindari error
        if ($cust && $kurir) {
            Order::create([
                'tanggal_order' => Carbon::now(),
                'total_harga' => 51000,
                'tipe_pesanan' => 'Delivery',
                'status_pesanan' => 'Proses',
                'id_cust' => $cust->id_cust,
                'id_kurir' => $kurir->id_kurir,
            ]);
        }
    }
}