@extends('dashboard.layouts.main')
@section('title', 'Data Pengeluaran')
@section('content')

<h1 class="mb-5">Daftar Pengeluaran</h1>

<!-- Tombol Tambah Data Pengeluaran -->
<a href="{{ route('dashboard-pengeluaran.create') }}" class="btn mb-3" style="background-color: #4CAF50; color: white;">
    <i class="bi bi-plus-circle-fill"></i> Tambah Data Pengeluaran
</a>

<a href="{{ route('dashboard-pengeluaran.pdf', request()->only('kategori', 'bulan', 'tahun')) }}"
    class="btn btn-danger mb-3"
    style="color: white;">
    <i class="bi bi-file-earmark-pdf-fill"></i> Download PDF
 </a>





<!-- Form Filter Kategori, Bulan, dan Tahun -->
<form action="/dashboard-pengeluaran" method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <label for="kategori" class="form-label">Kategori</label>
        <select name="kategori" id="kategori" class="form-control">
            <option value="">Pilih Kategori</option>
            <option value="bahan" {{ request('kategori') == 'bahan' ? 'selected' : '' }}>Bahan</option>
            <option value="jasa" {{ request('kategori') == 'jasa' ? 'selected' : '' }}>Jasa</option>
            <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
    </div>

    <div class="col-md-4">
        <label for="bulan" class="form-label">Bulan</label>
        <select name="bulan" id="bulan" class="form-control">
            <option value="">Pilih Bulan</option>
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
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
                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>
    </div>

    <div class="col-12 d-flex mt-3">
        <button type="submit" class="btn btn-secondary">Filter</button>
    </div>
</form>

<!-- Tabel Data Pengeluaran -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Total Harga</th>
            <th>Tanggal Transaksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pengeluaran as $index => $dataPengeluaran)
            <tr>
                <td>{{ $pengeluaran->firstItem() + $index }}</td>
                <td>{{ $dataPengeluaran->nama_barang }}</td>
                <td>{{ $dataPengeluaran->jumlah }}</td>
                <td>{{ $dataPengeluaran->satuan }}</td>
                <td>Rp {{ number_format($dataPengeluaran->ttl_harga, 0, ',', '.') }}</td>
                <td>{{ $dataPengeluaran->tanggal }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data pengeluaran.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination -->
{{ $pengeluaran->withQueryString()->links() }}

@endsection
