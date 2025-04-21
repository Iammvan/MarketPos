@extends('layouts.admin')

@section('content')
<div class="container p-5">

    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection