<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // simpan data produk sebagai properti kelas sehingga bisa dipakai di semua method
    private $produk = [
        ['id' => 1, 'nama' => 'Gn. Puntang', 'jenis' => 'Robusta', 'proses' => 'Natural', 'harga' => ['100gr' => 20000, '200gr' => 40000, '500gr' => 100000], 'gambar' => 'images/produk2.jpg'],
        ['id' => 2, 'nama' => 'Temanggung', 'jenis' => 'Robusta', 'proses' => 'Natural', 'harga' => ['100gr' => 20000, '200gr' => 40000, '500gr' => 100000], 'gambar' => 'images/produk2.jpg'],
        ['id' => 3, 'nama' => 'Gn. Puntang', 'jenis' => 'Arabika', 'proses' => 'Fullwash', 'harga' => ['100gr' => 25000, '200gr' => 50000, '500gr' => 125000], 'gambar' => 'images/produk2.jpg'],
        ['id' => 4, 'nama' => 'Timor Leste', 'jenis' => 'Arabika', 'proses' => 'Fullwash', 'harga' => ['100gr' => 25000, '200gr' => 50000, '500gr' => 125000], 'gambar' => 'images/produk2.jpg'],
        ['id' => 5, 'nama' => 'Flores Bajawa', 'jenis' => 'Arabika', 'proses' => 'Fullwash', 'harga' => ['100gr' => 25000, '200gr' => 50000, '500gr' => 125000], 'gambar' => 'images/produk2.jpg'],
        ['id' => 6, 'nama' => 'Toraja Sapan', 'jenis' => 'Arabika', 'proses' => 'Semi Wash', 'harga' => ['100gr' => 28000, '200gr' => 56000, '500gr' => 140000], 'gambar' => 'images/produk2.jpg'],
        ['id' => 7, 'nama' => 'Gunung Halu', 'jenis' => 'Arabika', 'proses' => 'Honey Banana', 'harga' => ['100gr' => 32000, '200gr' => 64000, '500gr' => 160000], 'gambar' => 'images/produk2.jpg'],
        ['id' => 8, 'nama' => 'Kerinci', 'jenis' => 'Arabika', 'proses' => 'Natural', 'harga' => ['100gr' => 32000, '200gr' => 64000, '500gr' => 160000], 'gambar' => 'images/produk2.jpg'],
        ['id' => 9, 'nama' => 'Gunung Tilu', 'jenis' => 'Arabika', 'proses' => 'Natural', 'harga' => ['100gr' => 32000, '200gr' => 64000, '500gr' => 160000], 'gambar' => 'images/produk2.jpg'],
        ['id' => 10, 'nama' => 'Bali Kintamani', 'jenis' => 'Arabika', 'proses' => 'Natural', 'harga' => ['100gr' => 35000, '200gr' => 70000, '500gr' => 175000], 'gambar' => 'images/produk2.jpg'],
        ['id' => 11, 'nama' => 'Gn. Puntang', 'jenis' => 'Arabika', 'proses' => 'Natural Anaerob', 'harga' => ['100gr' => 35000, '200gr' => 70000, '500gr' => 175000], 'gambar' => 'images/produk2.jpg'],
        ['id' => 12, 'nama' => 'Gayo', 'jenis' => 'Arabika', 'proses' => 'Wine', 'harga' => ['100gr' => 42000, '200gr' => 84000, '500gr' => 210000], 'gambar' => 'images/produk2.jpg'],
    ];

    public function menu(){
        return view('produk.menu', ['produk' => $this->produk]);
    }

    public function show($id){
        $filtered = array_filter($this->produk, function ($produk) use ($id) {
            return $produk['id'] == $id;
        });

        if (empty($filtered)) {
            abort(404);
        }

        $foundProduk = reset($filtered);
        return view('produk.detail', ['produk' => $foundProduk]);
    }

    public function showOrderForm($id)
    {
        $produkToOrder = null;
        $filtered = array_filter($this->produk, function ($produk) use ($id) {
            return $produk['id'] == $id;
        });

        if (!empty($filtered)) {
            $produkToOrder = reset($filtered);
        } else {
            abort(404);
        }

        // Kirim data produk yang akan dipesan ke view 'order'
        return view('produk.order', ['produk' => $produkToOrder]);
    }
}