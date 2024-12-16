@extends('dashboard.layout.main')

@section('title', 'Produk Kami')

@section('content')
<h1 class="text-center mb-6">Produk</h1>
<div class="container">
    <div class="row">
        @foreach($produks as $produk)
            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center shadow-sm">
                    <!-- Gambar Produk dengan Link ke Produk Detail -->
                    <a href="{{ route('dashboard-keranjang.create', $produk->id) }}">
                        <img src="{{ asset('storage/' . $produk->gambar) }}"
                             class="card-img-top"
                             alt="{{ $produk->nama_produk }}"
                             style="height: 200px; object-fit: cover;">
                    </a>

                    <!-- Detail Produk -->
                    <div class="card-body">
                        <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                        <p class="card-text text-danger">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
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
