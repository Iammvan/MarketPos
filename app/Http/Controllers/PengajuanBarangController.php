<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBarang;
use Illuminate\Http\Request;

class PengajuanBarangController extends Controller
{
    public function index()
    {
        $pengajuans = PengajuanBarang::all();
        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        return view('admin.pengajuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengaju' => 'required|string',
            'nama_barang' => 'required|string',
            'qty' => 'required|integer|min:1',
            'tanggal_pengajuan' => 'required|date',
            'terpenuhi' => 'nullable|boolean',
            'deskripsi' => 'nullable|string',
        ]);

        PengajuanBarang::create($request->all());

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);
        return view('admin.pengajuan.edit', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pengaju' => 'required|string',
            'nama_barang' => 'required|string',
            'qty' => 'required|integer|min:1',
            'tanggal_pengajuan' => 'required|date',
            'terpenuhi' => 'nullable|boolean',
            'deskripsi' => 'nullable|string',
        ]);

        $pengajuan = PengajuanBarang::findOrFail($id);
        $pengajuan->update($request->all());

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);
        $pengajuan->delete();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan barang berhasil dihapus.');
    }
}