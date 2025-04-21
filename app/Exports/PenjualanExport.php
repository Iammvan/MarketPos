<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Penjualan; // atau Penjualan, sesuai model kamu

class PenjualanExport implements FromCollection
{
    public function collection()
    {   
        return Penjualan::with('detailPenjualan')->get();
    }
}
