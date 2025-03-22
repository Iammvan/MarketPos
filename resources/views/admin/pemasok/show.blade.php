@extends('layouts.admin')

@section('content')
<div class="container p-5">

    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <td>{{ $pemasok->nama_pemasok }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $pemasok->alamat }}</td>
        </tr>
        <tr>
            <th>Telepon</th>
            <td>{{ $pemasok->telepon }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $pemasok->email }}</td>
        </tr>
        <tr>
            <th>Catatan</th>
            <td>{{ $pemasok->catatan }}</td>
        </tr>
    </table>

    <a href="{{ route('pemasok.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection