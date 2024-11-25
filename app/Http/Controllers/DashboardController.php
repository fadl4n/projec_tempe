<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\Penjualan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menghitung jumlah pengguna
        $userCount = User::count();


        // Mengambil semua produk dan stok
        $produks = Produk::all();
        $stoks = Stok::all();

        // Mendapatkan total penjualan bulan ini
        $penjualans = Penjualan::whereMonth('created_at', Carbon::now()->month)
            ->sum('total_harga');

        // Mendapatkan total pengeluaran bulan ini
        $pengeluarans = Pengeluaran::whereMonth('created_at', Carbon::now()->month)
            ->sum('ttl_harga');

          // Menghasilkan notifikasi berdasarkan stok
    $notifications = [];

    foreach ($produks as $produk) {
        if ($produk->stok) {
            if ($produk->stok->jumlah <= 0) {
                $notifications[] = "Stok untuk produk '{$produk->nama_produk}' kosong! Segera tambahkan stok.";
            } elseif ($produk->stok->jumlah < 10) {
                $notifications[] = "Stok untuk produk '{$produk->nama_produk}' mulai menipis.";
            }
        }
    }


        // Mengirim data ke view
        return view('dashboard.index', compact(
            'userCount', 'produks', 'stoks', 'penjualans', 'pengeluarans','notifications'

        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
