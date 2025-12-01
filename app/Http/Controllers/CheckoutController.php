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

        $checkoutItems = CartItem::with('product')
                            ->whereIn('id_item', $selectedItemIds)
                            ->whereHas('cart', function($query) use ($customer) {
                                $query->where('id_cust', $customer->id_cust);
                            })
                            ->get();

        if ($checkoutItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $subtotal = 0;
        foreach ($checkoutItems as $item) {
            $subtotal += ($item->product->harga * $item->jumlah);
        }

        $ongkir = 10000;
        $biayaLayanan = 2000;
        $totalBayar = $subtotal + $ongkir + $biayaLayanan;

        return view('checkout.checkout', compact('customer', 'checkoutItems', 'subtotal', 'ongkir', 'biayaLayanan', 'totalBayar'));
    }

    public function process(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'items' => 'required|array',
            'shipping_type' => 'required|in:delivery,pickup',
            'payment_method' => 'required|in:qris,transfer,cod',
            'note' => 'nullable|string|max:255',
        ]);

        $cartItems = CartItem::with('product')
                        ->whereIn('id_item', $request->items)
                        ->whereHas('cart', function($q) use ($customer) {
                            $q->where('id_cust', $customer->id_cust);
                        })
                        ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pesanan tidak valid.');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += ($item->product->harga * $item->jumlah);
        }

        $ongkir = ($request->shipping_type == 'delivery') ? 10000 : 0;
        $biayaLayanan = 2000;
        $totalHarga = $subtotal + $ongkir + $biayaLayanan;

        try {
            DB::transaction(function () use ($customer, $cartItems, $totalHarga, $request) {
                
                $order = Order::create([
                    'id_cust' => $customer->id_cust,
                    'tanggal_order' => Carbon::now(),
                    'total_harga' => $totalHarga,
                    'tipe_pesanan' => $request->shipping_type,
                    'status_pesanan' => 'proses',
                ]);

                foreach ($cartItems as $item) {
                    DetailOrder::create([
                        'id_order' => $order->id_order,
                        'id_product' => $item->id_product,
                        'jumlah' => $item->jumlah,
                        'subtotal' => $item->product->harga * $item->jumlah,
                    ]);
                }

                Payment::create([
                    'id_order' => $order->id_order,
                    'metode_bayar' => $request->payment_method,
                    'tanggal_bayar' => Carbon::now(),
                    'status_bayar' => ($request->payment_method == 'cod') ? 'belum_lunas' : 'menunggu_konfirmasi',
                ]);

                CartItem::whereIn('id_item', $request->items)->delete();
                
                session()->put('last_order_id', $order->id_order);
            });

            return redirect()->route('checkout.success');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    public function success()
    {
        if (!session()->has('last_order_id')) {
            return redirect()->route('menu.index');
        }
        
        return view('checkout.checkout_success');
    }

    
}