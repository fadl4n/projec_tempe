@extends('dashboard.layouts.main')
@section('title', 'Data Pengeluaran')
@section('content')

<h1 class="mb-5">Daftar Pengeluaran</h1>

   <a href="{{ route('dashboard-pengeluaran.create') }}" class="btn mb-3" style="background-color: #4CAF50; color: white;">
    <i class="bi bi-plus-circle-fill"></i> Tambah Data Pengeluaran
</a>

<!-- Form Filter Bulan dan Tahun -->
<form action="/dashboard-pengeluaran" method="GET" class="row g-3 mb-4">
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

<!-- Tabel Data Pengeluaran -->
<table class="table table-bordered">
    <thead >
        <tr>
            <th>No</th>
            <th>Nama Bahan</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Total Harga</th>
            <th>Tanggal Transaksi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pengeluarans as $index => $dataPengeluaran)
            <tr>
                <td>{{ $pengeluarans->firstItem() + $index }}</td>
                <td>{{ $dataPengeluaran->nama_barang }}</td>
                <td>{{ $dataPengeluaran->jumlah }}</td>
                <td>{{ $dataPengeluaran->satuan }}</td>
                <td>Rp {{ number_format($dataPengeluaran->ttl_harga, 0, ',', '.') }}</td>
                <td>{{ $dataPengeluaran->tanggal }}</td>
                <td>
                    <a href="/dashboard-pengeluaran/{{ $dataPengeluaran->id }}/edit" class="btn btn-warning">
                        <i class="bi bi-pencil-fill"></i> Edit
                    </a>
                    <form action="/dashboard-pengeluaran/{{ $dataPengeluaran->id }}" method="POST" class="d-inline">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin akan menghapus data?')">
                            <i class="bi bi-bucket"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data pengeluaran.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination -->
{{ $pengeluarans->links() }}

@endsection
