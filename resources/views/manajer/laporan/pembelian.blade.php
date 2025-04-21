@extends('layouts.manajer')

@section('content')
    <div class="container">
        <h2 class="mb-3">Laporan Pembelian</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Masuk</th>
                    <th>Tanggal Masuk</th>
                    <th>Total Pembelian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembelian as $beli)
                    <tr>
                        <td>{{ $beli->kode_masuk }}</td>
                        <td>{{ \Carbon\Carbon::parse($beli->tanggal_masuk)->format('d-m-Y') }}</td>
                        <td>Rp{{ number_format($beli->total, 0, ',', '.') }}</td>
                        <td><a href="{{ route('laporan.detailPembelian', $beli->id) }}" class="btn btn-info">Detail</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection