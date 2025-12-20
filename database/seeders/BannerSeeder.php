<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing banners
        DB::table('banners')->truncate();

        $banners = [
            [
                'title' => 'Promo - Diskon 25%',
                'image_path' => 'images/biji.JPG',
                'link_url' => '/promos/ramadan-sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kopi Arabica Premium',
                'image_path' => 'images/heroes.JPG',
                'link_url' => '/products?jenis=arabica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'New Arrival - Robusta Toraja',
                'image_path' => 'images/about.webp',
                'link_url' => '/products/robusta-toraja',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }

        $this->command->info('Banners table seeded successfully!');
    }
}
