<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $q    = trim($request->get('q', ''));
        $from = $request->get('from');
        $to   = $request->get('to');

        // Query Builder canggih untuk statistik customer
        $customersQuery = Customer::query()
            ->select('customer.*') // Pastikan nama tabel sesuai migrasi (customer)
            ->selectSub(function($sub) use ($from,$to){
                $sub->from('order') // Pastikan nama tabel sesuai migrasi (order)
                    ->selectRaw('COALESCE(SUM(total_harga),0)')
                    ->whereColumn('order.id_cust','customer.id_cust');
                if ($from) $sub->whereDate('tanggal_order','>=',$from);
                if ($to)   $sub->whereDate('tanggal_order','<=',$to);
            }, 'total_spent')
            ->selectSub(function($sub) use ($from,$to){
                $sub->from('order')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('order.id_cust','customer.id_cust');
                if ($from) $sub->whereDate('tanggal_order','>=',$from);
                if ($to)   $sub->whereDate('tanggal_order','<=',$to);
            }, 'orders_count')
            ->selectSub(function($sub) use ($from,$to){
                $sub->from('order')
                    ->selectRaw('MAX(tanggal_order)')
                    ->whereColumn('order.id_cust','customer.id_cust');
                if ($from) $sub->whereDate('tanggal_order','>=',$from);
                if ($to)   $sub->whereDate('tanggal_order','<=',$to);
            }, 'last_order_at')
            ->orderByDesc(DB::raw('last_order_at IS NULL')) // Customer aktif di atas
            ->orderByDesc('last_order_at');

        // Fitur Pencarian
        if ($q !== '') {
            $customersQuery->where(function($w) use ($q){
                $w->where('nama_lengkap','like',"%$q%") // Sesuaikan dengan kolom di DB (nama/nama_lengkap)
                  ->orWhere('email','like',"%$q%")
                  ->orWhere('no_telp','like',"%$q%");
            });
        }

        // Filter Tanggal
        if ($from || $to) {
            $customersQuery->whereExists(function($sub) use ($from,$to){
                $sub->selectRaw(1)
                    ->from('order')
                    ->whereColumn('order.id_cust','customer.id_cust');
                if ($from) $sub->whereDate('tanggal_order','>=',$from);
                if ($to)   $sub->whereDate('tanggal_order','<=',$to);
            });
        }

        $customers = $customersQuery->get();

        return view('admin.customer.index', compact('customers','q','from','to'));
    }

    public function show($id)
    {
        $customer = Customer::where('id_cust',$id)->firstOrFail();

        // Mengambil histori order beserta detail produknya
        $orders = Order::with(['detailOrders.product'])
            ->where('id_cust', $customer->id_cust)
            ->orderByDesc('tanggal_order')
            ->get();

        $summary = [
            'total_orders' => $orders->count(),
            'total_spent'  => $orders->sum('total_harga'),
            'last_order_at'=> optional($orders->first())->tanggal_order,
        ];

        // Data untuk Grafik: Pengeluaran 6 bulan terakhir
        $monthsBack = 6;
        $startMonth = Carbon::now()->subMonths($monthsBack-1)->startOfMonth();

        $monthly = Order::selectRaw('DATE_FORMAT(tanggal_order, "%Y-%m") as ym, SUM(total_harga) as total')
            ->where('id_cust',$customer->id_cust)
            ->where('tanggal_order','>=',$startMonth)
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total','ym');

        $chartLabels = [];
        $chartData   = [];
        for ($i=0;$i<$monthsBack;$i++) {
            $m = (clone $startMonth)->addMonths($i);
            $key = $m->format('Y-m');
            $chartLabels[] = $m->format('M Y'); // Label Bulan (Jan 2025)
            $chartData[]   = (int) ($monthly[$key] ?? 0);
        }

        return view('admin.customer.show', compact('customer','summary','orders','chartLabels','chartData'));
    }

    public function destroy($id)
    {
        $customer = Customer::where('id_cust', $id)->firstOrFail();
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
