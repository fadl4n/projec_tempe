@extends('dashboard.layout.main')

@section('title', 'Produk Kami')

@section('content')
<h1 class="text-center mb-6">Produk</h1>
<div class="container">

    <div class="row">
        @foreach($produks as $produk)
            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center shadow-sm">
                    <!-- Gambar Produk -->
                    <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama_produk }}" style="height: 200px; object-fit: cover;">

                    <!-- Detail Produk -->
                    <div class="card-body">
                        <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                        <p class="card-text text-muted">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>

                        <!-- Tombol-tombol dalam satu baris -->
                        <div class="d-flex justify-content-between">
                             <!-- Tombol Pesan dengan emotikon -->
                             <a href="{{ route('dashboard-detail.show', $produk->id) }}" class="btn btn-success btn-sm flex-grow-1 mx-1" target="_blank">
                                <i class="bi bi-chat-dots"></i> Detail  
                            </a>
                            <!-- Tombol Beli -->

                            <!-- Tombol Keranjang (ikon keranjang) -->
                            <a href="{{ route('dashboard-keranjang.create', $produk->id) }}" class="btn btn-warning btn-sm flex-grow-1 mx-1">
                                <i class="bi bi-cart-fill"></i> Keranjang
                            </a>
                            <a href="{{ route('dashboard-keranjang.create', $produk->id) }}" class="btn btn-danger btn-sm flex-grow-1 mx-1">
                                <i class="bi bi-cart-plus"></i> Beli
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $produks->links() }}
    </div>
</div>
@endsection
