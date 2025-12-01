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

        Customer::updateOrCreate(
            ['email' => 'admin@tjapsatu.com'],
            [
                'nama_lengkap' => 'Administrator',
                'alamat' => 'Jl. Admin Utama',
                'no_telp' => '080000000000',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );
    }
}
