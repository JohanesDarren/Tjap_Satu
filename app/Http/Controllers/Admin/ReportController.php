<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DetailOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $totalPendapatan = Order::sum('total_harga');
        $totalPesanan = Order::count();
        $rataRataPesanan = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

        $produkFavorit = DetailOrder::select('id_product', DB::raw('SUM(jumlah) as total_jual'))
            ->with('product') 
            ->groupBy('id_product')
            ->orderByDesc('total_jual')
            ->take(5)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->product->nama_produk => $item->total_jual];
            });

        $penjualanPerHari = Order::select(
                DB::raw('DATE(tanggal_order) as date'), 
                DB::raw('SUM(total_harga) as total')
            )
            ->where('tanggal_order', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->date)->format('d M') => $item->total];
            });

        return view('admin.admin-report', [
            'totalPendapatan' => $totalPendapatan,
            'totalPesanan' => $totalPesanan,
            'rataRataPesanan' => $rataRataPesanan,
            'produkFavorit' => $produkFavorit,
            'penjualanPerHari' => $penjualanPerHari,
        ]);
    }
}