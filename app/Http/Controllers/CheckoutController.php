<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $selectedItemIds = $request->input('selected_items');

        if (!$selectedItemIds) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu produk.');
        }

        // Ambil data item keranjang yang dipilih
        $checkoutItems = CartItem::with('product')
                            ->whereIn('id_item', $selectedItemIds)
                            ->whereHas('cart', function($query) use ($customer) {
                                $query->where('id_cust', $customer->id_cust);
                            })
                            ->get();

        if ($checkoutItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        // Hitung Subtotal Awal untuk Tampilan
        $subtotal = 0;
        foreach ($checkoutItems as $item) {
            $subtotal += ($item->product->harga * $item->jumlah);
        }

        $ongkir = 10000; // Default view
        $biayaLayanan = 2000;
        $totalBayar = $subtotal + $ongkir + $biayaLayanan;

        return view('checkout.checkout', compact('customer', 'checkoutItems', 'subtotal', 'ongkir', 'biayaLayanan', 'totalBayar'));
    }

    // --- FUNGSI PROSES PEMBAYARAN (INTI) ---
    public function process(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Validasi Input
        $request->validate([
            'items' => 'required|array',
            'shipping_type' => 'required|in:delivery,pickup',
            'payment_method' => 'required|in:qris,transfer,cod',
            'note' => 'nullable|string|max:255',
        ]);

        // Ambil Data Item Keranjang (Validasi lagi biar aman)
        $cartItems = CartItem::with('product')
                        ->whereIn('id_item', $request->items)
                        ->whereHas('cart', function($q) use ($customer) {
                            $q->where('id_cust', $customer->id_cust);
                        })
                        ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pesanan tidak valid.');
        }

        // Hitung Ulang Total
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += ($item->product->harga * $item->jumlah);
        }

        // Logic Ongkir
        $ongkir = ($request->shipping_type == 'delivery') ? 10000 : 0;
        $biayaLayanan = 2000;
        $totalHarga = $subtotal + $ongkir + $biayaLayanan;

        // MULAI TRANSAKSI DATABASE
        try {
            DB::transaction(function () use ($customer, $cartItems, $totalHarga, $request) {
                
                // Buat Data ORDER
                $order = Order::create([
                    'id_cust' => $customer->id_cust,
                    'tanggal_order' => Carbon::now(),
                    'total_harga' => $totalHarga,
                    'tipe_pesanan' => $request->shipping_type,
                    'status_pesanan' => 'proses',
                ]);

                // Buat Data DETAIL ORDER & Kurangi Stok (Opsional)
                foreach ($cartItems as $item) {
                    DetailOrder::create([
                        'id_order' => $order->id_order,
                        'id_product' => $item->id_product,
                        'jumlah' => $item->jumlah,
                        'subtotal' => $item->product->harga * $item->jumlah,
                    ]);
                }

                // Buat Data PAYMENT
                Payment::create([
                    'id_order' => $order->id_order,
                    'metode_bayar' => $request->payment_method,
                    'tanggal_bayar' => Carbon::now(),
                    'status_bayar' => ($request->payment_method == 'cod') ? 'belum_lunas' : 'menunggu_konfirmasi',
                ]);

                // Hapus Item dari KERANJANG
                CartItem::whereIn('id_item', $request->items)->delete();
                
                // (Opsional) Simpan ID Order ke session untuk halaman sukses
                session()->put('last_order_id', $order->id_order);
            });

            // 5. Redirect ke Halaman Sukses
            return redirect()->route('checkout.success');

        } catch (\Exception $e) {
            // Jika ada error database, kembalikan ke checkout dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    // --- HALAMAN SUKSES ---
    public function success()
    {
        if (!session()->has('last_order_id')) {
            return redirect()->route('menu.index');
        }
        
        return view('checkout.checkout_success');
    }

    
}