<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPesananController extends Controller
{
    /**
     * Menampilkan riwayat pesanan berdasarkan user yang login.
     */
    public function index()
    {
        // Ambil semua pesanan yang dilakukan oleh user yang sedang login
        $penjualans = Penjualan::where('nama_pelanggan', Auth::user()->name)
                                ->orderBy('tgl_transaksi', 'desc')
                                ->paginate(10);

        return view('dashboard.riwayat.index', compact('penjualans'));
    }

    /**
     * Membatalkan pesanan jika status masih pending.
     */
    public function batal($id)
    {
        // Cari penjualan berdasarkan ID
        $penjualan = Penjualan::findOrFail($id);

        // Pastikan status penjualan adalah pending
        if ($penjualan->status === 'pending') {
            // Update status menjadi batal
            $penjualan->update(['status' => 'batal']);
        }

        return redirect()->route('riwayat.pesanan')
                         ->with('success', 'Pesanan berhasil dibatalkan');
    }
}



