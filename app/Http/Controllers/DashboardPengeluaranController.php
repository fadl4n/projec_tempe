<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

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

        // Filter data berdasarkan bulan dan tahun jika dipilih
        if ($bulan && $tahun) {
            $query->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan);
        }

        // Urutkan data berdasarkan tanggal terbaru
        $pengeluarans = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('dashboard.pengeluaran.index', compact('pengeluarans', 'bulan', 'tahun'));
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
        ]);

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
}
