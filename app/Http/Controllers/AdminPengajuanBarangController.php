<?php  

namespace App\Http\Controllers;

use Illuminate\Http\Request;  // Ada typo di sini (HttpRequest seharusnya Http\Request)
use App\Models\AdminPengajuanBarang;
use Illuminate\Support\Facades\Log;

class AdminPengajuanBarangController extends Controller



    {
        public function index()
        {
            try {
                $AdminPengajuanBarang = AdminPengajuanBarang::all();
                return view('admin.pengajuan.index', compact('AdminPengajuanBarang'));
            } catch (\Exception $e) {
                Log::error("Error fetching pengajuan barang: " . $e->getMessage());
                return back()->with('error', 'Terjadi kesalahan saat mengambil data.');
            }
        }

    public function create()
    {
        return view('admin.pengajuan.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
        try {
            $request->validate([
                'nama_pengaju' => 'required|string|max:255',
                'nama_barang' => 'required|string|max:255',
                'tanggal_pengajuan' => 'required|date',
                'qty' => 'required|integer|min:1',
                'deskripsi' => 'nullable|string',
            ]);
    
            AdminPengajuanBarang::create([
                'nama_pengaju' => $request->nama_pengaju,
                'nama_barang' => $request->nama_barang,
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
                'qty' => $request->qty,
                'deskripsi' => $request->deskripsi,
                'terpenuhi' => false // Default value
            ]);
    
            return redirect()->route('admin.pengajuan.index')
                   ->with('success', 'Pengajuan barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error("Error storing pengajuan barang: " . $e->getMessage());
            return back()->withInput()
                   ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit($id)
    {
        try {
            $AdminPengajuanBarang = AdminPengajuanBarang::findOrFail($id);
            return view('admin.pengajuan.edit', compact('AdminPengajuanBarang'));
        } catch (\Exception $e) {
            Log::error("Error fetching pengajuan barang for edit: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil data untuk diedit.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_barang' => 'required|string|max:255',
                'jumlah' => 'required|integer',
                'deskripsi' => 'nullable|string',
            ]);

            $AdminPengajuanBarang = AdminPengajuanBarang::findOrFail($id);
            $AdminPengajuanBarang->update([
                'nama_barang' => $request->nama_barang,
                'jumlah' => $request->jumlah,
                'deskripsi' => $request->deskripsi,
            ]);

            return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan barang berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error("Error updating pengajuan barang: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengupdate data.');
        }
    }

    public function destroy($id)
    {
        try {
            $AdminPengajuanBarang = AdminPengajuanBarang::findOrFail($id);
            $AdminPengajuanBarang->delete();

            return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan barang berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Error deleting pengajuan barang: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
