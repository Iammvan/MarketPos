<?php

use App\Http\Controllers\AbsensiKerjaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajerController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminPengajuanBarangController;
use App\Http\Controllers\PengajuanBarangController;

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Role -> Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard.admin');

    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Barang
    Route::prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('barang.index'); // Menampilkan daftar barang
        Route::get('/create', [BarangController::class, 'create'])->name('barang.create'); // Form tambah barang
        Route::post('/', [BarangController::class, 'store'])->name('barang.store'); // Simpan barang baru
        Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit'); // Form edit barang
        Route::put('/{id}', [BarangController::class, 'update'])->name('barang.update'); // Update barang
        Route::delete('/{id}', [BarangController::class, 'destroy'])->name('barang.destroy'); // Hapus barang
    });

    // Pembeian Barang
    Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
    Route::get('/pembelian/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::get('/pembelian/{id}', [PembelianController::class, 'show'])->name('pembelian.show');


    Route::get('/pengajuan', [PengajuanBarangController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/create', [PengajuanBarangController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [PengajuanBarangController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/{id}/edit', [PengajuanBarangController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/pengajuan/{id}', [PengajuanBarangController::class, 'update'])->name('pengajuan.update');
    Route::delete('/pengajuan/{id}', [PengajuanBarangController::class, 'destroy'])->name('pengajuan.destroy');

    // Pemasok
    Route::get('/pemasok', [PemasokController::class, 'index'])->name('pemasok.index');
    Route::get('/pemasok/create', [PemasokController::class, 'create'])->name('pemasok.create');
    Route::post('/pemasok', [PemasokController::class, 'store'])->name('pemasok.store');
    Route::get('/pemasok/{pemasok}/edit', [PemasokController::class, 'edit'])->name('pemasok.edit');
    Route::put('/pemasok/{pemasok}', [PemasokController::class, 'update'])->name('pemasok.update');
    Route::get('/pemasok/{pemasok}', [PemasokController::class, 'show'])->name('pemasok.show');
    Route::delete('/pemasok/{pemasok}', [PemasokController::class, 'destroy'])->name('pemasok.destroy');

    Route::get('/absensi', [AbsensiKerjaController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [AbsensiKerjaController::class, 'store'])->name('absensi.store');
    Route::put('/absensi/selesai/{id}', [AbsensiKerjaController::class, 'selesaiKerja'])->name('absensi.selesai');
    Route::put('/absensi/{id}', [AbsensiKerjaController::class, 'update'])->name('absensi.update');
    Route::delete('/absensi/{id}', [AbsensiKerjaController::class, 'destroy'])->name('absensi.destroy');

    Route::get('/absensi/export/excel', [AbsensiKerjaController::class, 'exportExcel'])->name('absensi.export.excel');
    Route::get('/absensi/export/pdf', [AbsensiKerjaController::class, 'exportPDF'])->name('absensi.export.pdf');
    Route::post('/absensi/import', [AbsensiKerjaController::class, 'import'])->name('absensi.import');
});
Route::middleware(['auth'])->group(function () {
    // User bisa akses halaman pengajuan barang
    Route::get('/pengajuan-barang', [AdminPengajuanBarangController::class, 'index'])->name('pengajuan.index');

    // Tambah, edit, hapus pengajuan
    Route::resource('admin/pengajuan', AdminPengajuanBarangController::class);
    Route::post('/pengajuan', [AdminPengajuanBarangController::class, 'store'])
        ->name('admin.pengajuan.store');
    Route::get('/pengajuan-barang/{id}/edit', [AdminPengajuanBarangController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/pengajuan-barang/{id}', [AdminPengajuanBarangController::class, 'update'])->name('pengajuan.update');
    Route::delete('/pengajuan-barang/{id}', [AdminPengajuanBarangController::class, 'destroy'])->name('pengajuan.destroy');

    // Export data
    Route::get('/pengajuan-barang/export-excel', [AdminPengajuanBarangController::class, 'exportExcel'])->name('pengajuan.exportExcel');
    Route::get('/pengajuan-barang/export-pdf', [AdminPengajuanBarangController::class, 'exportPdf'])->name('pengajuan.exportPdf');


    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

// Role -> Kasir
Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/dashboard-kasir', [KasirController::class, 'index'])->name('dashboard.kasir');
    Route::get('/sales/export', [PenjualanController::class, 'export'])->name('penjualan.export');
    Route::post('/sales/import', [PenjualanController::class, 'import'])->name('penjualan.import');
    
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
});

// Role -> Manajer
Route::middleware(['auth', 'role:manajer'])->group(function () {
    Route::get('/dashboard-manajer', [ManajerController::class, 'index'])->name('dashboard.manajer');

    Route::get('/laporan/barang', [LaporanController::class, 'laporanBarang'])->name('laporan.barang');
    Route::get('/laporan/penjualan', [LaporanController::class, 'laporanPenjualan'])->name('laporan.penjualan');
    Route::get('/laporan/pembelian', [LaporanController::class, 'laporanPembelian'])->name('laporan.pembelian');
    Route::get('/laporan/penjualan/{id}', [LaporanController::class, 'detailPenjualan'])->name('laporan.detailPenjualan');
    Route::get('/laporan/pembelian/{id}', [LaporanController::class, 'detailPembelian'])->name('laporan.detailPembelian');
});


Route::get('/unauthorized', function () {
    return view('errors.unauthorized');
});