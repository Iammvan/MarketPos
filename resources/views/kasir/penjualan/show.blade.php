@extends('layouts.kasir')

@section('styles')
<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card-body p {
        margin-bottom: 8px;
    }

    table {
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        text-align: center;
        vertical-align: middle;
        padding: 10px;
    }

    .btn-secondary {
        border-radius: 6px;
        padding: 8px 16px;
    }
</style>
@endsection

@section('content')
<div class="container p-5">
    <div class="card">
        <h2 class="my-2 text-center fw-bold">Detail Penjualan</h2>
        <div class="card-body">
            <p><strong>No Faktur:</strong> {{ $penjualan->no_faktur }}</p>
            <p><strong>Tanggal:</strong> {{ $penjualan->tgl_faktur }}</p>
            <p><strong>Pelanggan:</strong> {{ $penjualan->pelanggan->nama ?? '-' }}</p>
            <p><strong>Total Bayar:</strong> Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</p>
            <p><strong>Status Pembayaran:</strong> <span class="fw-bold">{{ ucfirst($penjualan->status_pembayaran) }}</span></p>
        </div>
    </div>

    <h3 class="my-3 text-center fw-bold">Detail Barang</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Jual</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->detailPenjualan as $detail)
                    <tr>
                        <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                        <td>Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
