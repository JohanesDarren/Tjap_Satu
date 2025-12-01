<?php

namespace App\Http\Controllers;

use App\Models\Product;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil data produk untuk strip (duplikasi di view untuk efek marquee)
        $stripProducts = Product::orderByDesc('created_at')->take(8)->get();
        // Ambil data produk untuk daftar menu
        $products = Product::orderByDesc('created_at')->take(6)->get();

        return view('landing.index', compact('stripProducts', 'products'));
    }
}
