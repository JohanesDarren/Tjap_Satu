<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Product;

class CartSeeder extends Seeder
{
    public function run()
    {
        // 1. AMBIL DATA CUSTOMER
        // Kita ambil customer pertama (biasanya id_cust 1)
        $customer = Customer::first();

        // Cek dulu apakah ada customer? Kalau tidak ada, stop agar tidak error
        if (!$customer) {
            $this->command->info('⚠️  Tabel Customer kosong! Jalankan CustomerSeeder dulu.');
            return;
        }

        // 2. BUAT KERANJANG (CART)
        // firstOrCreate: Cek dulu apa user ini sudah punya cart? Kalau belum, buat baru.
        $cart = Cart::firstOrCreate(
            ['id_cust' => $customer->id_cust] 
        );

        // 3. AMBIL BEBERAPA PRODUK
        // Kita ambil 3 produk secara acak
        $products = Product::inRandomOrder()->take(3)->get();

        if ($products->isEmpty()) {
            $this->command->info('⚠️  Tabel Product kosong! Jalankan ProductSeeder dulu.');
            return;
        }

        // 4. MASUKKAN PRODUK KE KERANJANG (CART ITEMS)
        foreach ($products as $product) {
            CartItem::create([
                'id_cart'    => $cart->id_cart,
                'id_product' => $product->id_product,
                'jumlah'     => rand(1, 3), // Jumlah acak antara 1 sampai 3
                'catatan'    => 'Contoh catatan seeder', // Opsional
            ]);
        }

        $this->command->info('✅ Berhasil mengisi Keranjang untuk Customer: ' . $customer->nama_lengkap);
    }
}