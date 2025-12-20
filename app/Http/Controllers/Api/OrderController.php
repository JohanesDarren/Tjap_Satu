<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Get user's orders
     */
    public function index(Request $request)
    {
        $customer = $request->user();
        
        $query = Order::with(['detailOrders.product', 'kurir', 'payment'])
            ->where('id_cust', $customer->id_cust);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status_pesanan', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $data = $orders->map(function ($order) {
            return [
                'id' => $order->id_order,
                'tanggal_order' => $order->tanggal_order,
                'tipe_pesanan' => $order->tipe_pesanan,
                'status_pesanan' => $order->status_pesanan,
                'subtotal_produk' => (float) $order->subtotal_produk,
                'ongkir' => (float) ($order->ongkir ?? 0),
                'biaya_layanan' => (float) ($order->biaya_layanan ?? 0),
                'promo_discount' => (float) ($order->promo_discount ?? 0),
                'promo_code' => $order->promo_code,
                'total_harga' => (float) $order->total_harga,
                'catatan' => $order->catatan,
                'kurir' => $order->kurir ? [
                    'id' => $order->kurir->id_kurir,
                    'nama' => $order->kurir->nama,
                ] : null,
                'items_count' => $order->detailOrders->count(),
                'payment_status' => $order->payment ? $order->payment->status_bayar : null,
                'created_at' => $order->created_at?->toISOString(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    /**
     * Get single order details
     */
    public function show(Request $request, $id)
    {
        $customer = $request->user();
        
        $order = Order::with(['detailOrders.product', 'kurir', 'payment'])
            ->where('id_order', $id)
            ->where('id_cust', $customer->id_cust)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $items = $order->detailOrders->map(function ($detail) {
            return [
                'id' => $detail->id_detord,
                'product' => [
                    'id' => $detail->product->id_product,
                    'nama_produk' => $detail->product->nama_produk,
                    'gambar' => $detail->product->gambar ? url('storage/' . $detail->product->gambar) : null,
                ],
                'jumlah' => $detail->jumlah,
                'harga_satuan' => (float) $detail->harga_satuan,
                'subtotal' => (float) $detail->subtotal,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $order->id_order,
                'tanggal_order' => $order->tanggal_order,
                'tipe_pesanan' => $order->tipe_pesanan,
                'status_pesanan' => $order->status_pesanan,
                'subtotal_produk' => (float) $order->subtotal_produk,
                'ongkir' => (float) ($order->ongkir ?? 0),
                'biaya_layanan' => (float) ($order->biaya_layanan ?? 0),
                'promo_discount' => (float) ($order->promo_discount ?? 0),
                'promo_code' => $order->promo_code,
                'total_harga' => (float) $order->total_harga,
                'catatan' => $order->catatan,
                'kurir' => $order->kurir ? [
                    'id' => $order->kurir->id_kurir,
                    'nama' => $order->kurir->nama,
                    'no_telp' => $order->kurir->no_telp,
                ] : null,
                'items' => $items,
                'payment' => $order->payment ? [
                    'id' => $order->payment->id_payment,
                    'metode_bayar' => $order->payment->metode_bayar,
                    'status_bayar' => $order->payment->status_bayar,
                    'bukti_pembayaran' => $order->payment->bukti_pembayaran ? url('storage/' . $order->payment->bukti_pembayaran) : null,
                ] : null,
                'created_at' => $order->created_at?->toISOString(),
                'updated_at' => $order->updated_at?->toISOString(),
            ]
        ], 200);
    }

    /**
     * Create new order from cart
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipe_pesanan' => 'required|in:dine-in,take-away,delivery',
            'id_kurir' => 'nullable|exists:kurir,id_kurir',
            'promo_code' => 'nullable|string',
            'catatan' => 'nullable|string',
            'metode_bayar' => 'required|in:transfer,cash,e-wallet',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = $request->user();
        
        // Get cart
        $cart = Cart::with('items.product')
            ->where('id_cust', $customer->id_cust)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Calculate subtotal
            $subtotal = 0;
            foreach ($cart->items as $item) {
                // Check stock
                if ($item->product->stok < $item->jumlah) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient stock for ' . $item->product->nama_produk
                    ], 400);
                }
                $subtotal += $item->product->harga * $item->jumlah;
            }

            // Calculate ongkir
            $ongkir = 0;
            if ($request->tipe_pesanan === 'delivery' && $request->id_kurir) {
                $kurir = \App\Models\Kurir::find($request->id_kurir);
                $ongkir = $kurir ? 15000 : 10000; // Use default 15000 or fallback to 10000
            }

            // Calculate biaya layanan
            $biayaLayanan = $subtotal * 0.01; // 1% service fee

            // Apply promo if exists
            $promoDiscount = 0;
            $promoCode = null;
            if ($request->promo_code) {
                $promo = Promo::where('code', $request->promo_code)->first();
                if ($promo && $promo->isValid($subtotal)) {
                    $promoCode = $request->promo_code;
                    if ($promo->discount_type === 'percentage') {
                        $promoDiscount = ($subtotal * $promo->discount_value) / 100;
                        if ($promo->max_discount && $promoDiscount > $promo->max_discount) {
                            $promoDiscount = $promo->max_discount;
                        }
                    } else {
                        $promoDiscount = $promo->discount_value;
                    }
                }
            }

            // Calculate total
            $total = $subtotal + $ongkir + $biayaLayanan - $promoDiscount;

            // Create order
            $order = Order::create([
                'tanggal_order' => now(),
                'total_harga' => $total,
                'tipe_pesanan' => $request->tipe_pesanan,
                'status_pesanan' => 'pending',
                'id_cust' => $customer->id_cust,
                'id_kurir' => $request->id_kurir,
                'promo_code' => $promoCode,
                'promo_discount' => $promoDiscount,
                'catatan' => $request->catatan,
                'subtotal_produk' => $subtotal,
                'ongkir' => $ongkir,
                'biaya_layanan' => $biayaLayanan,
            ]);

            // Create order details and update stock
            foreach ($cart->items as $item) {
                DetailOrder::create([
                    'id_order' => $order->id_order,
                    'id_product' => $item->id_product,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->product->harga,
                    'subtotal' => $item->product->harga * $item->jumlah,
                ]);

                // Update stock
                $item->product->decrement('stok', $item->jumlah);
            }

            // Create payment record
            Payment::create([
                'id_order' => $order->id_order,
                'metode_bayar' => $request->metode_bayar,
                'status_bayar' => 'pending',
                'tanggal_bayar' => null,
            ]);

            // Clear only specific cart items if provided
            if ($request->has('cart_item_ids') && !empty($request->cart_item_ids)) {
                $cart->items()->whereIn('id_item', $request->cart_item_ids)->delete();
            } else {
                // Clear all cart items if no specific items provided
                if ($request->has('cart_item_ids') && !empty($request->cart_item_ids)) { $cart->items()->whereIn('id_item', $request->cart_item_ids)->delete(); } else { $cart->items()->delete(); }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'id_order' => $order->id_order,
                    'total_harga' => (float) $order->total_harga,
                    'status_pesanan' => $order->status_pesanan,
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel order
     */
    public function cancel(Request $request, $id)
    {
        $customer = $request->user();
        
        $order = Order::where('id_order', $id)
            ->where('id_cust', $customer->id_cust)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!in_array($order->status_pesanan, ['pending', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Order cannot be cancelled'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Restore stock
            foreach ($order->detailOrders as $detail) {
                $detail->product->increment('stok', $detail->jumlah);
            }

            $order->status_pesanan = 'cancelled';
            $order->save();

            if ($order->payment) {
                $order->payment->status_bayar = 'cancelled';
                $order->payment->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload payment proof
     */
    public function uploadPayment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = $request->user();
        
        $order = Order::with('payment')
            ->where('id_order', $id)
            ->where('id_cust', $customer->id_cust)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment record not found'
            ], 404);
        }

        try {
            $file = $request->file('bukti_pembayaran');
            $filename = 'payment_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payments', $filename, 'public');

            $order->payment->bukti_pembayaran = $path;
            $order->payment->status_bayar = 'waiting_confirmation';
            $order->payment->save();

            return response()->json([
                'success' => true,
                'message' => 'Payment proof uploaded successfully',
                'data' => [
                    'bukti_pembayaran' => url('storage/' . $path)
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload payment proof',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}



