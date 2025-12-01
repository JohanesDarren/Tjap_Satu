<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Daftar Data dari Menu (Harga 100gr)
        // Semua gambar diset ke 'images/bijiKopi.JPG'
        $products = [
            // --- Kategori ROBUSTA ---
            [
                'nama_produk' => 'Robusta Gn. Puntang - Natural (100gr)',
                'deskripsi'   => 'Kopi Robusta asli Gunung Puntang dengan proses Natural. Notes: Strong body, chocolatey.',
                'harga'       => 20000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Robusta',
                'proses'      => 'Natural',
            ],
            [
                'nama_produk' => 'Robusta Temanggung - Natural (100gr)',
                'deskripsi'   => 'Kopi Robusta Temanggung proses Natural. Notes: Bold, nutty, caramel.',
                'harga'       => 20000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Robusta',
                'proses'      => 'Natural',
            ],

            // --- Kategori ARABIKA ---
            [
                'nama_produk' => 'Arabika Gn. Puntang - Fullwash (100gr)',
                'deskripsi'   => 'Kopi Arabika Gunung Puntang proses Fullwash. Notes: Clean cup, acidity balanced.',
                'harga'       => 25000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Arabika',
                'proses'      => 'Fullwash',
            ],
            [
                'nama_produk' => 'Arabika Timor Leste - Fullwash (100gr)',
                'deskripsi'   => 'Kopi Arabika Timor Leste proses Fullwash. Notes: Herbal, spicy, mild acidity.',
                'harga'       => 25000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Arabika',
                'proses'      => 'Fullwash',
            ],
            [
                'nama_produk' => 'Arabika Flores Bajawa - Fullwash (100gr)',
                'deskripsi'   => 'Kopi Arabika Flores Bajawa proses Fullwash. Notes: Chocolate, floral, woody.',
                'harga'       => 25000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Arabika',
                'proses'      => 'Fullwash',
            ],
            [
                'nama_produk' => 'Arabika Toraja Sapan - Semi Wash (100gr)',
                'deskripsi'   => 'Kopi Arabika Toraja Sapan proses Semi Wash. Notes: Earthy, spices, dark chocolate.',
                'harga'       => 28000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Arabika',
                'proses'      => 'Semi Wash',
            ],
            [
                'nama_produk' => 'Arabika Gunung Halu - Honey Banana (100gr)',
                'deskripsi'   => 'Kopi Arabika Gunung Halu proses Honey Banana. Notes: Sweet fruity like banana, smooth body.',
                'harga'       => 32000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Arabika',
                'proses'      => 'Honey Banana',
            ],
            [
                'nama_produk' => 'Arabika Kerinci - Natural (100gr)',
                'deskripsi'   => 'Kopi Arabika Kerinci proses Natural. Notes: Fruity, spicy, sweet aftertaste.',
                'harga'       => 32000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Arabika',
                'proses'      => 'Natural',
            ],
            [
                'nama_produk' => 'Arabika Gunung Tilu - Natural (100gr)',
                'deskripsi'   => 'Kopi Arabika Gunung Tilu proses Natural. Notes: Bright acidity, floral, citrus.',
                'harga'       => 32000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Arabika',
                'proses'      => 'Natural',
            ],
            [
                'nama_produk' => 'Arabika Bali Kintamani - Natural (100gr)',
                'deskripsi'   => 'Kopi Arabika Bali Kintamani proses Natural. Notes: Citrusy orange, fresh acidity.',
                'harga'       => 35000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Arabika',
                'proses'      => 'Natural',
            ],
            [
                'nama_produk' => 'Arabika Gn. Puntang - Natural Anaerob (100gr)',
                'deskripsi'   => 'Kopi Arabika Gunung Puntang proses Natural Anaerob. Notes: Complex fruity, winey, intense sweetness.',
                'harga'       => 35000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Arabika',
                'proses'      => 'Natural Anaerob',
            ],
            [
                'nama_produk' => 'Arabika Gayo - Wine (100gr)',
                'deskripsi'   => 'Kopi Arabika Gayo proses Wine. Notes: Strong fermented fruit, winey, bold body.',
                'harga'       => 42000,
                'gambar'      => 'bijiKopi.JPG',
                'jenis'       => 'Arabika',
                'proses'      => 'Wine',
            ],
        ];

        // Looping data untuk dimasukkan ke database
        foreach ($products as $item) {
            Product::create([
                'nama_produk' => $item['nama_produk'],
                'deskripsi'   => $item['deskripsi'],
                'harga'       => $item['harga'],
                'stok'        => 50, // Stok default diset 50 pcs
                'gambar'      => $item['gambar'],
                'jenis'       => $item['jenis'] ?? null,
                'proses'      => $item['proses'] ?? null,
            ]);
        }
    }
}
