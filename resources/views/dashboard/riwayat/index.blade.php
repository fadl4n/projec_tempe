@extends('dashboard.layout.main')

@section('content')
<div class="container mt-5 bg-white rounded shadow-md p-4 mb-5">
    <h3>Riwayat Pesanan</h3>

    @if($penjualans->isEmpty())
        <p>Anda belum memiliki pesanan.</p>
    @else
        <div class="row">
            @foreach($penjualans as $index => $penjualan)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <strong>Pesanan #{{ $index + 1 }}</strong> <!-- Menampilkan urutan pesanan -->
                    </div>
                    <div class="card-body">
                        <p><strong>Produk:</strong> {{ $penjualan->nama_produk }}</p>
                        <p><strong>Jumlah:</strong> {{ $penjualan->jumlah_pesanan }}</p>
                        <p><strong>Total Harga:</strong> Rp {{ number_format($penjualan->total_harga, 2) }}</p>
                        <p><strong>Tanggal Transaksi:</strong> {{ $penjualan->tgl_transaksi->format('d-m-Y H:i') }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($penjualan->status) }}</p>

                        @if($penjualan->status === 'pending')
                            <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                            <!-- Tombol batal hanya muncul jika status pending -->
                            <form action="{{ route('riwayat.batal', $penjualan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger btn-sm mt-2">Batalkan</button>
                            </form>
                        @elseif($penjualan->status === 'proses')
                            <span class="badge bg-primary">Diproses</span>
                        @elseif($penjualan->status === 'selesai')
                            <span class="badge bg-success">Selesai</span>
                        @elseif($penjualan->status === 'batal')
                            <span class="badge bg-danger">Batal</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $penjualans->links() }}
        </div>
    @endif
</div>
@endsection
