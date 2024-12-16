<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout
     */
    public function checkout(Request $request)
    {

    $produk = Produk::where('nama_produk', $request->nama_produk)->firstOrFail();

    // Ambil jumlah yang dipilih dari form
    $jumlah = $request->input('jumlah', 1);  // Default ke 1 jika tidak ada input jumlah

    // Hitung total harga
    $total_harga = $produk->harga * $jumlah;
        return view('dashboard.checkout.index', compact('produk','jumlah','total_harga')); // Ganti view ke dashboard/checkout/index
    }

    /**
     * Proses checkout dan simpan data penjualan
     */
    public function processCheckout(Request $request)
    {

 
         // Pastikan jumlah yang dikirim ada
    $jumlah = $request->input('jumlah', 1);  // Default jumlah adalah 1 jika tidak ada

        $produk = Produk::where('nama_produk', $request->nama_produk)->firstOrFail();
        $stok = Stok::where('nama_produk', $request->nama_produk)->firstOrFail();

        // Validasi stok
        if ($request->jumlah > $stok->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi untuk produk ' . $produk->nama_produk);
        }

        // Kurangi stok
        $stok->jumlah -= $request->jumlah;
        $stok->save();

        // Kalkulasi total harga
        $total_harga = $produk->harga * $request->jumlah;

        // Simpan penjualan
        Penjualan::create([
                'nama_pelanggan' => Auth::user()->name,
                'nama_produk' => $produk->nama_produk,
                'jumlah_pesanan' => $request->jumlah,
                'total_harga' => $total_harga,
                'alamat_pelanggan' => $request->alamat_pelanggan,
                'tgl_transaksi' => now(),
                'status' => 'pending', // Status awal
                'metode_pengiriman' => $request->metode_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return redirect()->route('checkout.success')
        ->with('success', 'Pemesanan berhasil! Silakan tunggu konfirmasi dari penjual.');
    }
    public function success()
    {
    return view('dashboard.checkout.success');
    }

}
