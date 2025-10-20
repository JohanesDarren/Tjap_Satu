<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $owners = [
            [
                'name' => 'M. Diaz Bukhori',
                'position' => 'Founder & CEO',
                'image' => 'owner2.jpg',
                'desc' => 'Diaz adalah sosok visioner di balik lahirnya TJAP SATU. Berpengalaman dalam branding dan strategi bisnis, ia berfokus menjadikan kopi sebagai medium yang menyatukan manusia.'
            ],
            [
                'name' => 'Mang Ajangl',
                'position' => 'Co-Founder & CMO',
                'image' => 'owner3.jpg',
                'desc' => 'Mang Ajang memimpin strategi pemasaran kreatif TJAP SATU. Ia memastikan brand selalu hidup dengan storytelling yang kuat experience bagi pelanggan.'
            ],
        ];

        return view('about', compact('owners'));
    }
}
