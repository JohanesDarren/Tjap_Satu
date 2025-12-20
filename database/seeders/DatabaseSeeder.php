<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Panggil seeder lain secara berurutan
        // Urutan PENTING agar tidak error foreign key
        $this->call([
            CustomerSeeder::class,
            KurirSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            DetailOrderSeeder::class,
            PaymentSeeder::class,
            CartSeeder::class,
            PromoSeeder::class,
        ]);
    }
}
