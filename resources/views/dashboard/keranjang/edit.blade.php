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

        <!-- Pilihan Produk -->
        <div class="mb-3">
            <label for="produk" class="form-label">Pilih Produk</label>
            <div class="btn-group w-100" role="group">
                @foreach ($produkList as $produk) <!-- Looping semua produk -->
                    <button type="button" class="btn btn-outline-primary produk-option {{ $produk->id == $keranjang->produk->id ? 'active' : '' }}"
                            data-name="{{ $produk->nama_produk }}"
                            data-price="{{ $produk->harga }}"
                            data-stock="{{ $produk->stok->jumlah }}"
                            data-image="{{ asset('storage/' . $produk->gambar) }}">
                        {{ $produk->nama_produk }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Hidden Input untuk Nama Produk -->
        <input type="hidden" name="nama_produk" id="selectedProductName" value="{{ $keranjang->produk->nama_produk }}">

        <!-- Input Jumlah -->


<div class="mb-3">
    <label for="jumlah" class="form-label">jumlah</label>
    <div class="input-group w-100">
        <button type="button" id="decrement" class="btn btn-outline-secondary">-</button>
        <input type="number" name="jumlah" id="jumlah" class="form-control text-center" value="{{ $keranjang->jumlah_keranjang }}" min="1">
        <button type="button" id="increment" class="btn btn-outline-secondary">+</button>
    </div>
</div>

         <!-- Tombol Submit -->
         <button type="submit" class="btn btn-success btn-lg w-auto mb-3" style="background-color: #4CAF50; color: white;">Masukkan Keranjang</button>
    </form>
</div>

<!-- Script untuk Pembaruan Produk Secara Dinamis -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productButtons = document.querySelectorAll('.produk-option');
        const productName = document.getElementById('productName');
        const productPrice = document.getElementById('productPrice');
        const productStock = document.getElementById('productStock');
        const productImage = document.getElementById('productImage');
        const jumlahInput = document.getElementById('jumlah');
        const selectedProductName = document.getElementById('selectedProductName');

        productButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Update Detail Produk
                productName.textContent = this.getAttribute('data-name');
                productPrice.textContent = 'Rp' + parseInt(this.getAttribute('data-price')).toLocaleString('id-ID');
                productStock.textContent = this.getAttribute('data-stock');
                productImage.src = this.getAttribute('data-image');
                selectedProductName.value = this.getAttribute('data-name');

                // Reset jumlah ke 1
                jumlahInput.value = 1;

                // Hapus status aktif dari tombol lain dan tambahkan ke yang dipilih
                productButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
            });
        });

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
