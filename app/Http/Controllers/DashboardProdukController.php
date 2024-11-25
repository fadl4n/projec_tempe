<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua produk terurut berdasarkan kode_produk dengan paginasi
        $produks = Produk::orderBy('kode_produk', 'asc')->paginate(10);
        return view('dashboard.produk.index', ['produks' => $produks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_produk' => 'required|string|max:255|unique:produks,kode_produk',
            'nama_produk' => 'required|min:3|max:255|unique:produks,nama_produk',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|min:10',
        ]);

        // Proses upload gambar
        if ($request->file('gambar')) {
            $imagePath = $request->file('gambar')->store('produk-images', 'public');
            $validated['gambar'] = $imagePath;
        }

        // Simpan produk baru
        Produk::create($validated);

        return redirect('/dashboard-produk')->with('success', 'Produk berhasil ditambahkan');
    }
  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::findOrFail($id);
        return view('dashboard.produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);

        // Validasi input (abaikan produk saat ini)
        $validated = $request->validate([
            'kode_produk' => 'required|string|max:255|unique:produks,kode_produk,' . $produk->id,
            'nama_produk' => 'required|min:3|max:255|unique:produks,nama_produk,' . $produk->id,
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|min:10',
        ]);

        // Jika ada gambar baru, hapus gambar lama dan upload yang baru
        if ($request->file('gambar')) {
            if ($produk->gambar) {
                Storage::delete('public/' . $produk->gambar);
            }
            $imagePath = $request->file('gambar')->store('produk-images', 'public');
            $validated['gambar'] = $imagePath;
        }

        // Update produk
        $produk->update($validated);

        return redirect('/dashboard-produk')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus gambar jika ada
        if ($produk->gambar) {
            Storage::delete('public/' . $produk->gambar);
        }

        // Hapus produk
        $produk->delete();

        return redirect('/dashboard-produk')->with('success', 'Produk berhasil dihapus');
    }
}
