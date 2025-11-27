<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        Customer::create([
            'nama_lengkap' => 'Budi Santoso',
            'alamat' => 'Jl. Kenangan No. 1, Bandung',
            'email' => 'budi@example.com',
            'no_telp' => '081234567890',
            'password' => Hash::make('password123'),
        ]);
    }
}