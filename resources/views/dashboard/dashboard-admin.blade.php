@extends('layouts.admin')

@section('content')
<div class="container p-5">
        <h2 class="text-center mb-4">Dashboard Admin</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Barang</div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $totalBarang }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Pelanggan</div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $totalPelanggan }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Total Pemasok</div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $totalPemasok }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Total Pembelian</div>
                    <div class="card-body">
                        <h3 class="card-title">Rp{{ number_format($totalPembelian, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="card">
                <div class="card-header">Kategori Barang Terbanyak</div>
                <div class="card-body">
                    @if($kategoriTerbanyak)
                        <h4>{{ $kategoriTerbanyak->nama_kategori }}</h4>
                        <p>Jumlah Barang: {{ $kategoriTerbanyak->barang_count }}</p>
                    @else
                        <p>Belum ada data kategori</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
