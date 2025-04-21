<?php

namespace App\Imports;

use App\Models\AbsensiKerja;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\HeadingRowFormatter;
use Carbon\Carbon;
use Maatwebsite\Excel\Imports\HeadingRowFormatter as ImportsHeadingRowFormatter;

class AbsensiKerjaImport implements ToModel, WithHeadingRow
{
    public function __construct()
    {
        // Ambil heading persis seperti di file Excel (case-sensitive)
        ImportsHeadingRowFormatter::default('none');
    }

    public function model(array $row)
    {
        if (empty($row['Nama Karyawan'])) {
            return null;
        }

        return new AbsensiKerja([
            'nama_karyawan'       => $row['Nama Karyawan'],
            'tanggal_masuk'       => Carbon::parse($row['Tanggal Masuk'])->format('Y-m-d'),
            'status'              => $row['Status'],
            'waktu_masuk'         => Carbon::parse($row['Waktu Masuk'])->format('H:i:s'),
            'waktu_kerja_selesai' => Carbon::parse($row['Waktu Kerja Selesai'])->format('H:i:s'),
            'user_id'             => Auth::id(),
        ]);
    }
}