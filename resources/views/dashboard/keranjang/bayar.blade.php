@extends('dashboard.layout.main')

@section('content')
<div class="container mt-5 bg-white rounded shadow-md p-4 mb-5">
    <h3>Checkout</h3>

    <!-- Total Harga -->
    <div class="mt-3">
        <h5>Total Harga: Rp{{ number_format($totalHarga, 0, ',', '.') }}</h5>
    </div>


    <form action="{{ route('dashboard-keranjang.prosesPembayaran') }}" method="POST">
        @csrf

        <!-- Menyimpan data produk dan harga sebagai hidden input -->


        <input type="hidden" name="nama_produk" value="{{ $produk->nama_produk }}">
        <input type="hidden" name="jumlah" value="{{ $jumlah_keranjang }}">
        <input type="hidden" name="total_harga" value="{{ $total_harga }}">


        <!-- Metode Pengiriman -->
        <div class="mb-3">
            <label for="metode_pengiriman" class="form-label">Metode Pengiriman</label>
            <select class="form-control" id="metode_pengiriman" name="metode_pengiriman" required onchange="updateAlamat()">
                <option value="dijemput" {{ old('metode_pengiriman') == 'dijemput' ? 'selected' : '' }}>Dijemput</option>
                <option value="diantar" {{ old('metode_pengiriman') == 'diantar' ? 'selected' : '' }}>Diantar</option>
            </select>
        </div>

        <!-- Alamat Pengiriman (hidden dulu) -->
        <div class="mb-3" id="alamat-container" style="display: none;">
            <label for="alamat_pelanggan" class="form-label">Alamat Pengiriman</label>
            <textarea class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" required>{{ old('alamat_pelanggan') ?: 'Dijemput di lokasi toko' }}</textarea>
        </div>

        <!-- Metode Pembayaran -->
        <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required onchange="updateRekening()">
                <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="rekening" {{ old('metode_pembayaran') == 'rekening' ? 'selected' : '' }}>Rekening</option>
            </select>
        </div>

        <!-- Informasi Rekening -->
        <div id="rekening-info" class="mb-3" style="display: none;">
            <label for="rekening" class="form-label">Rekening</label>
            <p>Rek: 1234567890</p>
        </div>

        <!-- Button Submit -->
        <button type="submit" class="btn btn-danger btn-lg w-auto mb-3">
            <i class="bi bi-check-circle"></i> Proses Pembelian
        </button>
    </form>
</div>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const jumlahInputs = document.querySelectorAll('.jumlah-produk');
    const totalHargaElement = document.getElementById('total-harga');

    // Fungsi untuk menghitung total harga
    function updateTotalHarga() {
        let totalHarga = 0;

        // Loop untuk setiap checkbox dan jumlah
        checkboxes.forEach((checkbox, index) => {
            if (checkbox.checked) {
                const harga = parseFloat(checkbox.closest('tr').querySelector('td:nth-child(6)').textContent.replace('Rp', '').replace('.', '').trim());
                const jumlah = parseInt(jumlahInputs[index].value, 10);
                const totalPerProduk = harga * jumlah;

                // Update harga total per produk
                checkbox.closest('tr').querySelector('.total-harga-per-produk').textContent = 'Rp' + totalPerProduk.toLocaleString();

                // Tambahkan ke total keseluruhan
                totalHarga += totalPerProduk;
            }
        });

        // Update total harga keseluruhan
        totalHargaElement.textContent = 'Total Harga: Rp' + totalHarga.toLocaleString();
    }

    // Event listener untuk setiap checkbox dan input jumlah produk
    checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateTotalHarga));
    jumlahInputs.forEach(input => input.addEventListener('input', updateTotalHarga));

    // Panggil fungsi untuk menghitung total harga pada awal
    updateTotalHarga();
});

    // Fungsi untuk menyesuaikan alamat berdasarkan metode pengiriman
    function updateAlamat() {
        const metodePengiriman = document.getElementById('metode_pengiriman').value;
        const alamatContainer = document.getElementById('alamat-container');
        const alamatInput = document.getElementById('alamat_pelanggan');

        if (metodePengiriman === 'diantar') {
            alamatContainer.style.display = 'block'; // Tampilkan alamat jika diantar
            alamatInput.required = true; // Membuat alamat pengiriman wajib diisi
            alamatInput.value = ''; // Kosongkan input alamat
        } else {
            alamatContainer.style.display = 'none'; // Sembunyikan alamat jika dijemput
            alamatInput.required = false; // Membuat alamat tidak wajib diisi
            alamatInput.value = 'Dijemput di lokasi toko'; // Isi alamat dengan default
        }
    }

    // Fungsi untuk menampilkan informasi rekening jika memilih pembayaran dengan rekening
    function updateRekening() {
        const metodePembayaran = document.getElementById('metode_pembayaran').value;
        const rekeningInfo = document.getElementById('rekening-info');

        if (metodePembayaran === 'rekening') {
            rekeningInfo.style.display = 'block'; // Tampilkan rekening
        } else {
            rekeningInfo.style.display = 'none'; // Sembunyikan rekening
        }
    }

    // Panggil fungsi untuk update alamat dan rekening saat halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', function () {
        updateAlamat(); // Sesuaikan alamat berdasarkan pengiriman
        updateRekening(); // Sesuaikan rekening berdasarkan metode pembayaran
    });
</script>

@endsection
