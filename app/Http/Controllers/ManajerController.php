<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManajerController extends Controller
{
    public function index()
    {
        // Total barang yang tersedia
        $totalBarang = Barang::count();

        // Total penjualan dan pembelian secara keseluruhan
        $totalPenjualan = Penjualan::sum('total_bayar') ?? 0;
        $totalPembelian = Pembelian::sum('total') ?? 0;

        // Total pemasukan dan pengeluaran
        $totalPengeluaran = $totalPembelian;
        $totalPemasukan = $totalPenjualan;

        // Total penjualan hari ini
        $penjualanHariIni = Penjualan::whereDate('tgl_faktur', Carbon::today())->sum('total_bayar') ?? 0;

        // Total penjualan dan pembelian dalam satu bulan terakhir
        $bulanIni = Carbon::now()->format('Y-m'); // Format YYYY-MM
        $penjualanBulanan = Penjualan::where('tgl_faktur', 'like', "$bulanIni%")->sum('total_bayar') ?? 0;
        $pembelianBulanan = Pembelian::where('tanggal_masuk', 'like', "$bulanIni%")->sum('total') ?? 0;

        return view('dashboard.dashboard-manajer', compact(
            'totalBarang',
            'totalPenjualan',
            'totalPembelian',
            'totalPengeluaran',
            'totalPemasukan',
            'penjualanHariIni',
            'penjualanBulanan',
            'pembelianBulanan'
        ));
    }
}
