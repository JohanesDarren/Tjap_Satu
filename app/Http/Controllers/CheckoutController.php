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


}
