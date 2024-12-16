<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $query = Pengeluaran::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $pengeluaran = $query->paginate(10);

        // Urutkan data berdasarkan tanggal terbaru
        $pengeluaran = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('dashboard.pengeluaran.index', compact('pengeluaran', 'bulan', 'tahun'));
    }

    public function create()
    {
        return view('dashboard.pengeluaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'ttl_harga' => 'required|string',
            'tanggal' => 'required|date',
            'kategori' => 'required|in:bahan,jasa,lainnya', // Add validation for kategori
        ]);

        // Menghapus format Rp dan titik sebelum menyimpan
        $validated['ttl_harga'] = str_replace('.', '', $validated['ttl_harga']);

        Pengeluaran::create($validated);

        return redirect('/dashboard-pengeluaran')->with('success', 'Data pengeluaran berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('dashboard.pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'ttl_harga' => 'required|string',
            'tanggal' => 'required|date',
            'kategori' => 'required|in:bahan,jasa,lainnya', // Add validation for kategori
        ]);

        // Menghapus format Rp dan titik sebelum menyimpan
        $validated['ttl_harga'] = str_replace('.', '', $validated['ttl_harga']);

        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->update($validated);

        return redirect('/dashboard-pengeluaran')->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect('/dashboard-pengeluaran')->with('success', 'Data pengeluaran berhasil dihapus.');
    }

    public function downloadPdf(Request $request)
{
    // Ambil data pengeluaran dengan filter
    $pengeluaranQuery = Pengeluaran::query();

    if ($request->filled('kategori')) {
        $pengeluaranQuery->where('kategori', $request->kategori);
    }

    if ($request->filled('bulan')) {
        $pengeluaranQuery->whereMonth('tanggal', $request->bulan);
    }

    if ($request->filled('tahun')) {
        $pengeluaranQuery->whereYear('tanggal', $request->tahun);
    }

    // Ambil data pengeluaran setelah filter
    $pengeluaran = $pengeluaranQuery->get();
    $totalPengeluaran = $pengeluaran->sum('ttl_harga');

    // Kirim data ke tampilan PDF
    $pdf = Pdf::loadView('dashboard.pengeluaran.pdf', compact('pengeluaran', 'totalPengeluaran', 'request'));
    return $pdf->stream('dataPengeluaran.pdf');
}





    public function show($id)
    {

    }
}
