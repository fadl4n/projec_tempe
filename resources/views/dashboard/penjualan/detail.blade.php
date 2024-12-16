@extends('dashboard.layouts.main')
@section('title', 'Detail Penjualan')
@section('content')

<h1 class="mb-5">Detail Pesanan</h1>

<div class="card p-4 mb-4">
    <h5 class="card-title">Rincian Pesanan</h5>
    <div class="row">
        <div class="col-md-6">
            <p>
                <i class="bi bi-person"></i> <strong>Nama:</strong> {{ $penjualan->nama_pelanggan }}
            </p>
            <p>
                <i class="bi bi-credit-card"></i> <strong>Metode Pembayaran:</strong> {{ ucfirst($penjualan->metode_pembayaran) }}
            </p>
            <p>
                <i class="bi bi-truck"></i> <strong>Metode Pengiriman:</strong> {{ ucfirst($penjualan->metode_pengiriman) }}
            </p>
            <p>
                <i class="bi bi-geo-alt"></i> <strong>Alamat:</strong> {{ $penjualan->alamat_pelanggan }}
            </p>
            <!-- Pindahkan Total Harga ke bawah Alamat -->
            <p class="fs-4"><strong>Total Harga:</strong> Rp{{ number_format($penjualan->total_harga, 0, ',', '.') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <!-- Kolom kanan kosong -->
        </div>
    </div>
</div>

<div class="card p-4">
    <h5 class="card-title">Pesanan Customer</h5>
    @foreach($produk as $item)
        <div class="row mb-4 align-items-center">
            <div class="col-md-2">
                <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->nama_produk }}" class="img-fluid rounded">
            </div>
            <div class="col-md-10">
                <h6 class="mb-1"><strong>{{ $item->nama_produk }}</strong></h6>
                <p>
                    <strong>Jumlah Pesanan:</strong> {{ $penjualan->jumlah_pesanan }}<br>
                    <strong>Harga:</strong> Rp{{ number_format($item->harga, 0, ',', '.') }}<br>
                    <strong>Deskripsi:</strong> {{ $item->deskripsi }}
                </p>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-3">
    @if ($penjualan->status == 'pending')
        <form action="{{ route('dashboard-penjualan.update-status', $penjualan->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button name="status" value="proses" class="btn btn-primary">Terima</button>
        </form>
        <form action="{{ route('dashboard-penjualan.update-status', $penjualan->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button name="status" value="batal" class="btn btn-danger">Batalkan</button>
        </form>
    @elseif ($penjualan->status == 'proses')
        <form action="{{ route('dashboard-penjualan.update-status', $penjualan->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button name="status" value="selesai" class="btn btn-success">Selesai</button>
        </form>
    @endif
</div>

<a href="{{ route('dashboard-penjualan.index') }}" class="btn btn-secondary mt-3">Kembali</a>

@endsection
