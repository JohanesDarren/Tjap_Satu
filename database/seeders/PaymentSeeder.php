<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Order;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        // Ambil Order pertama
        $order = Order::first();

        if ($order) {
            Payment::create([
                'id_order' => $order->id_order,
                'metode_bayar' => 'QRIS',
                'tanggal_bayar' => Carbon::now(),
                'status_bayar' => 'Lunas',
            ]);
        }
    }
}