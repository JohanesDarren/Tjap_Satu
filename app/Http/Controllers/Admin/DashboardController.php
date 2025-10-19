<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // === METRIC RINGKASAN (dummy) ===
        $metrics = [
            'orders_today'      => 62,
            'revenue_today'     => 1450000,   // Rp
            'revenue_this_week' => 9800000,   // Rp
            'avg_order_value'   => 234000,    // Rp
            'items_sold'        => 420,
            'unique_customers'  => 139,
        ];

        // === DATA GRAFIK (dummy) ===
        $dailyRevenue = [
            'labels' => ['Sen','Sel','Rab','Kam','Jum','Sab','Min'],
            'data'   => [1200000, 1350000, 1500000, 1100000, 1700000, 2100000, 1950000],
        ];

        $weeklyRevenue = [
            'labels' => ['W-35','W-36','W-37','W-38','W-39','W-40','W-41','W-42'],
            'data'   => [7200000, 8150000, 7900000, 9100000, 8600000, 9400000, 10200000, 9800000],
        ];

        $topProducts = [
            ['name' => 'Kopi Susu Gula Aren', 'sold' => 185],
            ['name' => 'Americano',            'sold' => 142],
            ['name' => 'Cappuccino',           'sold' => 128],
            ['name' => 'Espresso',             'sold' => 118],
            ['name' => 'Matcha Latte',         'sold' => 92],
        ];

        $orderSummary = [
            'Pending'    => 18,
            'Diproses'   => 24,
            'Selesai'    => 198,
            'Dibatalkan' => 7,
        ];

        return view('admin.dashboard', compact(
            'metrics', 'dailyRevenue', 'weeklyRevenue', 'topProducts', 'orderSummary'
        ));
    }
}