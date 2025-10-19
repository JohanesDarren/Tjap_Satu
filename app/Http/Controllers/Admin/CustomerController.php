<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // === DATA DUMMY PELANGGAN ===
        $customers = collect([
            [
                'id' => 1,
                'nama' => 'Andi Saputra',
                'email' => 'andi@mail.com',
                'telepon' => '081234567890',
                'orders_count' => 5,
                'total_spent' => 750000,
                'last_order_at' => '2025-10-18 10:00:00',
            ],
            [
                'id' => 2,
                'nama' => 'Budi Hartono',
                'email' => 'budi@mail.com',
                'telepon' => '082345678901',
                'orders_count' => 3,
                'total_spent' => 320000,
                'last_order_at' => '2025-10-17 09:30:00',
            ],
            [
                'id' => 3,
                'nama' => 'Citra Dewi',
                'email' => 'citra@mail.com',
                'telepon' => '083456789012',
                'orders_count' => 7,
                'total_spent' => 980000,
                'last_order_at' => '2025-10-20 14:10:00',
            ],
        ]);

        return view('admin.customers.index', [
            'customers' => $customers,
            'q' => '',
            'from' => '',
            'to' => '',
        ]);
    }

    public function show($id)
    {
        // === DATA DUMMY DETAIL ===
        $customer = [
            'id' => $id,
            'nama' => 'Andi Saputra',
            'email' => 'andi@mail.com',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10, Bandung',
        ];

        // ubah array ke object
        $customer = json_decode(json_encode($customer));

        $summary = [
            'total_orders' => 5,
            'total_spent' => 750000,
            'last_order_at' => '2025-10-18',
        ];

        $chartLabels = ['2025-05','2025-06','2025-07','2025-08','2025-09','2025-10'];
        $chartData   = [120000, 150000, 110000, 180000, 100000, 90000];

        $orders = collect([
            [
                'id' => 101,
                'kode_pesanan' => 'ORD-001',
                'status' => 'Selesai',
                'created_at' => '2025-10-18 10:00:00',
                'total_order' => 150000,
                'items' => [
                    ['produk' => 'Kopi Susu Gula Aren', 'jumlah' => 2, 'harga' => 25000],
                    ['produk' => 'Americano', 'jumlah' => 1, 'harga' => 20000],
                ],
            ],
            [
                'id' => 102,
                'kode_pesanan' => 'ORD-002',
                'status' => 'Selesai',
                'created_at' => '2025-10-12 14:30:00',
                'total_order' => 180000,
                'items' => [
                    ['produk' => 'Cappuccino', 'jumlah' => 3, 'harga' => 30000],
                ],
            ],
        ]);
        

        return view('admin.customers.show', compact('customer', 'summary', 'orders', 'chartLabels', 'chartData'));
    }
}
