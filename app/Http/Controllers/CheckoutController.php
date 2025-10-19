<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    // Menampilkan halaman checkout
    public function index()
    {
        $cartItems = [
    [
        'name' => 'Gn. Puntang',
        'description' => "Natural",
        'satuan' => '100gr',
        'price' => 20000,
        'quantity' => 1,
        'image' => '/images/bijiKopi.jpg' // path image
    ]
        ];
        $subtotal = 20000;
        $shippingCost = 15000;


        return view('checkout', compact('cartItems', 'subtotal', 'shippingCost'));
    }

    // Proses checkout
    public function process(Request $request)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'address' => 'required|string',
            'shipping_method' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Simpan data order ke database (contoh)
        // Order::create([...]);

        // Kosongkan cart
        Session::forget('cart');

        return redirect()->route('checkout.success')->with('success', 'Pesanan berhasil diproses!');
    }

    // Halaman sukses
    public function success()
    {
        return view('checkout-success');
    }
}
