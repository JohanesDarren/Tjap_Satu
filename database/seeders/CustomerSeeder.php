<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        Customer::updateOrCreate(
            ['email' => 'budi@example.com'], // unique key criteria
            [
                'nama_lengkap' => 'Budi Santoso',
                'alamat' => 'Jl. Kenangan No. 1, Bandung',
                'no_telp' => '081234567890',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
