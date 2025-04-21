@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Daftar Pengajuan Barang</h1>

        @if (session('success'))
            <div style="color: green;">{{ session('success') }}</div>
        @endif

        <a href="{{ route('pengajuan.create') }}">+ Tambah Pengajuan</a>

        <table border="1" cellpadding="8" cellspacing="0" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengaju</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Tanggal</th>
                    <th>Terpenuhi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengajuans as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_pengaju }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->tanggal_pengajuan }}</td>
                        <td>{{ $item->terpenuhi ? 'Ya' : 'Belum' }}</td>
                        <td>
                            <a href="{{ route('pengajuan.show', $item->id) }}">Lihat</a> |
                            <a href="{{ route('pengajuan.edit', $item->id) }}">Edit</a> |
                            <form action="{{ route('pengajuan.destroy', $item->id) }}" method="POST"
                                style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: red;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
