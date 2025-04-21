@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-3">

            <!-- Aksi -->
            <div class="d-flex flex-wrap gap-2">
                <button onclick="openCreateModal()" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Tambah Absensi
                </button>

                <a href="{{ route('absensi.export.pdf') }}" class="btn btn-danger d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>

                <a href="{{ route('absensi.export.excel') }}" class="btn btn-success d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
            </div>

            <!-- Import -->
            <form action="{{ route('absensi.import') }}" method="POST" enctype="multipart/form-data"
                class="d-flex align-items-end gap-2">
                @csrf
                <input type="file" name="file" required class="form-control" style="max-width: 200px;">
                <button type="submit" class="btn btn-outline-success">
                    <i class="bi bi-upload"></i> Import
                </button>
            </form>

            <!-- Filter -->
            <form method="GET" class="d-flex align-items-end gap-2 flex-wrap">
                <input type="text" name="search" class="form-control" placeholder="Cari nama..."
                    value="{{ request('search') }}">
                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                <button class="btn btn-outline-primary"><i class="bi bi-funnel-fill"></i> Filter</button>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Masuk</th>
                        <th>Status</th>
                        <th>Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absensis as $absen)
                        <tr>
                            <td>{{ $absen->nama_karyawan }}</td>
                            <td>{{ $absen->tanggal_masuk }}</td>
                            <td>{{ $absen->waktu_masuk }}</td>
                            <td>
                                <form action="{{ route('absensi.update', $absen->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="masuk" {{ $absen->status === 'masuk' ? 'selected' : '' }}>Masuk
                                        </option>
                                        <option value="sakit" {{ $absen->status === 'sakit' ? 'selected' : '' }}>Sakit
                                        </option>
                                        <option value="cuti" {{ $absen->status === 'cuti' ? 'selected' : '' }}>Cuti
                                        </option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                @if ($absen->status === 'masuk' && $absen->waktu_kerja_selesai === '00:00:00')
                                    <form id="selesaiForm-{{ $absen->id }}"
                                        action="{{ route('absensi.selesai', $absen->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" onclick="confirmSelesai({{ $absen->id }})"
                                            class="btn btn-sm btn-success">Selesai</button>
                                    </form>
                                @else
                                    {{ $absen->waktu_kerja_selesai }}
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button onclick='openEditModal(@json($absen))'
                                        class="btn btn-sm btn-warning">Edit</button>

                                    <form id="deleteForm-{{ $absen->id }}"
                                        action="{{ route('absensi.destroy', $absen->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $absen->id }})"
                                            class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('absensi.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Karyawan</label>
                            <input type="text" name="nama_karyawan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="masuk">Masuk</option>
                                <option value="sakit">Sakit</option>
                                <option value="cuti">Cuti</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Karyawan</label>
                            <input type="text" name="nama_karyawan" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" id="edit_tanggal" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="edit_status" class="form-select" required>
                                <option value="masuk">Masuk</option>
                                <option value="sakit">Sakit</option>
                                <option value="cuti">Cuti</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Modal JS -->
    <script>
        function openCreateModal() {
            new bootstrap.Modal(document.getElementById('createModal')).show();
        }

        function openEditModal(absen) {
            document.getElementById('edit_nama').value = absen.nama_karyawan;
            document.getElementById('edit_tanggal').value = absen.tanggal_masuk;
            document.getElementById('edit_status').value = absen.status;

            let form = document.getElementById('editForm');
            form.action = `/absensi/${absen.id}`;

            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        function confirmDelete(id) {
            if (confirm('Yakin ingin menghapus data ini?')) {
                document.getElementById(`deleteForm-${id}`).submit();
            }
        }

        function confirmSelesai(id) {
            if (confirm('Selesaikan absensi sekarang?')) {
                document.getElementById(`selesaiForm-${id}`).submit();
            }
        }
    </script>
@endsection
