@extends('layouts.manajer')

@section('content')
    <div class="container">
        <h2 class="mb-3">Laporan Barang</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barang as $item)
                    <tr>
                        <td>{{ $item->kode_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>Rp{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td>{{ $item->stok }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
