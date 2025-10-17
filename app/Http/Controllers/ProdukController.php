<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ProdukController extends Controller
{
        private $produk = [
            ['id' => 101, 'nama' => 'Gunung Puntang', 'harga'=> 25000, 'deskripsi' => 'Fullwash'],
            ['id' => 102, 'nama' => 'Timor Leste', 'harga'=> 25000, 'deskripsi' => 'Fullwash' ],
            ['id' => 103, 'nama' => 'Flores Bajawa', 'harga'=> 25000, 'deskripsi' => 'Fullwash' ],
            ['id' => 104, 'nama' => 'Toraja Sapan', 'harga'=> 28000, 'deskripsi' => 'Semi-wash' ],
            ['id' => 105, 'nama' => 'Gunung Halu', 'harga'=> 32000, 'deskripsi' => 'Honey Banana' ]
        ];
    public function index(){
        return view('produk.index', ['produk' => $this->produk]);
    }
    public function show($id){
        $cariProduk;
        foreach($this->produk as $produk){
            if ($produk['id'] == $id){
                $cariProduk = $produk;
                break;
            }
        }
        if(!$cariProduk){
            abort(404);
        }
        return view('produk.show', ['produk' => $cariProduk]);
    }
}
?>