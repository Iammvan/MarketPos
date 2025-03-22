@extends('layouts.kasir')

@section('styles')
<style>
    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }
    .table thead {
        background-color: #343a40;
        color: white;
    }
    .btn-info {
        transition: 0.3s;
    }
    .btn-info:hover {
        background-color: #17a2b8;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container p-5">
    <div class="card shadow-lg p-4">
        <h2 class="mb-4 text-center text-primary fw-bold">Daftar Penjualan</h2>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No Faktur</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualans as $penjualan)
                        <tr>
                            <td><strong>{{ $penjualan->no_faktur }}</strong></td>
                            <td>{{ $penjualan->tgl_faktur }}</td>
                            <td>{{ $penjualan->pelanggan->nama ?? '-' }}</td>
                            <td class="text-success fw-bold">Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('penjualan.show', $penjualan->id) }}" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection