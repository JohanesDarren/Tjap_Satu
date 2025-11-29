<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Order::with(['detailOrders.product'])
                        ->orderBy('tanggal_order', 'desc')
                        ->get();
        
        return view('admin.admin-pesanan', ['pesanan' => $pesanan]);
    }
}