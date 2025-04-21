@extends('layouts.kasir')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Dashboard Kasir</h2>
    
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center bg-primary rounded text-white">
                    <h5 class="card-title mb-2">Total Penjualan Hari Ini</h5>
                    <h3 class="fw-bold">Rp {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center bg-success rounded text-white">
                    <h5 class="card-title mb-2">Total Transaksi Hari Ini</h5>
                    <h3 class="fw-bold">{{ $totalTransaksiHariIni }} Transaksi</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-3">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-danger text-white fw-bold text-center">Barang Terlaris</div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-danger text-center">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Total Terjual</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($barangTerlaris as $barang)
                                <tr>
                                    <td>{{ $barang->barang->nama_barang ?? '-' }}</td>
                                    <td>{{ $barang->total_jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark fw-bold text-center">Stok Minimal</div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-warning text-center">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                <th>Stok Minimal</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($stokMinimal as $barang)
                                <tr>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->stok }}</td>
                                    <td>{{ $barang->stok_minimal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
