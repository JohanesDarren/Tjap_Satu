<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(){
        $pesananData = [
            ['id' => 'TJPS-001', 'tanggal_pesan' => '2025-10-18', 'nama_pelanggan' => 'Budi Santoso', 'total_harga' => 105000, 'items' => [['nama_produk' => 'Toraja Sapan', 'jumlah' => 1]]],
            ['id' => 'TJPS-002', 'tanggal_pesan' => '2025-10-18', 'nama_pelanggan' => 'Citra Lestari', 'total_harga' => 50000, 'items' => [['nama_produk' => 'Gn. Puntang (Arabika)', 'jumlah' => 1]]],
            ['id' => 'TJPS-003', 'tanggal_pesan' => '2025-10-17', 'nama_pelanggan' => 'Agus Wijaya', 'total_harga' => 210000, 'items' => [['nama_produk' => 'Gayo (Wine)', 'jumlah' => 1]]],
            ['id' => 'TJPS-004', 'tanggal_pesan' => '2025-10-19', 'nama_pelanggan' => 'Dewi Anggraini', 'total_harga' => 140000, 'items' => [['nama_produk' => 'Bali Kintamani', 'jumlah' => 2]]],
            ['id' => 'TJPS-005', 'tanggal_pesan' => '2025-10-19', 'nama_pelanggan' => 'Budi Santoso', 'total_harga' => 64000, 'items' => [['nama_produk' => 'Gunung Halu', 'jumlah' => 2]]],
            ['id' => 'TJPS-006', 'tanggal_pesan' => '2025-10-16', 'nama_pelanggan' => 'Eka Putri', 'total_harga' => 105000, 'items' => [['nama_produk' => 'Toraja Sapan', 'jumlah' => 1]]],
        ];
        $pesanan = collect($pesananData);

        $totalPendapatan = $pesanan->sum('total_harga');
        $totalPesanan = $pesanan->count();
        $rataRataPesanan = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

        $produkFavorit = $pesanan->flatMap(fn ($pesanan) => $pesanan['items'])
            ->groupBy('nama_produk')
            ->map(fn ($items) => $items->sum('jumlah'))
            ->sortDesc()
            ->take(5);

        $penjualanPerHari = $pesanan
            ->where('tanggal_pesan', '>=', Carbon::today()->subDays(6)->toDateString())
            ->groupBy(fn ($pesanan) => Carbon::parse($pesanan['tanggal_pesan'])->format('d M'))
            ->map(fn ($pesanan) => $pesanan->sum('total_harga'));

        return view('admin.admin-report', [
            'totalPendapatan' => $totalPendapatan,
            'totalPesanan' => $totalPesanan,
            'rataRataPesanan' => $rataRataPesanan,
            'produkFavorit' => $produkFavorit,
            'penjualanPerHari' => $penjualanPerHari,
        ]);
    }
}
