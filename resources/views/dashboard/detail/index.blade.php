@extends('dashboard.layout.main')

@section('title', 'Detail Produk')

@section('content')
<div class="container" style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <h1 class="text-center mb-4">Detail Produk</h1>

    <div class="card shadow-sm" style="background-color: #fff; border: none;">
        <div class="row no-gutters">
            <!-- Gambar Produk dengan efek hover -->
            <div class="col-md-4">
                <img src="{{ asset('storage/' . $produk->gambar) }}"
                     class="card-img-top rounded-3"
                     alt="{{ $produk->nama_produk }}"
                     style="height: 350px; object-fit: cover; transition: transform 0.3s ease;">
            </div>

            <!-- Keterangan Produk -->
            <div class="col-md-8 d-flex flex-column justify-content-between">
                <div class="card-body">
                    <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                    <p class="card-text text-muted">Harga: Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>

                    <!-- Menampilkan stok -->
                    <p class="card-text text-muted">Stok Tersedia: {{ $produk->stok ? $produk->stok->jumlah : 'Tidak Tersedia' }}</p>

                    <!-- Menampilkan deskripsi -->
                    <p class="card-text"><strong>Keterangan: </strong>{{ $produk->deskripsi }}</p>
                </div>

                <!-- Tombol Kembali ke Produk -->
                <a href="{{ route('dashboard-dash-user.index') }}"
                   class="btn btn-sm align-self-start mb-3"
                   style="background-color: #4CAF50; color: white;">
                   Kembali ke Produk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <style>
        /* Background Halaman */
        body {
            background-color: #f9f9f9; /* Latar belakang putih terang */
        }

        /* Background Container */
        .container {
            margin-top: 30px;
        }

        /* Efek hover pada gambar produk */
        .card-img-top:hover {
            transform: scale(1.05); /* Zoom in sedikit saat hover */
        }

        /* Penataan margin dan padding card */
        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
        }

        /* Tombol */
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        /* Menata tombol di bawah dan sejajar dengan informasi produk */
        .d-flex {
            display: flex;
        }

        .flex-column {
            flex-direction: column;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-self-start {
            align-self: flex-start;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }
    </style>
@endsection
