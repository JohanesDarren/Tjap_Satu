<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Data dummy produk kopi
        $cartItems = [
            [
                'id' => 1,
                'name' => 'Gn. Puntang - Natural/100gr',
                'price' => 20000,
                'quantity' => 1,
                'image' => 'images/bijiKopi.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Flores Bajawa - Full Wash/100gr',
                'price' => 25000,
                'quantity' => 1,
                'image' => 'images/bijiKopi.jpg'
            ],
        ];

        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));

        return view('cart', compact('cartItems', 'total'));
    }
}
