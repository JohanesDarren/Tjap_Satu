<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        // seed dummy di session jika kosong
        if (!session()->has('cms.banners')) {
            session()->put('cms.banners', [
                ['id' => Str::uuid(), 'title' => 'Diskon Spesial Weekend', 'image_url' => 'https://picsum.photos/1200/360?coffee', 'link_url' => '#'],
                ['id' => Str::uuid(), 'title' => 'Signature Kopi Susu', 'image_url' => 'https://picsum.photos/1200/360?beans', 'link_url' => '#'],
            ]);
        }
        if (!session()->has('cms.promos')) {
            session()->put('cms.promos', [
                ['id' => Str::uuid(), 'title' => 'Buy 1 Get 1', 'description' => 'Khusus Jam 14.00-16.00', 'start_date' => now()->toDateString(), 'end_date' => now()->addWeek()->toDateString(), 'active' => true],
            ]);
        }
        if (!session()->has('cms.blogs')) {
            session()->put('cms.blogs', [
                ['id' => Str::uuid(), 'title' => 'Bedanya Arabica vs Robusta', 'excerpt' => 'Singkat soal rasa & kafein.', 'content' => 'Konten dummy tentang kopi.', 'cover_url' => 'https://picsum.photos/640/360?barista', 'published_at' => now()->toDateString()],
            ]);
        }

        return view('admin.content.index', [
            'banners' => session('cms.banners', []),
            'promos'  => session('cms.promos', []),
            'blogs'   => session('cms.blogs', []),
        ]);
    }

    /* ===================== BANNER ===================== */
    public function storeBanner(Request $r)
    {
        $data = $r->validate([
            'title' => 'required|string|max:120',
            'image_url' => 'required|url',
            'link_url' => 'nullable|url',
        ]);
        $banners = session('cms.banners', []);
        $data['id'] = (string) Str::uuid();
        $banners[] = $data;
        session()->put('cms.banners', $banners);
        return back()->with('ok', 'Banner ditambahkan.');
    }

    public function updateBanner(Request $r, $id)
    {
        $data = $r->validate([
            'title' => 'required|string|max:120',
            'image_url' => 'required|url',
            'link_url' => 'nullable|url',
        ]);
        $banners = collect(session('cms.banners', []))->map(function ($b) use ($id, $data) {
            if ($b['id'] === $id) {
                $b['title'] = $data['title'];
                $b['image_url'] = $data['image_url'];
                $b['link_url'] = $data['link_url'] ?? null;
            }
            return $b;
        })->values()->all();
        session()->put('cms.banners', $banners);
        return back()->with('ok', 'Banner diperbarui.');
    }

    public function deleteBanner($id)
    {
        $banners = collect(session('cms.banners', []))
            ->reject(fn($b) => $b['id'] === $id)
            ->values()->all();
        session()->put('cms.banners', $banners);
        return back()->with('ok', 'Banner dihapus.');
    }

    /* ===================== PROMO ===================== */
    public function storePromo(Request $r)
    {
        $data = $r->validate([
            'title' => 'required|string|max:120',
            'description' => 'nullable|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active' => 'nullable|boolean',
        ]);
        $data['active'] = $r->boolean('active');
        $promos = session('cms.promos', []);
        $data['id'] = (string) Str::uuid();
        $promos[] = $data;
        session()->put('cms.promos', $promos);
        return back()->with('ok', 'Promo ditambahkan.');
    }

    public function updatePromo(Request $r, $id)
    {
        $data = $r->validate([
            'title' => 'required|string|max:120',
            'description' => 'nullable|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active' => 'nullable|boolean',
        ]);
        $data['active'] = $r->boolean('active');

        $promos = collect(session('cms.promos', []))->map(function ($p) use ($id, $data) {
            if ($p['id'] === $id) {
                $p = array_merge($p, $data);
            }
            return $p;
        })->values()->all();
        session()->put('cms.promos', $promos);
        return back()->with('ok', 'Promo diperbarui.');
    }

    public function deletePromo($id)
    {
        $promos = collect(session('cms.promos', []))
            ->reject(fn($p) => $p['id'] === $id)
            ->values()->all();
        session()->put('cms.promos', $promos);
        return back()->with('ok', 'Promo dihapus.');
    }

    /* ===================== BLOG ===================== */
    public function storeBlog(Request $r)
    {
        $data = $r->validate([
            'title' => 'required|string|max:160',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'cover_url' => 'nullable|url',
            'published_at' => 'nullable|date',
        ]);
        $blogs = session('cms.blogs', []);
        $data['id'] = (string) Str::uuid();
        $blogs[] = $data;
        session()->put('cms.blogs', $blogs);
        return back()->with('ok', 'Posting blog ditambahkan.');
    }

    public function updateBlog(Request $r, $id)
    {
        $data = $r->validate([
            'title' => 'required|string|max:160',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'cover_url' => 'nullable|url',
            'published_at' => 'nullable|date',
        ]);

        $blogs = collect(session('cms.blogs', []))->map(function ($b) use ($id, $data) {
            if ($b['id'] === $id) {
                $b = array_merge($b, $data);
            }
            return $b;
        })->values()->all();
        session()->put('cms.blogs', $blogs);
        return back()->with('ok', 'Posting blog diperbarui.');
    }

    public function deleteBlog($id)
    {
        $blogs = collect(session('cms.blogs', []))
            ->reject(fn($b) => $b['id'] === $id)
            ->values()->all();
        session()->put('cms.blogs', $blogs);
        return back()->with('ok', 'Posting blog dihapus.');
    }
}
