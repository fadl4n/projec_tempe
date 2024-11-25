@extends('dashboard.layouts.main')

@section('title', 'Data Produk')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Produk</h1>

    <!-- Tombol Tambah Produk -->
    <a href="{{ route('dashboard-produk.create') }}" class="btn mb-3" style="background-color: #4CAF50; color: white;">
        <i class="bi bi-plus-circle-fill"></i> Tambah Data Produk
    </a>


    <!-- Tabel Produk -->
    <table class="table table-bordered table-hover text-center align-middle">
        <thead style="background-color:">
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produks as $index => $dataProduk)
                <tr>
                    <!-- Nomor Urut -->
                    <td>{{ $produks->firstItem() + $index }}</td>

                    <!-- Gambar Produk -->
                    <td>
                        @if ($dataProduk->gambar)
                            <img src="{{ asset('storage/' . $dataProduk->gambar) }}"
                                 alt="Gambar Produk" width="100" class="img-thumbnail">
                        @else
                            <span class="text-muted">Tidak ada gambar</span>
                        @endif
                    </td>

                    <!-- Kode dan Nama Produk -->
                    <td>{{ $dataProduk->kode_produk }}</td>
                    <td>{{ $dataProduk->nama_produk }}</td>

                    <!-- Harga Produk -->
                    <td>Rp{{ number_format($dataProduk->harga, 0, ',', '.') }}</td>

                    <!-- Deskripsi Produk -->
                    <td>{{ $dataProduk->deskripsi }}</td>

                    <!-- Aksi -->
                    <td>
                        <a href="{{ route('dashboard-produk.edit', $dataProduk->id) }}"
                           class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>

                        <form action="{{ route('dashboard-produk.destroy', $dataProduk->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin akan menghapus data?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $produks->links() }}
    </div>
</div>
@endsection
