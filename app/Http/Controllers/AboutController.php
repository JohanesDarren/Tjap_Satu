<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $owners = [
            [
                'name' => 'Refo Ongko Songo',
                'position' => 'Founder & CEO',
                'image' => 'owner1.jpg',
                'desc' => 'Refo adalah sosok visioner di balik lahirnya TJAP SATU. Berpengalaman dalam branding dan strategi bisnis, ia berfokus menjadikan kopi sebagai medium yang menyatukan manusia dan cerita mereka.'
            ],
            [
                'name' => 'Ferdian Rama',
                'position' => 'Co-Founder & CMO',
                'image' => 'owner2.jpg',
                'desc' => 'Ferdian memimpin strategi pemasaran kreatif TJAP SATU. Ia memastikan brand selalu hidup dengan storytelling yang kuat dan meaningful experience bagi pelanggan.'
            ],
            [
                'name' => 'Fahrjin Revandi',
                'position' => 'Co-Founder & COO',
                'image' => 'owner1.jpg',
                'desc' => 'Fahrjin bertanggung jawab atas operasional utama TJAP SATU. Dengan pengalaman dalam hospitality dan manajemen, ia menjaga kualitas layanan dan konsistensi cita rasa.'
            ],
            [
                'name' => 'Albi Fernanda',
                'position' => 'Co-Founder & COO',
                'image' => 'owner1.jpg',
                'desc' => 'Albi memimpin pengalaman pelanggan dengan pendekatan hangat dan autentik. Ia percaya bahwa pelayanan berkualitas adalah kunci membangun loyalitas pelanggan.'
            ],
        ];

        return view('about', compact('owners'));
    }
}
