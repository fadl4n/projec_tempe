@extends('dashboard.layout.main')

@section('content')
<div class="container mt-5 bg-white rounded shadow-md p-4 mb-5">
    <div class="row mb-4">
        <div class="col-4">
            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="img-fluid rounded">
        </div>
        <div class="col-8">
            <h1 class="h4 font-weight-bold">{{ $produk->nama_produk }}</h1>
            <p class="text-danger h5 font-weight-bold">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
            <p class="text-muted">Stok: {{ $produk->stok->jumlah ?? 'Tidak tersedia' }}</p>
            <p class="text-muted">Keterangan: {{ $produk->deskripsi }}</p>

            @if($produk->stok->jumlah == 0)
                <p class="text-danger">Stok produk ini tidak mencukupi untuk melakukan pembelian.</p>
            @endif
        </div>
    </div>

    <!-- Form Gabungan Tambah ke Keranjang dan Beli Sekarang -->
    <form action="{{ route('dashboard-keranjang.store') }}" method="POST" class="mb-3">
        @csrf
        <input type="hidden" name="nama_produk" value="{{ $produk->nama_produk }}">
        <input type="hidden" name="name" value="{{ Auth::user()->name }}"> <!-- Menyimpan nama pengguna yang sedang login -->
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" value="1" min="1" max="{{ $produk->stok->jumlah }}" class="form-control" required onchange="updateTotalHarga()">
        </div>
        <button type="submit" class="btn btn-warning btn-lg w-auto me-2" style="color: white;" id="keranjangButton" {{ $produk->stok->jumlah == 0 ? 'disabled' : '' }}>
            <i class="bi bi-cart-fill"></i> Tambahkan ke Keranjang
        </button>
    </form>

    <!-- Form Beli Sekarang -->
    <form action="{{ route('checkout.index') }}" method="GET" class="d-inline">
        @csrf
        <input type="hidden" name="nama_produk" value="{{ $produk->nama_produk }}">
        <input type="hidden" name="nama_pelanggan" value="{{ Auth::user()->name }}">

        <!-- Tidak ada lagi input jumlah terpisah, kita hanya menggunakan satu input jumlah -->
        <input type="hidden" name="jumlah" id="jumlahBeli">
        <input type="hidden" name="total_harga" value="{{ $produk->harga }}" id="totalHarga"> <!-- Nilai awal total harga adalah harga per produk -->

        <button type="submit" class="btn btn-danger btn-lg w-auto" id="beliButton" {{ $produk->stok->jumlah == 0 ? 'disabled' : '' }}>
            <i class="bi bi-cart-plus"></i> Beli Sekarang
        </button>
    </form>

    <!-- Pesan stok tidak mencukupi -->
    <div id="stokMessage" class="text-danger mt-3" style="display:none;">
        <p>Stok produk ini tidak mencukupi untuk jumlah yang Anda pilih.</p>
    </div>

    <script>
        // Fungsi untuk set jumlah dan total harga
        function updateTotalHarga() {
            const jumlah = document.getElementById('jumlah').value;

            // Update jumlah untuk form Beli Sekarang
            document.getElementById('jumlahBeli').value = jumlah;

            // Update total harga untuk form Beli Sekarang
            const hargaPerProduk = {{ $produk->harga }};
            const totalHarga = hargaPerProduk * jumlah;
            document.getElementById('totalHarga').value = totalHarga;
        }

        // Fungsi untuk mengecek apakah jumlah lebih besar dari stok
        function checkStok() {
            const jumlah = document.getElementById('jumlah').value;
            const stokMax = {{ $produk->stok->jumlah }}; // Mengambil stok maksimum
            const stokMessage = document.getElementById('stokMessage');
            const keranjangButton = document.getElementById('keranjangButton');
            const beliButton = document.getElementById('beliButton');

            if (parseInt(jumlah) > stokMax) {
                stokMessage.style.display = 'block';  // Tampilkan pesan stok tidak mencukupi
                keranjangButton.disabled = true;  // Nonaktifkan tombol "Tambahkan ke Keranjang"
                beliButton.disabled = true;      // Nonaktifkan tombol "Beli Sekarang"
            } else {
                stokMessage.style.display = 'none';   // Sembunyikan pesan jika stok cukup
                keranjangButton.disabled = false;  // Aktifkan tombol "Tambahkan ke Keranjang"
                beliButton.disabled = false;      // Aktifkan tombol "Beli Sekarang"
            }
        }

        // Panggil updateTotalHarga dan checkStok saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            updateTotalHarga();  // Set total harga saat halaman pertama kali dimuat
            checkStok();  // Cek stok saat halaman dimuat
        });
    </script>
</div>
@endsection
