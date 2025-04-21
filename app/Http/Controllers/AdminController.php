<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\Pembelian;
use App\Models\Kategori;

class AdminController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalPelanggan = Pelanggan::count();
        $totalPemasok = Pemasok::count();
        $totalPembelian = Pembelian::sum('total');
        $kategoriTerbanyak = Kategori::withCount('barangs')->orderByDesc('barangs_count')->first();

        return view('dashboard.dashboard-admin', compact(
            'totalBarang',
            'totalPelanggan',
            'totalPemasok',
            'totalPembelian',
            'kategoriTerbanyak'
        ));
    }
}