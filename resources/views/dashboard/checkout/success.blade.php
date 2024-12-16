@extends('dashboard.layout.main')

@section('content')
<div class="container mt-5 bg-white rounded shadow-md p-4 mb-5">
    <h3 class="text-success"><i class="bi bi-check-circle"></i> Pemesanan Berhasil!</h3>
    <p class="lead">Terima kasih telah melakukan pemesanan. Pemesanan Anda sedang menunggu konfirmasi dari penjual. Silakan cek riwayat pesanan untuk melihat statusnya.</p>

    <!-- Menambahkan ikon ceklis besar -->
    <div class="text-center mb-4">
        <i class="bi bi-check-circle-fill" style="font-size: 50px; color: green;"></i>
    </div>

    <div class="alert alert-success" role="alert">
        <strong>Pemesanan Anda sedang diproses!</strong> Anda akan menerima pemberitahuan lebih lanjut setelah konfirmasi.
    </div>

    <div class="d-flex justify-content-center">
        <a href="{{ route('riwayat.pesanan') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-box-arrow-right"></i> Lihat Riwayat Pesanan
        </a>
    </div>

    <div class="mt-4 text-center">
        <!-- Memberikan efek hover atau transisi ringan pada tombol -->
        <input type="checkbox" id="notifyMe" class="form-check-input" disabled checked>
        <label for="notifyMe" class="form-check-label">Beritahu saya saat pesanan diproses</label>
    </div>
</div>
@endsection
