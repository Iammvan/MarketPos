@extends('layouts.manajer')

@section('content')
    <div class="container">
        <h2 class="mb-3">Detail Pembelian - {{ $pembelian->kode_masuk }}</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembelian->detailPembelian as $detail)
                    <tr>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td>Rp{{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp{{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('laporan.pembelian') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
