<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index(): View
    {
        $produk = Product::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.produk.index', compact('produk'));
    }

    public function create(): View
    {
        return view('admin.produk.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255|unique:product,nama_produk',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'required|string|min:10',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'jenis' => 'nullable|string|max:100',
            'proses' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = uniqid('produk_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $validated['gambar'] = $filename;
        }

        Product::create($validated);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(int $id): View
    {
        $produk = Product::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $produk = Product::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255|unique:product,nama_produk,' . $id . ',id_product',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'required|string|min:10',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'jenis' => 'nullable|string|max:100',
            'proses' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && file_exists(public_path('uploads/' . $produk->gambar))) {
                unlink(public_path('uploads/' . $produk->gambar));
            }
            $file = $request->file('gambar');
            $filename = uniqid('produk_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $validated['gambar'] = $filename;
        }

        $produk->update($validated);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $produk = Product::findOrFail($id);
        
        if ($produk->gambar && file_exists(public_path('uploads/' . $produk->gambar))) {
            unlink(public_path('uploads/' . $produk->gambar));
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
