<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Penjualan;
use App\Models\Stok;
use App\Models\Produk;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    /**
     * Tampilkan form checkout dengan produk yang dipilih dari keranjang.
     */
    public function index(Request $request)
    {
        // Ambil nama produk yang dipilih dari request
        $produk = Produk::where('nama_produk', $request->nama_produk)->firstOrFail();

        // Ambil jumlah yang dipilih dari form
        $jumlah = $request->input('jumlah', 1);  // Default ke 1 jika tidak ada input jumlah

        // Hitung total harga
        $total_harga = $produk->harga * $jumlah;
        $nama_produk_terpilih = $request->input('nama_produk', []);

        if (empty($nama_produk_terpilih)) {
            return redirect()->route('dashboard-keranjang.index')->with('error', 'Pilih produk terlebih dahulu untuk checkout.');
        }

        // Ambil data produk yang dipilih dari keranjang berdasarkan nama_produk
        $keranjang = Keranjang::whereIn('nama_produk', $nama_produk_terpilih)->get();

        // Hitung total harga hanya untuk produk yang dipilih
        $total_harga = $keranjang->sum('total_harga_keranjang'); // ini sudah benar untuk menghitung total harga produk yang dipilih

        // Sisipkan nama_pelanggan ke dalam data yang akan dikirim ke view
        $nama_pelanggan = Auth::user()->name;

        return view('dashboard.bayar.index', compact('keranjang', 'total_harga', 'nama_pelanggan'));
    }

    /**
     * Proses pembayaran dan simpan transaksi.
     */
    public function process(Request $request)
    {
        // Debug request untuk melihat seluruh data
        dd($request->all());

        // Validasi input
        $validated = $request->validate([
            'total_harga' => 'required|numeric',
            'metode_pengiriman' => 'required|string|in:dijemput,diantar',
            'metode_pembayaran' => 'required|string|in:cash,transfer',
            'alamat_pelanggan' => 'required_if:metode_pengiriman,diantar|string',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user(); // Mendapatkan data user yang sedang login

        // Ambil nama pelanggan dari Auth
        $nama_pelanggan = $user->name;

        // Ambil data produk dari request
        $produk_names = $request->input('nama_produk'); // Nama produk yang dipilih
        $jumlahs = $request->input('jumlah');           // Jumlah produk yang dipilih
        $total_hargas = $request->input('total_harga_keranjang'); // Total harga per produk
        $status = $request->input('status', 'pending'); // Ambil status, jika tidak ada default ke 'pending'

        if (empty($produk_names)) {
            return redirect()->route('dashboard-keranjang.index')->with('error', 'Pilih produk terlebih dahulu untuk checkout.');
        }

        // Proses setiap item
        foreach ($produk_names as $index => $nama_produk) {
            // Ambil data produk berdasarkan nama produk
            $produk = Produk::where('nama_produk', $nama_produk)->first();

            if (!$produk) {
                // Jika produk tidak ditemukan
                return back()->with('error', 'Produk tidak ditemukan: ' . $nama_produk);
            }

            // Ambil jumlah dan total harga untuk produk tersebut
            $jumlah = $jumlahs[$index];
            $total_harga_keranjang = $total_hargas[$index];

            // Simpan data penjualan
            Penjualan::create([
                'nama_pelanggan' => $nama_pelanggan, // Menggunakan nama pelanggan dari Auth
                'nama_produk' => $produk->nama_produk, // Nama produk
                'jumlah_pesanan' => $jumlah,  // Jumlah produk
                'total_harga' => $total_harga_keranjang, // Total harga
                'alamat_pelanggan' => $request->alamat_pelanggan, // Alamat pelanggan


'tgl_transaksi' => Carbon::now(),
                'status' => $status, // Status yang diambil dari form
                'metode_pengiriman' => $request->metode_pengiriman, // Metode pengiriman
                'metode_pembayaran' => $request->metode_pembayaran, // Metode pembayaran
            ]);

            // Kurangi stok produk
            $stok = Stok::where('nama_produk', $produk->nama_produk)->first();
            if ($stok) {
                $stok->jumlah -= $jumlah;
                $stok->save();
            }
        }

        // Hapus semua item dari keranjang setelah transaksi
        Keranjang::where('nama_pelanggan', $user->name)->delete();

        return redirect()->route('dashboard-penjualan.index')->with('success', 'Pembayaran berhasil, data penjualan telah disimpan.');
    }
}
