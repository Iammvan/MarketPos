@extends('layouts.admin')

@section('content')
<div class="container p-5">

    <form action="{{ route('pemasok.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Pemasok</label>
            <input type="text" name="nama_pemasok" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" name="telepon" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="catatan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('pemasok.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection