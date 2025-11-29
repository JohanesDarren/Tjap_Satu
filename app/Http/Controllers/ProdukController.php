<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProdukController extends Controller
{
    public function menu()
    {
        $produk = Product::all();
        return view('produk.menu', ['produk' => $produk]);
    }

    public function show($id)
    {
        $foundProduk = Product::findOrFail($id);
        return view('produk.detail', ['produk' => $foundProduk]);
    }
}