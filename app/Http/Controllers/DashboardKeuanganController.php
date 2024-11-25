<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

class DashboardKeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', date('Y')); // Tahun default saat ini

        // Ambil total pemasukan per bulan
        $pemasukan = Penjualan::select(
                DB::raw('MONTH(STR_TO_DATE(tgl_transaksi, "%Y-%m-%d")) as bulan'),
                DB::raw('SUM(CAST(total_harga as DECIMAL(15, 2))) as total')
            )
            ->where(DB::raw('YEAR(STR_TO_DATE(tgl_transaksi, "%Y-%m-%d"))'), $tahun)
            ->groupBy(DB::raw('MONTH(STR_TO_DATE(tgl_transaksi, "%Y-%m-%d"))'))
            ->pluck('total', 'bulan');

        // Ambil total pengeluaran per bulan
        $pengeluaran = Pengeluaran::select(
                DB::raw('MONTH(STR_TO_DATE(tanggal, "%Y-%m-%d")) as bulan'),
                DB::raw('SUM(CAST(ttl_harga as DECIMAL(15, 2))) as total')
            )
            ->where(DB::raw('YEAR(STR_TO_DATE(tanggal, "%Y-%m-%d"))'), $tahun)
            ->groupBy(DB::raw('MONTH(STR_TO_DATE(tanggal, "%Y-%m-%d"))'))
            ->pluck('total', 'bulan');

        // Siapkan data untuk setiap bulan (1-12)
        $dataBulan = collect(range(1, 12))->map(function ($bulan) use ($pemasukan, $pengeluaran) {
            $totalPemasukan = $pemasukan[$bulan] ?? 0;
            $totalPengeluaran = $pengeluaran[$bulan] ?? 0;
            $keuntungan = $totalPemasukan - $totalPengeluaran;

            $keterangan = $keuntungan >= 0
                ? "Untung: Rp " . number_format($keuntungan, 2)
                : "Rugi: Rp " . number_format(abs($keuntungan), 2);

            return [
                'bulan' => DateTime::createFromFormat('!m', $bulan)->format('F'),
                'pemasukan' => $totalPemasukan,
                'pengeluaran' => $totalPengeluaran,
                'keterangan' => $keterangan,
            ];
        });

        return view('dashboard.keuangan.index', compact('dataBulan', 'tahun'));
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
