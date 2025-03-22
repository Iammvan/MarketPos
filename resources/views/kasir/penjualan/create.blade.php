@extends('layouts.kasir')
@section('styles')
<style>
    .barang-card {
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 10px;
        overflow: hidden;
    }
    .barang-card:hover {
        transform: scale(1.05);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
    .card-img-top {
        height: 150px;
        object-fit: cover;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .btn-hapus {
        transition: 0.3s;
    }
    .btn-hapus:hover {
        background-color: #dc3545;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Tambah Penjualan</h2>
    
    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <select class="form-control" name="pelanggan_id" required>
                <option value=""> Pilih Member </option>
                @foreach($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        
        <div class="row">
            @foreach($barangs as $barang)
            <div class="col-md-3 mb-4">
                <div class="card barang-card" onclick="tambahItem({{ $barang->id }}, '{{ $barang->nama_barang }}', {{ $barang->harga_jual }}, {{ $barang->stok }})">
                    <img src="{{ asset('storage/' . $barang->gambar) }}" class="card-img-top" alt="{{ $barang->nama_barang }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                        <p class="text-muted">Stok: {{ $barang->stok }}</p>
                        <p class="fw-bold text-primary">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <table class="table table-bordered table-hover" id="keranjang">
            <thead class="table-light">
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        
        <input type="hidden" name="total_bayar" id="total_bayar" value="0">
        
        <button type="submit" class="btn btn-success w-100">Simpan Transaksi</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    let keranjang = [];
    
    function tambahItem(id, nama, harga, stok) {
        let existing = keranjang.find(item => item.id === id);
        if (existing) {
            if (existing.jumlah < stok) {
                existing.jumlah++;
            } else {
                alert('Stok tidak mencukupi!');
                return;
            }
        } else {
            keranjang.push({ id, nama, harga, jumlah: 1, stok });
        }
        updateKeranjang();
    }
    
    function updateKeranjang() {
        let tbody = document.querySelector('#keranjang tbody');
        tbody.innerHTML = '';
        let total = 0;
        keranjang.forEach((item, index) => {
            let subtotal = item.harga * item.jumlah;
            total += subtotal;
            tbody.innerHTML += `
                <tr>
                    <td>${item.nama} <input type="hidden" name="items[${index}][barang_id]" value="${item.id}"></td>
                    <td>Rp ${item.harga.toLocaleString()}</td>
                    <td>
                        <input type="number" class="form-control text-center" name="items[${index}][jumlah]" value="${item.jumlah}" min="1" max="${item.stok}" onchange="ubahJumlah(${index}, this.value)">
                    </td>
                    <td>Rp ${subtotal.toLocaleString()}</td>
                    <td><button type="button" class="btn btn-outline-danger btn-sm btn-hapus" onclick="hapusItem(${index})">Hapus</button></td>
                </tr>
            `;
        });
        document.getElementById('total_bayar').value = total;
    }
    
    function ubahJumlah(index, jumlah) {
        jumlah = parseInt(jumlah);
        if (jumlah < 1) jumlah = 1;
        if (jumlah > keranjang[index].stok) {
            alert('Stok tidak mencukupi!');
            jumlah = keranjang[index].stok;
        }
        keranjang[index].jumlah = jumlah;
        updateKeranjang();
    }
    
    function hapusItem(index) {
        keranjang.splice(index, 1);
        updateKeranjang();
    }
</script>