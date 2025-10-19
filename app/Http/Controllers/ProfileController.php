<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
{
    $profile = [
        'first_name' => 'Afrisya',
        'last_name' => 'Dwiky',
        'email' => 'afrisya@example.com',
        'phone' => '08123456789',
        'city' => 'Karawang',
        'state' => 'Jawa Barat',
        'postcode' => '41373',
        'country' => 'Indonesia',
        'avatar' => 'images/owner1.jpg'
    ];

    $orders = [
        [
            'id' => 'ORD001',
            'produk' => 'Gn. Puntang Natural',
            'tanggal' => '15 Okt 2025',
            'status' => 'Selesai',
            'total' => 'Rp120.000',
            'gambar' => 'images/bijiKopi.jpg'
        ],
        [
            'id' => 'ORD002',
            'produk' => 'Flores Bajawa Fullwash',
            'tanggal' => '10 Okt 2025',
            'status' => 'Dikirim',
            'total' => 'Rp85.000',
            'gambar' => 'images/bijiKopi.jpg'
        ],
        [
            'id' => 'ORD003',
            'produk' => 'Gunung Tilu Natural',
            'tanggal' => '05 Okt 2025',
            'status' => 'Diproses',
            'total' => 'Rp60.000',
            'gambar' => 'images/bijiKopi.jpg'
        ],
    ];

    return view('profile', compact('profile', 'orders'));
}

}
