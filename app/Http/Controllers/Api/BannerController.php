<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * Get all active banners
     */
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->get();

        $data = $banners->map(function ($banner) {
            return [
                'id' => $banner->id,
                'title' => $banner->title,
                'image' => $banner->image_path ? url('storage/' . $banner->image_path) : null,
                'link_url' => $banner->link_url,
                'created_at' => $banner->created_at?->toISOString(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}
