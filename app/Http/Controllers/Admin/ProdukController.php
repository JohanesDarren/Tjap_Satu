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
    
    public function index(){
        return view('admin.admin-produk', ['produk' => $this->produk]);
    }

    public function create(){
        return view('admin.create-produk');
    }

    public function store(Request $request){
        return redirect()->route('admin.produk.index')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function edit($id){
        $found = collect($this->produk)->firstWhere('id', (int) $id);
        if(!$found) abort(404);
        return view('admin.edit-produk', ['produk' => $found]);
    }

    public function update(Request $request, $id){
        return redirect()->route('admin.produk.index')->with('success', "Produk dengan ID {$id} berhasil diperbarui!");
    }

    public function destroy($id){
        return redirect()->route('admin.produk.index')->with('success', "Produk dengan ID {$id} berhasil dihapus!");
    }
}