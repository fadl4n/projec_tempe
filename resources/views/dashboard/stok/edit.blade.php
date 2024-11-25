@extends('dashboard.layouts.main')

@section('title', 'Data Stok')

@section('content')
<h1></h1>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Data Stok</h1>
</div>
<div class="row">
    <div class="col-6">
        <form action="/dashboard-stok/{{ $stok->id }}" method="post">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nama Produk</label>
                <select class="form-select @error('nama_produk') is-invalid @enderror" name="nama_produk">
                    <option selected disabled>Pilih Nama Produk</option>
                    @foreach ($produk as $produkItem)
                        <option value="{{ $produkItem->nama_produk }}"
                            {{ (old('nama_produk') == $produkItem->nama_produk || $stok->nama_produk == $produkItem->nama_produk) ? 'selected' : '' }}>
                            {{ $produkItem->nama_produk }}
                        </option>
                    @endforeach
                </select>
                @error('nama_produk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" placeholder="Masukkan jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah', $stok->jumlah) }}">
                @error('jumlah')
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
