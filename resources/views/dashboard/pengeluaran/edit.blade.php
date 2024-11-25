@extends('dashboard.layouts.main')
@section('title', 'Edit Data Pengeluaran')

@section('content')
    <h1 class="mb-5">Edit Data Pengeluaran</h1>

    <form action="/dashboard-pengeluaran/{{ $pengeluaran->id }}" method="POST">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Bahan</label>
            <input type="text" name="nama_barang" id="nama_barang"
                   class="form-control @error('nama_barang') is-invalid @enderror"
                   value="{{ old('nama_barang', $pengeluaran->nama_barang) }}" required>
            @error('nama_barang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah"
                   class="form-control @error('jumlah') is-invalid @enderror"
                   value="{{ old('jumlah', $pengeluaran->jumlah) }}" required>
            @error('jumlah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan</label>
            <input type="text" name="satuan" id="satuan"
                   class="form-control @error('satuan') is-invalid @enderror"
                   value="{{ old('satuan', $pengeluaran->satuan) }}" required>
            @error('satuan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="ttl_harga" class="form-label">Total Harga</label>
            <input type="number" name="ttl_harga" id="ttl_harga"
                   class="form-control @error('ttl_harga') is-invalid @enderror"
                   value="{{ old('ttl_harga', $pengeluaran->ttl_harga) }}" required>
            @error('ttl_harga')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal"
                   class="form-control @error('tanggal') is-invalid @enderror"
                   value="{{ old('tanggal', $pengeluaran->tanggal) }}" required>
            @error('tanggal')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Data</button>
        <a href="/dashboard-pengeluaran" class="btn" style="background-color: #4CAF50; color: white;">Batal</a>
    </form>
@endsection
