<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang;
class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


            // Ambil data keranjang berdasarkan tanggal pesanan
            $tanggalkeranjang = request()->get('tanggal_keranjang', now()->toDateString());

            // Mengambil data keranjang yang diperbarui
            $keranjang = Keranjang::with('produk')
                ->whereDate('tanggal_keranjang', $tanggalkeranjang)
                ->get();

            return view('dashboard.keranjang.index', compact('keranjang', 'tanggalkeranjang'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {

            $produk = Produk::findOrFail($id); // Pastikan ID valid
            return view('dashboard.keranjang.create', compact('produk'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_produk' => 'required', // Validasi produk yang ada
            'jumlah' => 'required|integer|min:1',
            'tanggal_keranjang' => 'nullable|date', // Mengubah menjadi opsional
        ]);

        // Menentukan tanggal keranjang, jika tidak diisi maka menggunakan tanggal sekarang
        $tanggalKeranjang = $validatedData['tanggal_keranjang'] ?? now()->toDateString();

        // Ambil data produk berdasarkan ID
        $produk = Produk::findOrFail($validatedData['nama_produk']);

        // Hitung total harga keranjang
        $totalHarga = $validatedData['jumlah'] * $produk->harga;

        // Simpan data ke tabel keranjang
        Keranjang::create([
            'gambar' => $produk->gambar, // Mengambil gambar dari tabel produk
            'nama_produk' => $produk->nama_produk, // Mengambil nama produk dari tabel produk
            'jumlah_keranjang' => $validatedData['jumlah'],
            'harga' => $produk->harga, // Mengambil harga dari tabel produk
            'total_harga_keranjang' => $totalHarga,
            'tanggal_keranjang' => $tanggalKeranjang, // Menggunakan tanggal yang telah ditentukan
        ]);

        // Redirect ke halaman keranjang dengan pesan sukses
        return redirect()->route('dashboard-keranjang.index')
                         ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
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
    public function edit($id)
{
      // Ambil data keranjang dan semua produk
      $keranjang = Keranjang::with('produk.stok')->findOrFail($id);
      $produkList = Produk::all(); // Ambil semua produk yang tersedia

      return view('dashboard.keranjang.edit', compact('keranjang', 'produkList'));
}
public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'jumlah' => 'required|integer|min:1',
            'nama_produk' => 'required', // Pastikan produk dipilih

        ]);

        // Ambil data keranjang berdasarkan ID beserta produk yang terkait
        $keranjang = Keranjang::with('produk')->findOrFail($id);


        // Periksa apakah produk ada
        if (!$keranjang->produk) {
            return redirect()->route('dashboard-keranjang.index')->with('error', 'Produk tidak ditemukan.');
        }

        // Perbarui jumlah keranjang
        $keranjang->jumlah_keranjang = $validatedData['jumlah'];

        // Hitung total harga keranjang
        $produk = $keranjang->produk;
        $keranjang->total_harga_keranjang = $keranjang->jumlah_keranjang * $produk->harga;
        // Ambil produk berdasarkan pilihan pengguna
$produk = Produk::findOrFail($request->input('nama_produk')); // Pastikan nama_produk adalah ID produk

// Update produk pada keranjang
$keranjang->nama_produk = $produk->id;
$keranjang->nama_produk = $produk->nama_produk; // Jika nama_produk disimpan langsung di tabel keranjang
$keranjang->gambar = $produk->gambar;           // Jika gambar disimpan langsung di tabel keranjang
$keranjang->save();

        // Simpan perubahan
        $keranjang->save();

        // Redirect kembali ke halaman keranjang dengan pesan sukses
        return redirect()->route('dashboard-keranjang.index', ['tanggal_keranjang' => request('tanggal_keranjang')])
                        ->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
          // Ambil item keranjang berdasarkan ID
          $keranjang = Keranjang::findOrFail($id);

          // Hapus item dari keranjang
          $keranjang->delete();

          return redirect()->route('dashboard-keranjang.index', ['tanggal_pesanan' => $keranjang->tanggal_pesanan])
              ->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
