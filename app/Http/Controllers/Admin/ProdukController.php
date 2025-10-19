<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
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
    
    public function index()
    {
        // Menampilkan halaman utama dengan semua produk
        return view('admin.admin-produk', ['produk' => $this->produk]);
    }

    public function create()
    {
        // Menampilkan form untuk menambah produk baru
        return view('admin.create-produk');
    }

    public function store(Request $request)
    {
        // SIMULASI: Seolah-olah menyimpan data baru
        // Di aplikasi nyata, di sinilah kode untuk menyimpan ke database
        return redirect()->route('admin.produk.index')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Mencari produk untuk diedit (simulasi)
        $produk = collect($this->produk)->firstWhere('id', $id);
        if (!$produk) {
            abort(404);
        }
        // Menampilkan form edit dengan data produk
        return view('admin.edit-produk', ['produk' => $produk]);
    }

    public function update(Request $request, $id)
    {
        // SIMULASI: Seolah-olah memperbarui data
        return redirect()->route('admin.produk.index')->with('success', "Produk dengan ID {$id} berhasil diperbarui!");
    }

    public function destroy($id)
    {
        // SIMULASI: Seolah-olah menghapus data
        return redirect()->route('admin.produk.index')->with('success', "Produk dengan ID {$id} berhasil dihapus!");
    }
}