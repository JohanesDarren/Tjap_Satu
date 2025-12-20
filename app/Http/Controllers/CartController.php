<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Promo;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();


        $cart = Cart::where('id_cust', $customer->id_cust)->first();

        if (!$cart) {
            return view('cart.cart', ['cartItems' => [], 'total' => 0, 'appliedPromo' => null, 'discount' => 0, 'availablePromos' => collect()]);
        }

        $cartItems = CartItem::with('product')
                        ->where('id_cart', $cart->id_cart)
                        ->get();

        $total = 0;
        foreach($cartItems as $item) {
            $total += ($item->product->harga * $item->jumlah);
        }

        // Ambil semua promo aktif
        $availablePromos = Promo::where('active', true)
                                ->where('start_date', '<=', now())
                                ->where('end_date', '>=', now())
                                ->orderBy('discount_value', 'desc')
                                ->get();

        // Ambil promo dari session jika ada
        $appliedPromo = null;
        $discount = 0;
        
        if (session()->has('applied_promo')) {
            $promoCode = session('applied_promo');
            $promo = Promo::where('code', $promoCode)->first();
            
            if ($promo && $promo->isValid($total)) {
                $appliedPromo = $promo;
                $discount = $promo->calculateDiscount($total);
            } else {
                // Hapus promo dari session jika tidak valid
                session()->forget('applied_promo');
            }
        }

        return view('cart.cart', compact('cartItems', 'total', 'appliedPromo', 'discount', 'availablePromos'));
    }

    // Validasi dan terapkan promo
    public function applyPromo(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string'
        ]);

        $customer = Auth::guard('customer')->user();
        $cart = Cart::where('id_cust', $customer->id_cust)->first();

        if (!$cart) {
            return redirect()->back()->with('promo_error', 'Keranjang kosong');
        }

        // Hitung total
        $cartItems = CartItem::with('product')
                        ->where('id_cart', $cart->id_cart)
                        ->get();
        $total = 0;
        foreach($cartItems as $item) {
            $total += ($item->product->harga * $item->jumlah);
        }

        // Cari promo
        $promo = Promo::where('code', strtoupper($request->promo_code))->first();

        if (!$promo) {
            return redirect()->back()->with('promo_error', 'Kode promo tidak ditemukan');
        }

        if (!$promo->isValid($total)) {
            if (!$promo->active) {
                return redirect()->back()->with('promo_error', 'Kode promo tidak aktif');
            } elseif ($total < $promo->min_purchase) {
                return redirect()->back()->with('promo_error', 'Minimal pembelian Rp ' . number_format($promo->min_purchase, 0, ',', '.'));
            } else {
                return redirect()->back()->with('promo_error', 'Kode promo sudah kadaluarsa');
            }
        }

        // Simpan promo ke session
        session(['applied_promo' => $promo->code]);

        return redirect()->back()->with('promo_success', 'Promo berhasil diterapkan!');
    }

    // Hapus promo
    public function removePromo()
    {
        session()->forget('applied_promo');
        return redirect()->back()->with('success', 'Promo dihapus');
    }

    public function addToCart(Request $request, $id_product)
    {
        $customer = Auth::guard('customer')->user();

        $qty = (int) $request->input('jumlah', 1);
        if ($qty < 1) { $qty = 1; }

        $cart = Cart::firstOrCreate(['id_cust' => $customer->id_cust]);

        $existingItem = CartItem::where('id_cart', $cart->id_cart)
                                ->where('id_product', $id_product)
                                ->first();

        if ($existingItem) {
            $existingItem->jumlah += $qty;
            $existingItem->save();
        } else {
            CartItem::create([
                'id_cart' => $cart->id_cart,
                'id_product' => $id_product,
                'jumlah' => $qty,
                'catatan' => null
            ]);
        }

        return redirect()->back()->with('success', 'Produk masuk keranjang!');
    }

    public function deleteItem($id_item)
    {
        CartItem::destroy($id_item);
        return redirect()->back()->with('success', 'Item dihapus.');
    }

    public function updateQuantity($id_item, $action)
    {
        $item = CartItem::findOrFail($id_item);

        if ($action == 'plus') {
            $item->jumlah += 1;
        } elseif ($action == 'minus') {
            $item->jumlah -= 1;
            if ($item->jumlah < 1) {
                $item->delete();
                return redirect()->back();
            }
        }

        $item->save();
        return redirect()->back();
    }
}
