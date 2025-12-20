<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kurir;

class KurirController extends Controller
{
    /**
     * Get all available kurir/drivers
     */
    public function index()
    {
        $kurirs = Kurir::orderBy('nama_kurir', 'asc')->get();

        $data = $kurirs->map(function ($kurir) {
            return [
                'id' => $kurir->id_kurir,
                'nama' => $kurir->nama_kurir,
                'jenis' => $kurir->plat_nomor ?? 'Regular',
                'ongkir' => 15000, // Default shipping cost, you can adjust this
                'no_telp' => $kurir->no_telp,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}
