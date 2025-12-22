<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Display product menu listing
     */
    public function menu(): View
    {
        $produk = Product::orderBy('created_at', 'desc')->get();
        return view('produk.menu', compact('produk'));
    }

    /**
     * Display single product detail
     */
    public function show(int $id): View
    {
        $produk = Product::findOrFail($id);
        return view('produk.detail', compact('produk'));
    }
}