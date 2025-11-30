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
        $produk = [
            'id_product' => $foundProduk->id_product,
            'nama' => $foundProduk->nama_produk,
            'gambar' => $foundProduk->gambar,
            'harga' => ['100gr' => $foundProduk->harga],
            'deskripsi' => $foundProduk->deskripsi,
            'jenis' => $foundProduk->jenis ?? '-',
            'proses' => $foundProduk->proses ?? '-',
        ];
        return view('produk.detail', ['produk' => $produk]);
    }
}