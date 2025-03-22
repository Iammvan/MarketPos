<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPengajuanBarang extends Model
{
    use HasFactory;

    // Tabel yang digunakan oleh model
    protected $table = 'pengajuan_barang'; // Nama tabel di database
    
    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'nama_pengaju',       // Nama orang yang mengajukan
        'nama_barang',        // Nama barang yang diajukan
        'tanggal_pengajuan',  // Tanggal pengajuan barang
        'qty',                // Jumlah barang
        'terpenuhi',          // Status apakah pengajuan terpenuhi
        'deskripsi'           // Deskripsi barang (jika ada)
    ];

    // Jika menggunakan timestamps, pastikan ini aktif
    public $timestamps = true;

    // Relasi, jika diperlukan
    // Contoh: AdminPengajuanBarang bisa dimiliki oleh seorang User
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
