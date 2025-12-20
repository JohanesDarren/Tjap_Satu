<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Get all promos
     */
    public function index()
    {
        $promos = Promo::orderBy('created_at', 'desc')->get();

        $data = $promos->map(function ($promo) {
            return [
                'id' => $promo->id,
                'code' => $promo->code,
                'title' => $promo->title,
                'description' => $promo->description,
                'discount_type' => $promo->discount_type,
                'discount_value' => (float) $promo->discount_value,
                'min_purchase' => (float) $promo->min_purchase,
                'max_discount' => (float) ($promo->max_discount ?? 0),
                'start_date' => $promo->start_date?->toDateString(),
                'end_date' => $promo->end_date?->toDateString(),
                'active' => $promo->active,
                'is_valid' => $promo->isValid(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    /**
     * Get only active and valid promos
     */
    public function activePromos()
    {
        $promos = Promo::where('active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->get();

        $data = $promos->map(function ($promo) {
            return [
                'id' => $promo->id,
                'code' => $promo->code,
                'title' => $promo->title,
                'description' => $promo->description,
                'discount_type' => $promo->discount_type,
                'discount_value' => (float) $promo->discount_value,
                'min_purchase' => (float) $promo->min_purchase,
                'max_discount' => (float) ($promo->max_discount ?? 0),
                'start_date' => $promo->start_date?->toDateString(),
                'end_date' => $promo->end_date?->toDateString(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    /**
     * Validate promo code and calculate discount
     */
    public function validatePromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'total_belanja' => 'required|numeric|min:0',
        ]);

        $promo = Promo::where('code', $request->code)->first();

        if (!$promo) {
            return response()->json([
                'success' => false,
                'message' => 'Promo code not found'
            ], 404);
        }

        if (!$promo->isValid($request->total_belanja)) {
            $reasons = [];
            
            if (!$promo->active) {
                $reasons[] = 'Promo is not active';
            }
            
            if (now()->lt($promo->start_date)) {
                $reasons[] = 'Promo has not started yet';
            }
            
            if (now()->gt($promo->end_date)) {
                $reasons[] = 'Promo has expired';
            }
            
            if ($request->total_belanja < $promo->min_purchase) {
                $reasons[] = 'Minimum purchase of Rp ' . number_format($promo->min_purchase, 0, ',', '.') . ' required';
            }

            return response()->json([
                'success' => false,
                'message' => 'Promo code is not valid',
                'reasons' => $reasons
            ], 400);
        }

        // Calculate discount
        $discount = 0;
        if ($promo->discount_type === 'percentage') {
            $discount = ($request->total_belanja * $promo->discount_value) / 100;
            if ($promo->max_discount && $discount > $promo->max_discount) {
                $discount = $promo->max_discount;
            }
        } else {
            $discount = $promo->discount_value;
        }

        return response()->json([
            'success' => true,
            'message' => 'Promo code is valid',
            'data' => [
                'code' => $promo->code,
                'title' => $promo->title,
                'discount_type' => $promo->discount_type,
                'discount_value' => (float) $promo->discount_value,
                'calculated_discount' => (float) $discount,
                'final_total' => (float) ($request->total_belanja - $discount),
            ]
        ], 200);
    }
}
