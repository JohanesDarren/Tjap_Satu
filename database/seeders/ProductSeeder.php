<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'nama_produk' => 'Kopi Susu Tjap Satu',
            'deskripsi' => 'Kopi susu gula aren khas Tjap Satu',
            'harga' => 18000,
            'stok' => 50,
            'gambar' => 'kopi_susu.jpg',
        ]);
        
        Product::create([
            'nama_produk' => 'Americano',
            'deskripsi' => 'Kopi hitam tanpa gula',
            'harga' => 15000,
            'stok' => 40,
            'gambar' => 'americano.jpg',
        ]);
    }
}