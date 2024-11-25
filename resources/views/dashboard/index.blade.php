@extends('dashboard.layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Home Page</h1>
        </div>
         <!-- Notifikasi Stok -->
         <div class="row mt-4">
            <div class="col-md-12">
                @php
                    $hasNotification = false;
                    foreach ($produks as $produk) {
                        $stok = $stoks->firstWhere('nama_produk', $produk->nama_produk);
                        $jumlahStok = $stok ? $stok->jumlah : 0;
                        if ($jumlahStok == 0 || $jumlahStok < 10) {
                            $hasNotification = true;
                            break;
                        }
                    }
                @endphp

                @if ($hasNotification)
                    <div class="alert alert-warning" role="alert">
                        <h4 class="h4">Notifikasi</h4>
                        <ul>
                            @foreach ($produks as $produk)
                                @php
                                    $stok = $stoks->firstWhere('nama_produk', $produk->nama_produk);
                                    $jumlahStok = $stok ? $stok->jumlah : 0;
                                @endphp

                                @if ($jumlahStok == 0)
                                    <li>Stok produk <strong>{{ $produk->nama_produk }}</strong> kosong! Segera tambahkan stok.</li>
                                @elseif ($jumlahStok < 10)
                                    <li>Stok produk <strong>{{ $produk->nama_produk }}</strong> mulai menipis!</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- Customers Card -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Pelanggan</h5>
                        <p class="card-text" style="font-size: 40px;">👥</p>
                        <p class="card-text">{{ $userCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Profit Card -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Penjualan</h5>
                        <p class="card-text" style="font-size: 40px;">💰</p>
                        <p class="card-text">
                            Rp.{{ number_format($penjualans, 0, ',', '.') }}
                            <small>Bulan ini</small>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Transactions Card -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Pengeluaran</h5>
                        <p class="card-text" style="font-size: 40px;">📈</p>
                        <p class="card-text">
                            Rp.{{ number_format($pengeluarans, 0, ',', '.') }}
                            <small>Bulan ini</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Gabungan Produk dan Stok -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Produk dan Stok</h5>
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produks as $index => $produk)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $produk->nama_produk }}</td>
                                        <td>
                                            @php
                                                $stok = $stoks->firstWhere('nama_produk', $produk->nama_produk);
                                                echo $stok ? $stok->jumlah : '0';
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection
