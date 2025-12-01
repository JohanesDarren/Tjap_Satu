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


        $cart = Cart::where('id_cust', $customer->id_cust)->first();

        if (!$cart) {
            return view('cart.cart', ['cartItems' => [], 'total' => 0]);
        }

        $cartItems = CartItem::with('product')
                        ->where('id_cart', $cart->id_cart)
                        ->get();

        $total = 0;
        foreach($cartItems as $item) {
            $total += ($item->product->harga * $item->jumlah);
        }

        return view('cart.cart', compact('cartItems', 'total'));
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
