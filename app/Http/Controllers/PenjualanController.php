<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('pelanggan', 'user')->get();
        return view('kasir.penjualan.index', compact('penjualans'));
    }



    public function create()
    {
        $pelanggans = Pelanggan::all();
        $users = User::all();
        $barangs = Barang::all();
        return view('kasir.penjualan.create', compact('pelanggans', 'users', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_bayar' => 'required|numeric|min:1',
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $no_faktur = 'FTR-' . now()->format('YmdHis');
            $tgl_faktur = now();
            $metode_pembayaran = 'cash';
            $status_pembayaran = 'lunas';

            $penjualan = Penjualan::create([
                'no_faktur' => $no_faktur,
                'tgl_faktur' => $tgl_faktur,
                'total_bayar' => $request->total_bayar,
                'pelanggan_id' => $request->pelanggan_id,
                'user_id' => $request->user_id,
                'metode_pembayaran' => $metode_pembayaran,
                'status_pembayaran' => $status_pembayaran
            ]);

            foreach ($request->items as $item) {
                $barang = Barang::lockForUpdate()->findOrFail($item['barang_id']);

                if ($barang->stok < $item['jumlah']) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Stok barang {$barang->nama_barang} tidak mencukupi");
                }

                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $item['barang_id'],
                    'harga_jual' => $barang->harga_jual,
                    'jumlah' => $item['jumlah'],
                    'sub_total' => $barang->harga_jual * $item['jumlah']
                ]);

                $barang->decrement('stok', $item['jumlah']);
            }

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Transaksi gagal: " . $e->getMessage(), ['request' => $request->all()]);
            return redirect()->back()->with('error', 'Transaksi gagal, silakan coba lagi.');
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with('detailPenjualan.barang', 'pelanggan', 'user')->findOrFail($id);
        return view('kasir.penjualan.show', compact('penjualan'));
    }
}
