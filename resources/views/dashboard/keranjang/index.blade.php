@extends('dashboard.layout.main')

@section('content')
<div class="container mt-5 bg-white rounded shadow-md p-4 mb-5">
    <h1 class="h4 font-weight-bold">Keranjang Belanja</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(empty($keranjangGabungan))
        <div class="alert alert-warning">
            Keranjang Anda kosong.
        </div>
    @else
    <form action="{{ route('bayar.index') }}" method="GET">
        @csrf
            <!-- Input untuk mengirimkan nama_pelanggan -->
    <input type="hidden" name="nama_pelanggan" value="{{ Auth::user()->name }}">
        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th>Pilih</th>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjangGabungan as $index => $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="nama_produk[]" value="{{ $item['nama_produk'] }}" class="item-checkbox">
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ asset('storage/' . $item['gambar']) }}" alt="Gambar Produk" width="100"></td>
                        <td>{{ $item['nama_produk'] }}</td>
                        <td>{{ $item['jumlah_keranjang'] }}</td>
                        <td>Rp{{ number_format($item['total_harga_keranjang'] / $item['jumlah_keranjang'], 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item['total_harga_keranjang'], 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('dashboard-keranjang.edit', $item['nama_produk']) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('dashboard-keranjang.destroy', $item['nama_produk']) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mt-3">
            <h5 id="total-harga">Total Harga: Rp0</h5>
        </div>

        <button type="submit" class="btn btn-primary">Checkout</button>
    </form>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const totalHargaElement = document.getElementById('total-harga');

    // Fungsi untuk menghitung total harga
    function updateTotalHarga() {
        let totalHarga = 0;

        // Loop untuk setiap checkbox
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const harga = parseFloat(checkbox.closest('tr').querySelector('td:nth-child(6)').textContent.replace('Rp', '').replace(/\./g, '').trim());
                const jumlah = parseInt(checkbox.closest('tr').querySelector('td:nth-child(5)').textContent, 10);
                const totalPerProduk = harga * jumlah;

                // Update harga total per produk di kolom "Total Harga" (td ketujuh)
                checkbox.closest('tr').querySelector('td:nth-child(7)').textContent = 'Rp' + totalPerProduk.toLocaleString('id-ID');

                // Tambahkan ke total keseluruhan
                totalHarga += totalPerProduk;
            }
        });

        // Update total harga keseluruhan di bagian bawah tabel
        totalHargaElement.textContent = 'Total Harga: Rp' + totalHarga.toLocaleString('id-ID');
    }

    // Event listener untuk setiap checkbox
    checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateTotalHarga));

    // Panggil fungsi untuk menghitung total harga pada awal
    updateTotalHarga();
});

</script>

@endsection
