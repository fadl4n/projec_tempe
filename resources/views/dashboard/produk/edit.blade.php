@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Data Produk</h1>
    </div>
    <div class="row">
        <div class="col-6">
            <form action="/dashboard-produk/{{ $produk->id }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Gambar</label>
                    <input type="file"
                        class="form-control @error('gambar') is-invalid @enderror"
                        name="gambar"
                        accept="image/*">
                    @if($produk->gambar)
                        <small class="text-muted">Gambar saat ini: <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" width="100"></small>
                    @endif
                    @error('gambar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Kode Produk</label>
                    <input type="text" placeholder="masukkan kode produk"
                        class="form-control @error('kode_produk') is-invalid @enderror"
                        name="kode_produk"
                        value="{{ old('kode_produk', $produk->kode_produk) }}">
                    @error('kode_produk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nama Produk</label>
                    <input type="text" placeholder="masukkan nama produk"
                        class="form-control @error('nama_produk') is-invalid @enderror"
                        name="nama_produk"
                        value="{{ old('nama_produk', $produk->nama_produk) }}">
                    @error('nama_produk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Harga</label>
                    <input type="number" placeholder="masukkan harga"
                        class="form-control @error('harga') is-invalid @enderror"
                        name="harga"
                        value="{{ old('harga', $produk->harga) }}">
                    @error('harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Deskripsi</label>
                    <textarea placeholder="masukkan deskripsi"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        name="deskripsi">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn" style="background-color: #4CAF50; color: white;">Update</button>
            </form>
        </div>
    </div>
@endsection
