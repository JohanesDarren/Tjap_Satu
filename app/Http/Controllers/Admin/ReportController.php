<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DetailOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('admin.laporan.index', [
            'totalPendapatan' => $this->getTotalRevenue(),
            'totalPesanan' => $this->getTotalOrders(),
            'rataRataPesanan' => $this->getAverageOrderValue(),
            'produkFavorit' => $this->getTopProducts(),
            'penjualanPerHari' => $this->getDailySalesChart(),
            'orderStatus' => $this->getOrderStatusDistribution(),
            'revenueByMonth' => $this->getMonthlyRevenue(),
        ]);
    }

    protected function getTotalRevenue(): int
    {
        return (int) Order::sum('total_harga');
    }

    protected function getTotalOrders(): int
    {
        return Order::count();
    }

    protected function getAverageOrderValue(): float
    {
        $total = $this->getTotalOrders();
        return $total > 0 ? $this->getTotalRevenue() / $total : 0;
    }

    protected function getTopProducts(): array
    {
        return DetailOrder::select('id_product', DB::raw('SUM(jumlah) as total_jual'))
            ->with('product:id_product,nama_produk')
            ->groupBy('id_product')
            ->orderByDesc('total_jual')
            ->take(5)
            ->get()
            ->mapWithKeys(fn($item) => [
                $item->product->nama_produk => (int) $item->total_jual
            ])
            ->toArray();
    }

    protected function getDailySalesChart(): array
    {
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $salesData = Order::where('tanggal_order', '>=', $startDate)
            ->selectRaw('DATE(tanggal_order) as date, SUM(total_harga) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $chartData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays(6 - $i);
            $key = $date->format('Y-m-d');
            $chartData[$date->format('d M')] = (int) ($salesData[$key] ?? 0);
        }

        return $chartData;
    }

    protected function getOrderStatusDistribution(): array
    {
        $statuses = ['pending', 'proses', 'dikirim', 'selesai', 'dibatalkan'];
        $distribution = [];

        foreach ($statuses as $status) {
            $distribution[ucfirst($status)] = Order::whereRaw('LOWER(status_pesanan) = ?', [strtolower($status)])
                ->count();
        }

        return $distribution;
    }

    protected function getMonthlyRevenue(): array
    {
        $monthlyData = Order::whereYear('tanggal_order', Carbon::now()->year)
            ->selectRaw('MONTH(tanggal_order) as month, SUM(total_harga) as total')
            ->groupByRaw('MONTH(tanggal_order)')
            ->pluck('total', 'month');

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $revenue = [];

        for ($month = 1; $month <= 12; $month++) {
            $revenue[$monthNames[$month - 1]] = (int) ($monthlyData[$month] ?? 0);
        }

        return $revenue;
    }
}