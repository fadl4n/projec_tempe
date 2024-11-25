@extends('dashboard.layout.main')

@section('content')
<div class="container mt-5 bg-white rounded shadow-md p-4">
    <h1 class="h4 font-weight-bold">Keranjang Belanja</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($keranjang->isEmpty())
        <div class="alert alert-warning">
            Keranjang Anda kosong.
        </div>
    @else
        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjang as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Produk" width="100">
        </td>
        <td>{{ $item->nama_produk }}</td>
        <td>{{ $item->jumlah_keranjang }}</td>
        <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
        <td>Rp{{ number_format($item->total_harga_keranjang, 0, ',', '.') }}</td>
        <td>{{ \Carbon\Carbon::parse($item->tanggal_keranjang)->format('d M Y') }}</td>
        <td>
            <!-- Tombol Edit -->
            <a href="{{ route('dashboard-keranjang.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <!-- Tombol Hapus -->
            <form action="{{ route('dashboard-keranjang.destroy', $item->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
        </td>
    </tr>
@endforeach

            </tbody>
        </table>

        <!-- Total Harga -->
        <div class="text-end">
            <h3>Total Harga: Rp{{ number_format($keranjang->sum(fn($item) => $item->total_harga_keranjang), 0, ',', '.') }}</h3>
        </div>

        <!-- Tombol Check Out -->
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-success">Check Out</button>
        </div>
    @endif
</div>
@endsection
