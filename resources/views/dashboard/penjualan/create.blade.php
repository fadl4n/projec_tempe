@extends('dashboard.layouts.main')

@section('title', 'Tambah Data Penjualan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambahkan Data Penjualan</h1>
</div>

<div class="row">
    <div class="col-6">
        <form action="/dashboard-penjualan" method="post" enctype="multipart/form-data"> <!-- Tambah enctype -->
            @csrf

            <div class="mb-3">
                <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}">
                @error('nama_pelanggan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="alamat_pelanggan" class="form-label">Alamat Pelanggan</label>
                <input type="text" class="form-control @error('alamat_pelanggan') is-invalid @enderror" name="alamat_pelanggan" value="{{ old('alamat_pelanggan') }}">
                @error('alamat_pelanggan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <select class="form-select @error('nama_produk') is-invalid @enderror" name="nama_produk">
                    <option selected disabled>Pilih Nama Produk</option>
                    @foreach ($produk as $prod)
                        <option value="{{ $prod->nama_produk }}"
                            {{ old('nama_produk') == $prod->nama_produk ? 'selected' : '' }}>
                            {{ $prod->nama_produk }}
                        </option>
                    @endforeach
                </select>
                @error('nama_produk')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah_pesanan" class="form-label">Jumlah Pesanan</label>
                <input type="number" class="form-control @error('jumlah_pesanan') is-invalid @enderror" name="jumlah_pesanan" value="{{ old('jumlah_pesanan') }}">
                @error('jumlah_pesanan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="metode_pengiriman" class="form-label">Metode Pengiriman</label>
                <select name="metode_pengiriman" class="form-select @error('metode_pengiriman') is-invalid @enderror">
                    <option value="dijemput" {{ old('metode_pengiriman', $penjualan->metode_pengiriman ?? '') == 'dijemput' ? 'selected' : '' }}>dijemput</option>
                    <option value="diantar" {{ old('metode_pengiriman', $penjualan->metode_pengiriman ?? '') == 'diantar' ? 'selected' : '' }}>diantar</option>
                </select>
                @error('metode_pengiriman')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="form-select @error('metode_pembayaran') is-invalid @enderror">
                    <option value="cash" {{ old('metode_pembayaran', $penjualan->metode_pembayaran ?? '') == 'cash' ? 'selected' : '' }}>cash</option>
                    <option value="rekening" {{ old('metode_pembayaran', $penjualan->metode_pembayaran ?? '') == 'rekening' ? 'selected' : '' }}>rekening</option>
                </select>
                @error('metode_pembayaran')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control @error('tgl_transaksi') is-invalid @enderror" name="tgl_transaksi" value="{{ old('tgl_transaksi') }}">
                @error('tgl_transaksi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    <div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select class="form-select @error('status') is-invalid @enderror" name="status">
        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>pending</option>
        <option value="proses" {{ old('status') == 'proses' ? 'selected' : '' }}>Proses</option>
        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
    </select>
    @error('status')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tombol Update dengan ukuran kecil -->
            <button type="submit" class="btn" style="background-color: #4CAF50; color: white;">Tambah</button>
        </form>
    </div>
</div>
@endsection
