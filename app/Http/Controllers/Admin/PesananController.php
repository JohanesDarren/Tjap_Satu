<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Order::with(['detailOrders.product', 'customer'])
                        ->orderBy('tanggal_order', 'desc')
                        ->get();
        
        return view('admin.pesanan.index', ['pesanan' => $pesanan]);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status_pesanan' => 'required|in:Pending,Diproses,Dikirim,Selesai,Batal'
        ]);

        $order->status_pesanan = $request->status_pesanan;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}