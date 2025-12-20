<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Tambahkan ini untuk validasi unique
use App\Models\Banner;
use App\Models\Promo;
use App\Models\Blog;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.content.index', [
            'banners' => Banner::latest()->get(),
            'promos'  => Promo::latest()->get(),
            'blogs'   => Blog::latest()->get(),
        ]);
    }

    /* ===================== BANNER (Tidak Berubah) ===================== */
    public function storeBanner(Request $r)
    {
        $data = $r->validate([
            'title' => 'required|string|max:120',
            'image' => 'required|file|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link_url' => 'nullable|url',
        ]);
        $path = $r->file('image')->store('uploads/banners', 'public');
        Banner::create([
            'title' => $data['title'],
            'image_path' => $path,
            'link_url' => $data['link_url'] ?? null,
        ]);
        return back()->with('ok', 'Banner ditambahkan.');
    }

    public function updateBanner(Request $r, Banner $banner)
    {
        $data = $r->validate([
            'title' => 'required|string|max:120',
            'image' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link_url' => 'nullable|url',
        ]);
        if ($r->hasFile('image')) {
            if ($banner->image_path) Storage::disk('public')->delete($banner->image_path);
            $banner->image_path = $r->file('image')->store('uploads/banners', 'public');
        }
        $banner->title = $data['title'];
        $banner->link_url = $data['link_url'] ?? null;
        $banner->save();
        return back()->with('ok', 'Banner diperbarui.');
    }

    public function deleteBanner(Banner $banner)
    {
        if ($banner->image_path) Storage::disk('public')->delete($banner->image_path);
        $banner->delete();
        return back()->with('ok', 'Banner dihapus.');
    }

    /* ===================== PROMO (DIUPDATE) ===================== */
    public function storePromo(Request $r)
    {
        // Validasi input sesuai kolom database
        $data = $r->validate([
            'title'          => 'required|string|max:120',
            'code'           => 'required|string|max:20|unique:promos,code|alpha_num', // Kode harus unik
            'discount_type'  => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase'   => 'nullable|numeric|min:0',
            'max_discount'   => 'nullable|numeric|min:0',
            'description'    => 'nullable|string|max:500',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'active'         => 'nullable',
        ]);

        // Set default 0 jika null
        $data['min_purchase'] = $data['min_purchase'] ?? 0;
        $data['active'] = $r->has('active');

        Promo::create($data);
        return back()->with('ok', 'Promo ditambahkan.');
    }

    public function updatePromo(Request $r, Promo $promo)
    {
        // Validasi input update (pengecekan unique code mengecualikan ID promo ini)
        $data = $r->validate([
            'title'          => 'required|string|max:120',
            'code'           => ['required', 'string', 'max:20', 'alpha_num', Rule::unique('promos', 'code')->ignore($promo->id)],
            'discount_type'  => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase'   => 'nullable|numeric|min:0',
            'max_discount'   => 'nullable|numeric|min:0',
            'description'    => 'nullable|string|max:500',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'active'         => 'nullable',
        ]);

        $promo->fill($data);
        // Pastikan min_purchase default 0 jika dikosongkan
        $promo->min_purchase = $data['min_purchase'] ?? 0;
        // Max discount boleh null
        $promo->max_discount = $data['max_discount'] ?? null;

        $promo->active = $r->has('active');
        $promo->save();
        return back()->with('ok', 'Promo diperbarui.');
    }

    public function deletePromo(Promo $promo)
    {
        $promo->delete();
        return back()->with('ok', 'Promo dihapus.');
    }

    /* ===================== BLOG (Tidak Berubah) ===================== */
    public function storeBlog(Request $r)
    {
        $data = $r->validate([
            'title' => 'required|string|max:160',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'cover' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:2048',
            'published_at' => 'nullable|date',
        ]);
        $path = null;
        if ($r->hasFile('cover')) {
            $path = $r->file('cover')->store('uploads/blogs', 'public');
        }
        Blog::create([
            'title' => $data['title'],
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'],
            'cover_path' => $path,
            'published_at' => $data['published_at'] ?? null,
        ]);
        return back()->with('ok', 'Posting blog ditambahkan.');
    }

    public function updateBlog(Request $r, Blog $blog)
    {
        $data = $r->validate([
            'title' => 'required|string|max:160',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'cover' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:2048',
            'published_at' => 'nullable|date',
        ]);
        if ($r->hasFile('cover')) {
            if ($blog->cover_path) Storage::disk('public')->delete($blog->cover_path);
            $blog->cover_path = $r->file('cover')->store('uploads/blogs', 'public');
        }
        $blog->title = $data['title'];
        $blog->excerpt = $data['excerpt'] ?? null;
        $blog->content = $data['content'];
        $blog->published_at = $data['published_at'] ?? null;
        $blog->save();
        return back()->with('ok', 'Posting blog diperbarui.');
    }

    public function deleteBlog(Blog $blog)
    {
        if ($blog->cover_path) Storage::disk('public')->delete($blog->cover_path);
        $blog->delete();
        return back()->with('ok', 'Posting blog dihapus.');
    }
}
