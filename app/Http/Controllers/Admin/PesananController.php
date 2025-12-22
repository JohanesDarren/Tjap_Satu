<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PesananController extends Controller
{
    public function index(): View
    {
        $pesanan = Order::with(['customer', 'detailOrders.product'])
            ->orderBy('tanggal_order', 'desc')
            ->paginate(20);

        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status_pesanan' => 'required|in:pending,proses,dikirim,selesai,dibatalkan',
        ]);

        $order->update($validated);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function show(int $id): View
    {
        $pesanan = Order::with(['customer', 'detailOrders.product'])
            ->findOrFail($id);

        return view('admin.pesanan.show', compact('pesanan'));
    }
}