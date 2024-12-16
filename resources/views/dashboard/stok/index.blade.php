@extends('dashboard.layouts.main')

@section('title', 'Data Stok')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Stok</h1>

    <!-- Tombol Tambah Data Stok -->
     class="btn mb-3" style="background-color: #4CAF50; color: white;">
        <i class="bi bi-plus-circle-fill"></i> Tambah Data Stok
    </a>

    <!-- Tabel Stok -->
    <table class="table table-bordered table-hover text-center align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>

        </thead>
      <tbody>
            @forelse ($stoks as $index => $dataStok)
                <tr>
                    <!-- Nomor Urut -->
                    <td>{{ $stoks->firstItem() + $index }}</td>

                    <!-- Nama Produk -->
                    <td>{{ $dataStok->nama_produk }}</td>

                    <!-- Jumlah Stok -->
                    <td>{{ $dataStok->jumlah }}</td>

                    <!-- Aksi -->
                    <td>
                        <a href="{{ route('dashboard-stok.edit', $dataStok->id) }}"
                           class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>

                        <form action="{{ route('dashboard-stok.destroy', $dataStok->id) }}"
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
                    <td colspan="4" class="text-center text-muted">Belum ada data stok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $stoks->links() }}
    </div>
</div>
@endsection
