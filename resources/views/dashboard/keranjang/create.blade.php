@extends('dashboard.layout.main')

@section('content')
<div class="container mt-5 bg-white rounded shadow-md p-4">
    <div class="row mb-4">
        <div class="col-4">
            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="img-fluid rounded">
        </div>
        <div class="col-8">
            <h1 class="h4 font-weight-bold">{{ $produk->nama_produk }}</h1>
            <p class="text-danger h5 font-weight-bold">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
            <p class="text-muted">Stok: {{ $produk->stok->jumlah ?? 'Tidak tersedia' }}</p>
        </div>
    </div>

    <!-- Form Tambah ke Keranjang -->
    <form action="{{ route('dashboard-keranjang.store', $produk->id) }}" method="POST">
        @csrf
        <input type="hidden" name="nama_produk" value="{{ $produk->id }}">

        <!-- Input Jumlah -->
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <div class="input-group">
                <button type="button" id="decrement" class="btn btn-outline-secondary">-</button>
                <input type="number" name="jumlah" id="jumlah" class="form-control text-center col-auto" value="1" min="1" max="{{ $produk->stok->jumlah }}">
                <button type="button" id="increment" class="btn btn-outline-secondary">+</button>
            </div>
        </div>

    

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-success btn-lg w-auto mb-3" style="background-color: #4CAF50; color: white;">Masukkan Keranjang</button>
    </form>
</div>

<!-- Script untuk Increment/Decrement -->
<script>
    document.getElementById('increment').addEventListener('click', function () {
        let jumlahInput = document.getElementById('jumlah');
        let stokMax = {{ $produk->stok->jumlah }}; // Mengambil stok yang benar
        if (parseInt(jumlahInput.value) < stokMax) {
            jumlahInput.value = parseInt(jumlahInput.value) + 1;
        }
    });

    document.getElementById('decrement').addEventListener('click', function () {
        let jumlahInput = document.getElementById('jumlah');
        if (parseInt(jumlahInput.value) > 1) {
            jumlahInput.value = parseInt(jumlahInput.value) - 1;
        }
    });
</script>
@endsection
