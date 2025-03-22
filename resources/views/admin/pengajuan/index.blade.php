@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Daftar Pengajuan Barang</h1>
        <a href="{{ route('admin.pengajuan.create') }}" class="btn btn-primary">Tambah Pengajuan</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nama Pengaju</th>
                    <th>Nama Barang</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                
            @foreach($AdminPengajuanBarang as $p)

                    <tr>
                        <td>{{ $p->nama_pengaju }}</td>
                        <td>{{ $p->nama_barang }}</td>
                        <td>{{ $p->tanggal_pengajuan }}</td>
                        <td>{{ $p->qty }}</td>
                        <td>{{ $p->terpenuhi ? 'Terpenuhi' : 'Belum Terpenuhi' }}</td>
                        <td>
                            <a href="{{ route('admin.pengajuan.edit', $p->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.pengajuan.destroy', $p->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
 