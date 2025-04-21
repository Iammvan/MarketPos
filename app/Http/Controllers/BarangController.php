<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori', 'user')->latest()->get();
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.barang.create', compact('kategoris'));
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_barang' => 'required|string|max:255',
            'harga_beli' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'stok_minimal' => 'nullable|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ditarik' => 'boolean',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('barang_images', 'public');
        }

        Barang::create([
            'kode_barang' => 'BRG-' . str_pad(Barang::count() + 1, 4, '0', STR_PAD_LEFT),
            'kategori_id' => $request->kategori_id,
            'nama_barang' => $request->nama_barang,
            'harga_beli' => $request->harga_beli ?? 0,
            'harga_jual' => $request->harga_jual ?? 0,
            'stok' => $request->stok ?? 0,
            'stok_minimal' => $request->stok_minimal ?? 1,
            'gambar' => $gambarPath,
            'ditarik' => $request->ditarik ?? 0,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang baru berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_barang' => 'required|string|max:255',
            'harga_beli' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'stok_minimal' => 'nullable|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ditarik' => 'boolean',
        ]);

        $barang = Barang::findOrFail($id);

        $data = [
            'kategori_id' => $request->kategori_id,
            'nama_barang' => $request->nama_barang,
            'harga_beli' => $request->harga_beli ?? $barang->harga_beli,
            'harga_jual' => $request->harga_jual ?? $barang->harga_jual,
            'stok' => $request->stok ?? $barang->stok,
            'stok_minimal' => $request->stok_minimal ?? $barang->stok_minimal,
            'ditarik' => $request->ditarik ?? $barang->ditarik,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('barang_images', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        
        // Hapus gambar dari storage jika ada
        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }
        
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil dihapus');
    }
}