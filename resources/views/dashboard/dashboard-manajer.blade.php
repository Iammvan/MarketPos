@extends('layouts.manajer')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Dashboard Manajer</h1>

        <div class="row">
            <!-- Total Barang -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Barang</div>
                    <div class="card-body">
                        <h3 class="card-title">{{ number_format($totalBarang) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Pemasukan -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Pemasukan</div>
                    <div class="card-body">
                        <h3 class="card-title">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Pengeluaran -->
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Total Pengeluaran</div>
                    <div class="card-body">
                        <h3 class="card-title">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Penjualan Hari Ini -->
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Penjualan Hari Ini</div>
                    <div class="card-body">
                        <h3 class="card-title">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <!-- Penjualan Bulanan -->
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Penjualan Bulan Ini</div>
                    <div class="card-body">
                        <h3 class="card-title">Rp {{ number_format($penjualanBulanan, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <!-- Pembelian Bulanan -->
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-header">Pembelian Bulan Ini</div>
                    <div class="card-body">
                        <h3 class="card-title">Rp {{ number_format($pembelianBulanan, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
