<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    public function index()
    {
        $hero = [
            'headline' => 'Mari Menyeduh Cerita di Seluruh Bandung',
            'sub'      => 'Jadilah bagian dari perjalanan kopi nomor satu — TJAP SATU.',
            'video'    => 'videos/buatkopi.mp4',
        ];

        $bestSellers = [
            ['title'=>'Kopi Susu Tjap 1','price'=>19000,'img'=>'images/biji.JPG','slug'=>'kopi-susu-tjap1','badge'=>'Signature','desc'=>'Blend house, creamy & bold.'],
            ['title'=>'Americano Nusantara','price'=>21000,'img'=>'images/biji.JPG','slug'=>'americano-nusantara','badge'=>'Best Seller','desc'=>'Single origin pilihan.'],
            ['title'=>'Cold Brew Citrus','price'=>23000,'img'=>'images/biji.JPG','slug'=>'cold-brew-citrus','badge'=>null,'desc'=>'Segar dengan hint jeruk.'],
            ['title'=>'Tumbler Edisi Khusus','price'=>99000,'img'=>'images/biji.JPG','slug'=>'tumbler-edisi-khusus','badge'=>'Merch','desc'=>'Stainless, 500ml.'],
        ];

        $usps = [
            'Kolaborasi dengan petani lokal',
            'Prinsip keberlanjutan',
            'Kurasi rasa berkualitas',
        ];

        $stores = [
            ['name'=>'Bintaro Sektor 2','addr'=>'Jl. …','img'=>'images/biji.JPG','map'=>'#'],
            ['name'=>'Pasar Santa','addr'=>'Jl. …','img'=>'images/biji.JPG','map'=>'#'],
            ['name'=>'BSD','addr'=>'Jl. …','img'=>'images/biji.JPG','map'=>'#'],
        ];

        $testimonials = [
            ['name'=>'Raka, Bandung','quote'=>'Kopi susu Tjap1 selalu jadi andalan.'],
            ['name'=>'Mira, Tangerang','quote'=>'Cold brew citrus-nya segar banget.'],
        ];

        return view('landing.index', compact('hero','bestSellers','usps','stores','testimonials'));
    }
}