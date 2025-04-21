<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiKerjaExport;
use App\Exports\PengajuanExport;
use App\Imports\AbsensiKerjaImport;
use Illuminate\Http\Request;
use App\Models\AbsensiKerja;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

/**
 * @class AbsensiKerjaController
 * @brief Mengelola semua logika terkait absensi kerja karyawan.
 */
class AbsensiKerjaController extends Controller
{
    /**
     * @brief Menampilkan daftar absensi kerja.
     * 
     * @param Request $request Berisi parameter pencarian seperti nama karyawan dan tanggal.
     * @return \Illuminate\View\View Mengembalikan tampilan daftar absensi dengan pagination.
     */
    public function index(Request $request)
    {
        // Log::info('Menampilkan daftar absensi kerja', [
        //     'user_id' => Auth::id(),
        //     'search' => $request->search,
        //     'tanggal' => $request->tanggal
        // ]);

        $query = AbsensiKerja::query();

        // Filter berdasarkan nama karyawan
        if ($request->filled('search')) {
            $query->where('nama_karyawan', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan tanggal masuk
        if ($request->filled('tanggal')) {
            $query->where('tanggal_masuk', $request->tanggal);
        }

        // Ambil data absensi yang sudah difilter, urutkan berdasarkan tanggal masuk, dan paginate 4 data per halaman
        $absensis = $query->orderBy('tanggal_masuk', 'desc')->get();

        // Log::info('Data absensi berhasil ditampilkan', [
        //     'absensi_count' => $absensis->count()
        // ]);

        return view('admin.absensi.index', compact('absensis'));
    }

    /**
     * @brief Menyimpan data absensi baru.
     *
     * @param Request $request Data dari form input absensi.
     * @return \Illuminate\Http\RedirectResponse Redirect kembali ke halaman sebelumnya dengan pesan sukses atau gagal.
     */
    public function store(Request $request)
    {
        // Validasi inputan dari form
        $validated = $request->validate([
            'nama_karyawan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:masuk,sakit,cuti',
        ]);

        Log::info('Menyimpan absensi baru', $validated);

        $status = $request->status;

        // dd($request);

        try {
            // Simpan absensi ke database
            AbsensiKerja::create([
                'nama_karyawan' => $request->nama_karyawan,
                'user_id' => Auth::id(), // ID user yang sedang login
                'tanggal_masuk' => $request->tanggal_masuk,
                'status' => $status,
                'waktu_masuk' => ($status === 'masuk') ? Carbon::now()->format('H:i:s') : '00:00:00',
                'waktu_kerja_selesai' => '00:00:00',
            ]);

            Log::info('Absensi berhasil disimpan', [
                'nama_karyawan' => $request->nama_karyawan,
                'status' => $status
            ]);

            return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan absensi', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->back()->with('error', 'Gagal menyimpan absensi.');
        }
    }

    /**
     * @brief Mencatat waktu selesai kerja untuk absensi.
     *
     * @param int $id ID dari absensi yang akan diperbarui.
     * @return \Illuminate\Http\RedirectResponse Redirect dengan pesan sukses atau gagal.
     */
    public function selesaiKerja($id)
    {
        Log::info('Mencatat waktu selesai kerja', ['absensi_id' => $id]);

        try {
            $absensi = AbsensiKerja::findOrFail($id);

            if ($absensi->status === 'masuk') {
                $absensi->waktu_kerja_selesai = Carbon::now()->format('H:i:s');
                $absensi->save();

                Log::info('Waktu selesai kerja berhasil dicatat', [
                    'absensi_id' => $id,
                    'waktu_selesai' => $absensi->waktu_kerja_selesai
                ]);

                return redirect()->back()->with('success', 'Waktu selesai kerja berhasil dicatat.');
            }

            Log::warning('Gagal mencatat waktu selesai kerja, status bukan masuk', [
                'absensi_id' => $id,
                'status' => $absensi->status
            ]);

            return redirect()->back()->with('error', 'Tidak bisa update, status bukan masuk.');
        } catch (\Exception $e) {
            Log::error('Error mencatat waktu selesai kerja', [
                'absensi_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Gagal mencatat waktu selesai kerja.');
        }
    }

    /**
     * @brief Memperbarui status dari absensi.
     *
     * @param Request $request Data yang dikirim untuk update (status).
     * @param int $id ID dari data absensi yang ingin diubah.
     * @return \Illuminate\Http\RedirectResponse Redirect dengan pesan.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:masuk,sakit,cuti',
        ]);

        Log::info('Memperbarui status absensi', [
            'absensi_id' => $id,
            'status' => $validated['status']
        ]);

        try {
            $absensi = AbsensiKerja::findOrFail($id);
            $status = $validated['status'];

            $absensi->status = $status;

            if ($status === 'masuk') {
                $absensi->waktu_masuk = Carbon::now()->format('H:i:s');
                $absensi->waktu_kerja_selesai = '00:00:00';
            } else {
                $absensi->waktu_masuk = '00:00:00';
                $absensi->waktu_kerja_selesai = '00:00:00';
            }

            $absensi->save();

            Log::info('Status absensi berhasil diperbarui', [
                'absensi_id' => $id,
                'status' => $absensi->status
            ]);

            return redirect()->back()->with('success', 'Status absensi berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error memperbarui status absensi', [
                'absensi_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Gagal memperbarui status absensi.');
        }
    }

    /**
     * @brief Menghapus data absensi berdasarkan ID.
     *
     * @param int $id ID dari data absensi yang ingin dihapus.
     * @return \Illuminate\Http\RedirectResponse Redirect dengan pesan sukses.
     */
    public function destroy($id)
    {
        Log::info('Menghapus data absensi', ['absensi_id' => $id]);

        try {
            $absensi = AbsensiKerja::findOrFail($id);
            $absensi->delete();

            Log::info('Data absensi berhasil dihapus', ['absensi_id' => $id]);

            return redirect()->back()->with('success', 'Data absensi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error menghapus data absensi', [
                'absensi_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Gagal menghapus data absensi.');
        }
    }


    /**
     * @brief Mengekspor seluruh data absensi kerja ke file Excel.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse File Excel untuk diunduh.
     */
    public function exportExcel()
    {
        Log::info('Mengekspor data absensi kerja ke Excel');

        try {
            return Excel::download(new AbsensiKerjaExport, 'absensi_kerja.xlsx');
        } catch (\Exception $e) {
            Log::error('Error mengekspor data absensi ke Excel', [
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Gagal mengekspor data absensi ke Excel.');
        }
    }

    /**
     * @brief Mengekspor seluruh data absensi kerja ke file PDF.
     *
     * @return \Illuminate\Http\Response File PDF yang dapat diunduh.
     */
    public function exportPDF()
    {
        Log::info('Mengekspor data absensi kerja ke PDF');

        try {
            $absensis = AbsensiKerja::all();

            $pdf = PDF::loadView('admin.absensi.absensi_pdf', compact('absensis'))
                ->setPaper('a4', 'landscape');

            return $pdf->download('absensi_kerja.pdf');
        } catch (\Exception $e) {
            Log::error('Error mengekspor data absensi ke PDF', [
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Gagal mengekspor data absensi ke PDF.');
        }
    }

    /**
     * @brief Mengimpor data absensi dari file Excel atau CSV.
     *
     * @param Request $request Berisi file Excel/CSV yang akan diimport.
     * @return \Illuminate\Http\RedirectResponse Redirect dengan pesan sukses.
     */
    public function import(Request $request)
    {
        Log::info('Mengimpor data absensi', ['user_id' => Auth::id()]);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new AbsensiKerjaImport, $request->file('file'));

            Log::info('Data absensi berhasil diimpor', [
                'file_name' => $request->file('file')->getClientOriginalName()
            ]);

            return redirect()->back()->with('success', 'Data absensi berhasil diimport.');
        } catch (\Exception $e) {
            Log::error('Error mengimpor data absensi', [
                'error' => $e->getMessage(),
                'file_name' => $request->file('file')->getClientOriginalName()
            ]);
            return redirect()->back()->with('error', 'Gagal mengimpor data absensi.');
        }
    }
}