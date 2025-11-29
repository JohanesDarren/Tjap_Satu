<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        // 1. Ambil Keranjang milik user login
        $cart = Cart::where('id_cust', $customer->id_cust)->first();

        // 2. Jika belum punya keranjang, kita kirim array kosong
        if (!$cart) {
            return view('cart.cart', ['cartItems' => [], 'total' => 0]);
        }

        // 3. Ambil Item Keranjang + Data Produknya (Eager Loading)
        $cartItems = CartItem::with('product')
                        ->where('id_cart', $cart->id_cart)
                        ->get();

        // 4. Hitung Total Harga
        $total = 0;
        foreach($cartItems as $item) {
            $total += ($item->product->harga * $item->jumlah);
        }

        return view('cart.cart', compact('cartItems', 'total'));
    }

    // Logic Tambah ke Keranjang (Dipanggil dari Menu)
    public function addToCart(Request $request, $id_product)
    {
        $customer = Auth::guard('customer')->user();

        // 1. Cek / Buat Keranjang Utama
        $cart = Cart::firstOrCreate(['id_cust' => $customer->id_cust]);

        // 2. Cek apakah produk sudah ada di keranjang?
        $existingItem = CartItem::where('id_cart', $cart->id_cart)
                                ->where('id_product', $id_product)
                                ->first();

        if ($existingItem) {
            // Jika ada, tambah jumlahnya
            $existingItem->jumlah += 1;
            $existingItem->save();
        } else {
            // Jika belum, buat baru
            CartItem::create([
                'id_cart' => $cart->id_cart,
                'id_product' => $id_product,
                'jumlah' => 1,
                'catatan' => null
            ]);
        }

        return redirect()->back()->with('success', 'Produk masuk keranjang!');
    }

    // Logic Hapus Item
    public function deleteItem($id_item)
    {
        CartItem::destroy($id_item);
        return redirect()->back()->with('success', 'Item dihapus.');
    }

    // Logic Tambah/Kurang Qty di Halaman Cart
    public function updateQuantity($id_item, $action)
    {
        $item = CartItem::findOrFail($id_item);

        if ($action == 'plus') {
            $item->jumlah += 1;
        } elseif ($action == 'minus') {
            $item->jumlah -= 1;
            // Jika jumlah jadi 0, hapus item
            if ($item->jumlah < 1) {
                $item->delete();
                return redirect()->back();
            }
        }

        $item->save();
        return redirect()->back();
    }
}