<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // === METRICS ===
        $today = Carbon::today();
        $ordersToday = Order::whereDate('tanggal_order', $today)->count();
        $revenueToday = (int) Order::whereDate('tanggal_order', $today)->sum('total_harga');
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();
        $revenueThisWeek = (int) Order::whereBetween('tanggal_order', [$startWeek, $endWeek])->sum('total_harga');
        $avgOrderValue = (int) round(Order::avg('total_harga') ?: 0);
        $itemsSold = (int) DetailOrder::sum('jumlah');
        $uniqueCustomers = (int) Order::distinct('id_cust')->count('id_cust');

        $metrics = [
            'orders_today'      => $ordersToday,
            'revenue_today'     => $revenueToday,
            'revenue_this_week' => $revenueThisWeek,
            'avg_order_value'   => $avgOrderValue,
            'items_sold'        => $itemsSold,
            'unique_customers'  => $uniqueCustomers,
        ];

        // === DAILY REVENUE (Last 7 days) ===
        $daysBack = 7;
        $startDaily = Carbon::now()->subDays($daysBack - 1)->startOfDay();
        $rawDaily = Order::where('tanggal_order', '>=', $startDaily)
            ->selectRaw('DATE(tanggal_order) as d, SUM(total_harga) as total')
            ->groupBy('d')
            ->pluck('total', 'd');
        $dayNameMap = [
            'Monday' => 'Sen', 'Tuesday' => 'Sel', 'Wednesday' => 'Rab', 'Thursday' => 'Kam',
            'Friday' => 'Jum', 'Saturday' => 'Sab', 'Sunday' => 'Min'
        ];
        $dailyLabels = [];
        $dailyData = [];
        for ($i = 0; $i < $daysBack; $i++) {
            $d = (clone $startDaily)->addDays($i);
            $dateKey = $d->format('Y-m-d');
            $dailyLabels[] = $dayNameMap[$d->englishDayOfWeek] ?? $d->format('D');
            $dailyData[] = (int) ($rawDaily[$dateKey] ?? 0);
        }
        $dailyRevenue = ['labels' => $dailyLabels, 'data' => $dailyData];

        // === WEEKLY REVENUE (Last 8 weeks) ===
        $weeksBack = 8;
        $startWeekly = Carbon::now()->subWeeks($weeksBack - 1)->startOfWeek();
        $rawWeekly = Order::where('tanggal_order', '>=', $startWeekly)
            ->selectRaw('YEAR(tanggal_order) as y, WEEK(tanggal_order, 1) as w, SUM(total_harga) as total')
            ->groupBy('y', 'w')
            ->orderBy('y')->orderBy('w')
            ->get()
            ->map(fn($r) => [ 'key' => $r->y.'-'.$r->w, 'total' => (int) $r->total ])
            ->keyBy('key');
        $weeklyLabels = [];
        $weeklyData = [];
        for ($i = 0; $i < $weeksBack; $i++) {
            $weekDate = (clone $startWeekly)->addWeeks($i);
            $weekKey = $weekDate->format('Y').'-'.$weekDate->format('W');
            $weeklyLabels[] = 'W-'.$weekDate->format('W');
            $weeklyData[] = $rawWeekly[$weekKey]['total'] ?? 0;
        }
        $weeklyRevenue = ['labels' => $weeklyLabels, 'data' => $weeklyData];

        // === TOP PRODUCTS (By quantity sold) ===
        $topProductsRaw = DetailOrder::select('id_product', DB::raw('SUM(jumlah) as sold'))
            ->groupBy('id_product')
            ->orderByDesc('sold')
            ->with('product:id_product,nama_produk')
            ->limit(5)
            ->get();
        $topProducts = $topProductsRaw->map(fn($row) => [
            'name' => optional($row->product)->nama_produk ?? 'Produk #'.$row->id_product,
            'sold' => (int) $row->sold,
        ])->toArray();

        // === ORDER SUMMARY (Counts per status) ===
        $orderSummaryRaw = Order::select('status_pesanan', DB::raw('COUNT(*) as c'))
            ->groupBy('status_pesanan')
            ->get()
            ->map(function($r){
                $key = strtolower(trim($r->status_pesanan));
                // Normalisasi variasi status ke bentuk kanonik
                return [
                    'key' => match ($key) {
                        'pending' => 'pending',
                        'proses', 'diproses' => 'proses',
                        'kirim', 'dikirim' => 'dikirim',
                        'selesai', 'done', 'completed' => 'selesai',
                        'batal', 'dibatalkan', 'cancelled' => 'dibatalkan',
                        default => $key,
                    },
                    'c' => (int) $r->c,
                ];
            });
        // Akumulasikan ke dalam array final dengan label tetap
        $orderSummary = [
            'pending' => 0,
            'proses' => 0,
            'dikirim' => 0,
            'selesai' => 0,
            'dibatalkan' => 0,
        ];
        foreach ($orderSummaryRaw as $row) {
            if (array_key_exists($row['key'], $orderSummary)) {
                $orderSummary[$row['key']] += $row['c'];
            }
        }

        return view('admin.dashboard', compact(
            'metrics',
            'dailyRevenue',
            'weeklyRevenue',
            'topProducts',
            'orderSummary'
        ));
    }
}
