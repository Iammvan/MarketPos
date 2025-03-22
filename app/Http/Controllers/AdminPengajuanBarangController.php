<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminPengajuanBarang; // Pastikan model AdminPengajuanBarang sudah ada
use Illuminate\Support\Facades\Session;

class AdminPengajuanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua data pengajuan barang
        $AdminPengajuanBarang = AdminPengajuanBarang::all();
        return view('admin.pengajuan.index', compact('AdminPengajuanBarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Tampilkan form untuk membuat pengajuan barang baru
        return view('admin.pengajuan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        // Simpan pengajuan barang baru
        AdminPengajuanBarang::create([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan barang berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Ambil data pengajuan barang berdasarkan id
        $AdminPengajuanBarang = AdminPengajuanBarang::findOrFail($id);
        return view('admin.pengajuan.edit', compact('AdminPengajuanBarang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        // Cari pengajuan barang berdasarkan id dan update datanya
        $AdminPengajuanBarang = AdminPengajuanBarang::findOrFail($id);
        $AdminPengajuanBarang->update([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan barang berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari dan hapus pengajuan barang berdasarkan id
        $AdminPengajuanBarang = AdminPengajuanBarang::findOrFail($id);
        $AdminPengajuanBarang->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan barang berhasil dihapus.');
    }
}
