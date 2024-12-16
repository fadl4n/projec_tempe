@extends('dashboard.layouts.main')
@section('title','Data Penjualan')
@section('content')

<h1 class="mb-5">Daftar Penjualan</h1>
<a href="{{ route('dashboard-penjualan.create') }}" class="btn mb-3" style="background-color: #4CAF50; color: white;">
    <i class="bi bi-plus-circle-fill"></i> Tambah Data Penjualan
</a>

<!-- Form Filter Bulan dan Tahun -->
<form action="/dashboard-penjualan" method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <label for="bulan" class="form-label">Bulan</label>
        <select name="bulan" id="bulan" class="form-control">
            <option value="">Pilih Bulan</option>
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ (request('bulan') == $m) ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
            @endfor
        </select>
    </div>

    <div class="col-md-4">
        <label for="tahun" class="form-label">Tahun</label>
        <select name="tahun" id="tahun" class="form-control">
            <option value="">Pilih Tahun</option>
            @for ($y = date('Y'); $y >= 2000; $y--)
                <option value="{{ $y }}" {{ (request('tahun') == $y) ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>
    </div>

    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-secondary">Filter</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Alamat Pelanggan</th>
            <th>Metode Pengiriman</th>
            <th>Metode Pembayaran</th>
            <th>Tanggal Transaksi</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($penjualans as $index => $dataPenjualan)
            <tr>
                <td>{{ $penjualans->firstItem() + $index }}</td>
                <td>{{ $dataPenjualan->nama_pelanggan }}</td>
                <td>{{ $dataPenjualan->alamat_pelanggan }}</td>
                <td>{{ ucfirst($dataPenjualan->metode_pengiriman) }}</td>
                <td>{{ ucfirst($dataPenjualan->metode_pembayaran) }}</td>

                <td>{{ \Carbon\Carbon::parse($dataPenjualan->tgl_transaksi)->format('d-m-Y') }}</td>
                <td>
                    <span style="color:
                        {{ $dataPenjualan->status == 'pending' ? 'red' : ($dataPenjualan->status == 'proses' ? 'blue' : 'green') }};">
                        {{ ucfirst($dataPenjualan->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('dashboard-penjualan.show', $dataPenjualan->id) }}" class="btn btn-info">
                        <i class="bi bi-eye-fill"></i> Detail
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data penjualan.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $penjualans->links() }}
@endsection
