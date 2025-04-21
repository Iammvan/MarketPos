<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPengajuanBarang extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_barang'; // Sesuaikan dengan nama tabel
    
    protected $fillable = [
        'nama_pengaju',
        'nama_barang',
        'tanggal_pengajuan',
        'qty',
        'terpenuhi',
        'deskripsi'
    ];
}