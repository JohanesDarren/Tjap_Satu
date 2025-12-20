<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get all products with optional filters
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by jenis (category)
        if ($request->has('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by proses
        if ($request->has('proses')) {
            $query->where('proses', $request->proses);
        }

        // Search by nama_produk
        if ($request->has('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // Filter by stok
        if ($request->has('available') && $request->available == 'true') {
            $query->where('stok', '>', 0);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        $data = $products->map(function ($product) {
            return [
                'id' => $product->id_product,
                'nama_produk' => $product->nama_produk,
                'deskripsi' => $product->deskripsi,
                'harga' => (float) $product->harga,
                'stok' => $product->stok,
                'jenis' => $product->jenis,
                'proses' => $product->proses,
                'gambar' => $product->gambar ? url('storage/' . $product->gambar) : null,
                'available' => $product->stok > 0,
                'created_at' => $product->created_at?->toISOString(),
                'updated_at' => $product->updated_at?->toISOString(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ], 200);
    }

    /**
     * Get single product by ID
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id_product,
                'nama_produk' => $product->nama_produk,
                'deskripsi' => $product->deskripsi,
                'harga' => (float) $product->harga,
                'stok' => $product->stok,
                'jenis' => $product->jenis,
                'proses' => $product->proses,
                'gambar' => $product->gambar ? url('storage/' . $product->gambar) : null,
                'available' => $product->stok > 0,
                'created_at' => $product->created_at?->toISOString(),
                'updated_at' => $product->updated_at?->toISOString(),
            ]
        ], 200);
    }

    /**
     * Get products by category (jenis)
     */
    public function byCategory($jenis)
    {
        $products = Product::where('jenis', $jenis)
            ->where('stok', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $data = $products->map(function ($product) {
            return [
                'id' => $product->id_product,
                'nama_produk' => $product->nama_produk,
                'deskripsi' => $product->deskripsi,
                'harga' => (float) $product->harga,
                'stok' => $product->stok,
                'jenis' => $product->jenis,
                'proses' => $product->proses,
                'gambar' => $product->gambar ? url('storage/' . $product->gambar) : null,
                'available' => $product->stok > 0,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'total' => $products->count(),
                'category' => $jenis
            ]
        ], 200);
    }
}
