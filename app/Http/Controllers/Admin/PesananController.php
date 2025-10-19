<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(){
        $pesanan = [
            [
            'id' => 'TJPS-001',
            'nama_pelanggan'=> 'Andi Saputra',
            'tanggal_pesanan' => '2024-08-01',
            'total_harga' => 150000,
            'status' => 'Diproses',
            'items' => [
                ['nama_produk' => 'Toraja Sapan', 'ukuran' => '500gr', 'jumlah' => 1],
            ]
            ],
            [
            'id' => 'TJPS-002',
            'nama_pelanggan'=> 'Budi Saputra',
            'tanggal_pesanan' => '2024-09-01',
            'total_harga' => 100000,
            'status' => 'Pesanan baru',
            'items' => [
                ['nama_produk' => 'Gn. Puntang', 'ukuran' => '200gr', 'jumlah' => 1],
            ]
            ],
            [
            'id' => 'TJPS-003',
            'nama_pelanggan'=> 'Cikal Saputra',
            'tanggal_pesanan' => '2024-10-11',
            'total_harga' => 200000,
            'status' => 'Selesai',
            'items' => [
                ['nama_produk' => 'Gayo(Wine)', 'ukuran' => '100gr', 'jumlah' => 1],
            ]
            ],
            [
            'id' => 'TJPS-004',
            'nama_pelanggan'=> 'Dodi Saputra',
            'tanggal_pesanan' => '2024-12-21',
            'total_harga' => 240000,
            'status' => 'Selesai',
            'items' => [
                ['nama_produk' => 'Bali Kintamani', 'ukuran' => '500gr', 'jumlah' => 1],
            ]
            ],
            
        ];
        return view('admin.admin-pesanan', ['pesanan' => $pesanan]);
    }
}
