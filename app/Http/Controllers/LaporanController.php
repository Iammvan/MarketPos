<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\DetailPenjualan;
use App\Models\DetailPembelian;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Laporan Barang
    public function laporanBarang()
    {
        $barang = Barang::all();
        return view('manajer.laporan.barang', compact('barang'));
    }

    // Laporan Penjualan
    public function laporanPenjualan()
    {
        $penjualan = Penjualan::with('detailPenjualan.barang')->get();
        return view('manajer.laporan.penjualan', compact('penjualan'));
    }

    // Laporan Pembelian
    public function laporanPembelian()
    {
        $pembelian = Pembelian::with('detailPembelian.barang')->get();
        return view('manajer.laporan.pembelian', compact('pembelian'));
    }

    // Detail Penjualan
    public function detailPenjualan($id)
    {
        $penjualan = Penjualan::with('detailPenjualan.barang')->findOrFail($id);
        return view('manajer.laporan.detail_penjualan', compact('penjualan'));
    }

    // Detail Pembelian
    public function detailPembelian($id)
    {
        $pembelian = Pembelian::with('detailPembelian.barang')->findOrFail($id);
        return view('manajer.laporan.detail_pembelian', compact('pembelian'));
    }
}
