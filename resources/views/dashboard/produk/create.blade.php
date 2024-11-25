@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Input Data Produk</h1>
    </div>
    <div class="row">
        <div class="col-6">
            <form action="/dashboard-produk" method="post" enctype="multipart/form-data"> <!-- Tambah enctype -->
                @csrf
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input type="file"
                        class="form-control @error('gambar') is-invalid @enderror"
                        name="gambar"
                        accept="image/*">
                    @error('gambar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="kode_produk" class="form-label">Kode Produk</label>
                    <input type="text" placeholder="masukkan kode produk"
                        class="form-control @error('kode_produk') is-invalid @enderror"
                        name="kode_produk"
                        value="{{ old('kode_produk') }}">
                    @error('kode_produk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nama_produk" class="form-label">Nama Produk</label>
                    <input type="text" placeholder="masukkan nama produk"
                        class="form-control @error('nama_produk') is-invalid @enderror"
                        name="nama_produk"
                        value="{{ old('nama_produk') }}">
                    @error('nama_produk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" placeholder="masukkan harga"
                        class="form-control @error('harga') is-invalid @enderror"
                        name="harga"
                        value="{{ old('harga') }}">
                    @error('harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                              name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn" style="background-color: #4CAF50; color: white;">Submit</button>
            </form>
        </div>
    </div>
@endsection
