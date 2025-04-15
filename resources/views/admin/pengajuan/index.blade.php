@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar Pengajuan Barang</h1>
    
    <table class="table">
        <thead>
            <tr>
                <th>Nama Pengaju</th>
                <th>Nama Barang</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuan as $item)
            <tr>
                <td>{{ $item->nama_pengaju }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                <td>{{ $item->qty }}</td>
                <td>
                    <a href="{{ route('admin.pengajuan.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.pengajuan.destroy', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection