<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Barang;
use Carbon\Carbon;

class KasirController extends Controller
{
    public function index()
    {
        $totalPenjualanHariIni = Penjualan::whereDate('tgl_faktur', Carbon::today())->sum('total_bayar');

        $totalTransaksiHariIni = Penjualan::whereDate('tgl_faktur', Carbon::today())->count();

        $barangTerlaris = DetailPenjualan::selectRaw('barang_id, SUM(jumlah) as total_jumlah')
            ->groupBy('barang_id')
            ->orderByDesc('total_jumlah')
            ->with('barang')
            ->limit(5)
            ->get();

        $stokMinimal = Barang::whereColumn('stok', '<=', 'stok_minimal')->get();

        return view('dashboard.dashboard-kasir', compact(
            'totalPenjualanHariIni',
            'totalTransaksiHariIni',
            'barangTerlaris',
            'stokMinimal'
        ));
    }
}