@extends('layouts.manajer')

@section('content')
    <div class="container">
        <h2 class="mb-3">Laporan Penjualan</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No Faktur</th>
                    <th>Tanggal</th>
                    <th>Total Bayar</th>
                    <th>Metode Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan as $jual)
                    <tr>
                        <td>{{ $jual->no_faktur }}</td>
                        <td>{{ $jual->tgl_faktur->format('d-m-Y') }}</td>
                        <td>Rp{{ number_format($jual->total_bayar, 0, ',', '.') }}</td>
                        <td>{{ $jual->metode_pembayaran }}</td>
                        <td><a href="{{ route('laporan.detailPenjualan', $jual->id) }}" class="btn btn-info">Detail</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
