@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Pengajuan Barang</h1>

    <form action="{{ route('pengajuan.update', $pengajuan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Pengaju:</label><br>
        <input type="text" name="nama_pengaju" value="{{ $pengajuan->nama_pengaju }}" required><br><br>

        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" value="{{ $pengajuan->nama_barang }}" required><br><br>

        <label>Jumlah (Qty):</label><br>
        <input type="number" name="qty" value="{{ $pengajuan->qty }}" required><br><br>

        <label>Tanggal Pengajuan:</label><br>
        <input type="date" name="tanggal_pengajuan" value="{{ $pengajuan->tanggal_pengajuan }}" required><br><br>

        <label>Terpenuhi?</label>
        <input type="checkbox" name="terpenuhi" value="1" {{ $pengajuan->terpenuhi ? 'checked' : '' }}><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi">{{ $pengajuan->deskripsi }}</textarea><br><br>

        <button type="submit">Update</button>
        <a href="{{ route('pengajuan.index') }}">Batal</a>
    </form>
</div>
@endsection
