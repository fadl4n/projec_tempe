@extends('dashboard.layout.main')

@section('content')
<div class="container mt-5 bg-white rounded shadow-sm p-4">
    <div class="row mb-4">
        <!-- Gambar Produk -->
        <div class="col-md-4">
            <img id="productImage" src="{{ asset('storage/' . $keranjang->produk->gambar) }}" alt="{{ $keranjang->produk->nama_produk }}" class="img-fluid rounded">
        </div>
        <!-- Detail Produk -->
        <div class="col-md-8">
            <h1 id="productName" class="h4 fw-bold">{{ $keranjang->produk->nama_produk }}</h1>
            <p id="productPrice" class="text-danger h5 fw-bold">Rp{{ number_format($keranjang->produk->harga, 0, ',', '.') }}</p>
            <p class="text-muted">Stok: <span id="productStock">{{ $keranjang->produk->stok->jumlah ?? 'Tidak tersedia' }}</span></p>
        </div>
    </div>

    <!-- Form Update Keranjang -->
    <form action="{{ route('dashboard-keranjang.update', $keranjang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Input Jumlah -->
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <div class="input-group w-100">
                <button type="button" id="decrement" class="btn btn-outline-secondary">-</button>
                <input type="number" name="jumlah" id="jumlah" class="form-control text-center" value="{{ $keranjang->jumlah_keranjang }}" min="1">
                <button type="button" id="increment" class="btn btn-outline-secondary">+</button>
            </div>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-success btn-lg w-auto mb-3" style="background-color: #4CAF50; color: white;">Update Keranjang</button>
    </form>
</div>

<!-- Script untuk Pembaruan Jumlah Secara Dinamis -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jumlahInput = document.getElementById('jumlah');
        const productStock = document.getElementById('productStock');

        // Fungsi Increment/Decrement
        document.getElementById('increment').addEventListener('click', function () {
            let stokMax = parseInt(productStock.textContent);
            if (parseInt(jumlahInput.value) < stokMax) {
                jumlahInput.value = parseInt(jumlahInput.value) + 1;
            }
        });

        document.getElementById('decrement').addEventListener('click', function () {
            if (parseInt(jumlahInput.value) > 1) {
                jumlahInput.value = parseInt(jumlahInput.value) - 1;
            }
        });
    });
</script>
@endsection
