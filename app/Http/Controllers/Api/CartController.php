<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Get user's cart
     */
    public function index(Request $request)
    {
        $customer = $request->user();
        
        $cart = Cart::with(['items.product'])
            ->where('id_cust', $customer->id_cust)
            ->first();

        if (!$cart) {
            return response()->json([
                'success' => true,
                'data' => [
                    'items' => [],
                    'total' => 0,
                    'count' => 0
                ]
            ], 200);
        }

        $items = $cart->items->map(function ($item) {
            return [
                'id' => $item->id_item,
                'product' => [
                    'id' => $item->product->id_product,
                    'nama_produk' => $item->product->nama_produk,
                    'harga' => (float) $item->product->harga,
                    'gambar' => $item->product->gambar ? url('storage/' . $item->product->gambar) : null,
                    'stok' => $item->product->stok,
                ],
                'quantity' => $item->jumlah,
                'subtotal' => (float) ($item->jumlah * $item->product->harga),
            ];
        });

        $total = $items->sum('subtotal');

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $items,
                'total' => $total,
                'count' => $items->count()
            ]
        ], 200);
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_product' => 'required|exists:product,id_product',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = $request->user();
        $product = Product::find($request->id_product);

        // Check stock
        if ($product->stok < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ], 400);
        }

        // Get or create cart
        $cart = Cart::firstOrCreate(
            ['id_cust' => $customer->id_cust]
        );

        // Check if item already exists in cart
        $cartItem = CartItem::where('id_cart', $cart->id_cart)
            ->where('id_product', $request->id_product)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->jumlah + $request->quantity;
            
            if ($product->stok < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock for the requested quantity'
                ], 400);
            }

            $cartItem->jumlah = $newQuantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'id_cart' => $cart->id_cart,
                'id_product' => $request->id_product,
                'jumlah' => $request->quantity,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'data' => [
                'id' => $cartItem->id_item,
                'quantity' => $cartItem->jumlah,
            ]
        ], 201);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = $request->user();
        $cart = Cart::where('id_cust', $customer->id_cust)->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found'
            ], 404);
        }

        $cartItem = CartItem::where('id_cart', $cart->id_cart)
            ->where('id_item', $id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $product = $cartItem->product;

        if ($product->stok < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ], 400);
        }

        $cartItem->jumlah = $request->quantity;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'data' => [
                'id' => $cartItem->id_item,
                'quantity' => $cartItem->jumlah,
            ]
        ], 200);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request, $id)
    {
        $customer = $request->user();
        $cart = Cart::where('id_cust', $customer->id_cust)->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found'
            ], 404);
        }

        $cartItem = CartItem::where('id_cart', $cart->id_cart)
            ->where('id_item', $id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart'
        ], 200);
    }

    /**
     * Clear entire cart
     */
    public function clear(Request $request)
    {
        $customer = $request->user();
        $cart = Cart::where('id_cust', $customer->id_cust)->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared'
        ], 200);
    }
}
