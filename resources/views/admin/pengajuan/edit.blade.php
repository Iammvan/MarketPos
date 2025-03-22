@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Pengajuan Barang</h1>

        <form action="{{ route('admin.pengajuan.update', $AdminPengajuanBarang->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_pengaju">Nama Pengaju</label>
                <input type="text" name="nama_pengaju" class="form-control" value="{{ $AdminPengajuanBarang->nama_pengaju }}" required>
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ $AdminPengajuanBarang->nama_barang }}" required>
            </div>
            <div class="form-group">
                <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                <input type="date" name="tanggal_pengajuan" class="form-control" value="{{ $AdminPengajuanBarang->tanggal_pengajuan }}" required>
            </div>
            <div class="form-group">
                <label for="qty">Jumlah</label>
                <input type="number" name="qty" class="form-control" value="{{ $AdminPengajuanBarang->qty }}" required>
            </div>
            <button type="submit" class="btn btn-success">Perbarui</button>
        </form>
    </div>
@endsection
