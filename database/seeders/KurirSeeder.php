<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kurir;

class KurirSeeder extends Seeder
{
    public function run()
    {
        Kurir::create([
            'nama_kurir' => 'Joni Kilat',
            'plat_nomor' => 'D 1234 ABC',
            'no_telp' => '089876543210',
        ]);
    }
}