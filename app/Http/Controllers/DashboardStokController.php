<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Stok;

class DashboardStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data stok dengan paginasi
        $stoks = Stok::latest()->paginate(10);
        return view('dashboard.stok.index', compact('stoks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil semua produk
        $produk = Produk::all();
        return view('dashboard.stok.create', compact('produk'));
    }

    /**
     * Store a newly created or updated resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dan cek jumlah tidak boleh negatif
        $validated = $request->validate([
            'nama_produk' => 'required|string|exists:produks,nama_produk',
            'jumlah' => 'required|integer|min:0',
        ], [
            'nama_produk.exists' => 'Produk tidak ditemukan.',
            'jumlah.min' => 'Jumlah tidak boleh negatif.',
        ]);

        // Cek apakah stok sudah ada berdasarkan nama produk
        $stok = Stok::where('nama_produk', $validated['nama_produk'])->first();

        if ($stok) {
            // Jika stok ada, tambahkan jumlahnya
            $stok->jumlah += $validated['jumlah'];
            $stok->save();
        } else {
            // Jika stok belum ada, buat entri stok baru
            Stok::create($validated);
        }

        return redirect('dashboard-stok')->with('success', 'Stok berhasil ditambahkan atau diperbarui.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Temukan stok berdasarkan ID dan ambil semua produk
        $stok = Stok::findOrFail($id);
        $produk = Produk::all();

        return view('dashboard.stok.edit', compact('stok', 'produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input dan pastikan jumlah tidak negatif
        $validated = $request->validate([
            'nama_produk' => 'required|string|exists:produks,nama_produk',
            'jumlah' => 'required|integer|min:0',
        ], [
            'nama_produk.exists' => 'Produk tidak ditemukan.',
            'jumlah.min' => 'Jumlah tidak boleh negatif.',
        ]);

        // Update data stok berdasarkan ID
        $stok = Stok::findOrFail($id);
        $stok->update($validated);

        return redirect('dashboard-stok')->with('success', 'Stok berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan dan hapus stok berdasarkan ID
        $stok = Stok::findOrFail($id);
        $stok->delete();

        return redirect()->route('dashboard-stok.index')->with('success', 'Data stok berhasil dihapus.');
    }
}
