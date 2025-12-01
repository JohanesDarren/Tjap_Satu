<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Pastikan Model Product sudah ada
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    // Menampilkan semua produk (READ)
    public function index()
    {
        $produk = Product::all(); // Mengambil dari database
        return view('admin.produk.index', compact('produk'));
    }

    // Menampilkan form tambah (CREATE)
    public function create()
    {
        return view('admin.produk.create');
    }

    // Menyimpan produk baru ke database (STORE)
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'deskripsi'   => 'required|string',
            'gambar'      => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib upload gambar
        ]);

        // Upload ke public/uploads dan simpan hanya filename
        $filename = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $ext = $file->getClientOriginalExtension();
            $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safe = Str::slug($base);
            $filename = uniqid($safe . '_') . '.' . $ext;
            $file->move(public_path('uploads'), $filename);
        }

        // 3. Simpan Data
        Product::create([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $filename
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form edit (EDIT)
    public function edit($id)
    {
        $produk = Product::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }

    // Update data ke database (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'deskripsi'   => 'required',
            'gambar'      => 'nullable|image|max:2048', // Gambar boleh kosong saat update
        ]);

        $produk = Product::findOrFail($id);
        $data = $request->except('gambar');

        // Cek jika user mengupload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama (dukung dua skema penyimpanan lama/baru)
            if ($produk->gambar) {
                if (Str::startsWith($produk->gambar, 'products/') && Storage::disk('public')->exists($produk->gambar)) {
                    Storage::disk('public')->delete($produk->gambar);
                } elseif (file_exists(public_path('uploads/' . $produk->gambar))) {
                    @unlink(public_path('uploads/' . $produk->gambar));
                }
            }

            // Simpan gambar baru ke public/uploads dengan filename saja
            $file = $request->file('gambar');
            $ext = $file->getClientOriginalExtension();
            $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safe = Str::slug($base);
            $newName = uniqid($safe . '_') . '.' . $ext;
            $file->move(public_path('uploads'), $newName);
            $data['gambar'] = $newName;
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Hapus data (DELETE)
    public function destroy($id)
    {
        $produk = Product::findOrFail($id);
        
        // Hapus gambar fisik
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        } elseif (file_exists(public_path('uploads/' . $produk->gambar))) {
            @unlink(public_path('uploads/' . $produk->gambar));
        }

        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}