@extends('dashboard.layout.main')

@section('content')
    <div class="container mt-5 bg-white rounded shadow-md p-4 mb-5">
        <h1 class="h4 font-weight-bold">Form Checkout</h1>

        <!-- Form Checkout -->
        <form action="{{ route('bayar.process') }}" method="POST">
            @csrf

            <!-- Input Nama Pelanggan (disembunyikan) -->
            <input type="hidden" name="nama_pelanggan" value="{{ Auth::user()->name }}">

               <!-- Input status (hidden) -->
        <input type="hidden" name="status" value="pending">

            <!-- Menampilkan Total Harga -->
            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="text" id="total_harga" name="total_harga" class="form-control" readonly value="Rp{{ number_format($total_harga, 0, ',', '.') }}">
            </div>

            <!-- Pilih Metode Pengiriman -->
            <div class="mb-3">
                <label for="metode_pengiriman" class="form-label">Metode Pengiriman</label>
                <select id="metode_pengiriman" name="metode_pengiriman" class="form-select" required>
                    <option value="" disabled selected>Pilih Metode Pengiriman</option>
                    <option value="dijemput">Dijemput</option>
                    <option value="diantar">Diantar</option>
                </select>
            </div>

            <!-- Pilih Metode Pembayaran -->
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select id="metode_pembayaran" name="metode_pembayaran" class="form-select" required>
                    <option value="" disabled selected>Pilih Metode Pembayaran</option>
                    <option value="cash">Cash</option>
                    <option value="rekening">Rekening</option>
                </select>
            </div>

            <!-- Input Alamat Pelanggan -->
            <div class="mb-3">
                <label for="alamat_pelanggan" class="form-label">Alamat Pelanggan</label>
                <textarea id="alamat_pelanggan" name="alamat_pelanggan" class="form-control" rows="3" placeholder="Isi alamat jika metode pengiriman adalah diantar" required></textarea>
            </div>

            <!-- Menyimpan Data Produk dalam Keranjang -->
            @foreach ($keranjang as $item)
                <input type="hidden" name="nama_produk[]" value="{{ $item->nama_produk }}">
                <input type="hidden" name="harga[]" value="{{ $item->harga }}">
                <input type="hidden" name="jumlah[]" value="{{ $item->jumlah_keranjang }}">
                <input type="hidden" name="total_harga_keranjang[]" value="{{ $item->total_harga_keranjang }}">
            @endforeach

            <!-- Tombol Submit untuk Checkout -->
            <button type="submit" class="btn btn-primary">Bayar</button>
        </form>
    </div>
@endsection
