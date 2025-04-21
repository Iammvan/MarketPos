@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tambah Pengajuan Barang</h1>

    <form action="{{ route('pengajuan.store') }}" method="POST">
        @csrf

        <label>Nama Pengaju:</label><br>
        <input type="text" name="nama_pengaju" required><br><br>

        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" required><br><br>

        <label>Jumlah (Qty):</label><br>
        <input type="number" name="qty" required><br><br>

        <label>Tanggal Pengajuan:</label><br>
        <input type="date" name="tanggal_pengajuan" required><br><br>

        <label>Terpenuhi?</label>
        <input type="checkbox" name="terpenuhi" value="1"><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi"></textarea><br><br>

        <button type="submit">Simpan</button>
        <a href="{{ route('pengajuan.index') }}">Batal</a>
    </form>
</div>
@endsection
