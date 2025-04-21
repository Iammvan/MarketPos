@extends('layouts.admin')

@section('content')
<div class="container p-5">
    <a href="{{ route('pemasok.create') }}" class="btn btn-primary mb-3">Tambah Pemasok</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemasoks as $key => $pemasok)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $pemasok->nama_pemasok }}</td>
                <td>{{ $pemasok->alamat }}</td>
                <td>{{ $pemasok->telepon }}</td>
                <td>{{ $pemasok->email }}</td>
                <td>
                    <a href="{{ route('pemasok.show', $pemasok->id) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('pemasok.edit', $pemasok->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pemasok.destroy', $pemasok->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin ingin menghapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection