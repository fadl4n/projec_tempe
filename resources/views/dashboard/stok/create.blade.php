@extends('dashboard.layouts.main')

@section('content')
<h1 class="mb-5">Input Data Stok</h1>

<div class="row">
    <div class="col-6">
        <form action="/dashboard-stok" method="post">
            @csrf
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <select class="form-select @error('nama_produk') is-invalid @enderror" name="nama_produk">
                    <option selected disabled>Pilih Nama Produk</option>
                    @foreach ($produk as $prod)
                        <option value="{{ $prod->nama_produk }}">{{ $prod->nama_produk }}</option>
                    @endforeach
                </select>
                @error('nama_produk')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" placeholder="masukkan jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}">
                @error('jumlah')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn" style="background-color: #4CAF50; color: white;"> Submit</button>
        </form>
    </div>
</div>
@endsection
