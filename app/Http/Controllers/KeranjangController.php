<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil tanggal keranjang dari parameter atau gunakan tanggal sekarang
        $tanggalkeranjang = request()->get('tanggal_keranjang', null);

        // Ambil semua data keranjang, gabungkan produk yang sama dan hitung jumlah total
        $keranjang = Keranjang::with('produk')
            ->when($tanggalkeranjang, function ($query) use ($tanggalkeranjang) {
                return $query->whereDate('tanggal_keranjang', $tanggalkeranjang);
            })
            ->get()
            ->groupBy('nama_produk');  // Mengelompokkan berdasarkan nama_produk

        // Membuat array untuk menyimpan data keranjang yang sudah digabungkan
        $keranjangGabungan = [];
        foreach ($keranjang as $namaProduk => $items) {
            $totalJumlah = 0;
            $totalHargaKeranjang = 0;
            $gambar = $items->first()->gambar; // Ambil gambar dari produk pertama

            foreach ($items as $item) {
                $totalJumlah += $item->jumlah_keranjang;  // Menambahkan jumlah produk yang sama
                $totalHargaKeranjang += $item->total_harga_keranjang;  // Menambahkan total harga produk yang sama
            }

            // Masukkan data gabungan
            $keranjangGabungan[] = [
                'nama_produk' => $namaProduk,
                'gambar' => $gambar,
                'jumlah_keranjang' => $totalJumlah,
                'total_harga_keranjang' => $totalHargaKeranjang
            ];
        }

        return view('dashboard.keranjang.index', compact('keranjangGabungan', 'tanggalkeranjang'));
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

    $validatedData = $request->validate([
        'nama_produk' => 'required',
        'jumlah' => 'required|integer|min:1',
    ]);

    // Cari produk berdasarkan nama_produk
    $produk = Produk::where('nama_produk', $validatedData['nama_produk'])->first();


    // Periksa apakah produk ada dan stok mencukupi
    if (!$produk || $produk->stok->jumlah < $validatedData['jumlah']) {
        return redirect()->back()->with('error', 'Stok tidak mencukupi atau kosong. Silakan kurangi jumlah pembelian.');
    }

    // Hitung total harga
    $totalHarga = $validatedData['jumlah'] * $produk->harga;

    // Ambil nama pengguna yang sedang login
    $namaPelanggan = Auth::user()->name;

    // Tambahkan ke keranjang
    Keranjang::create([
        'gambar' => $produk->gambar,
        'nama_produk' => $produk->nama_produk,
        'jumlah_keranjang' => $validatedData['jumlah'],
        'harga' => $produk->harga,
        'total_harga_keranjang' => $totalHarga,
        'tanggal_keranjang' => now()->toDateString(),
        'name' => $namaPelanggan, // Menambahkan nilai untuk kolom 'name'
    ]);

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

        // Update produk pada keranjang
        $keranjang->nama_produk = $produk->id;
        $keranjang->nama_produk = $produk->nama_produk; // Jika nama_produk disimpan langsung di tabel keranjang
        $keranjang->gambar = $produk->gambar;           // Jika gambar disimpan langsung di tabel keranjang
        $keranjang->save();

        // Simpan perubahan
        $keranjang->save();

        // Redirect kembali      halaman keranjang dengan pesan sukses
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
    public function bayar(Request $request)
    {

        $produk = Produk::where('nama_produk', $request->nama_produk)->firstOrFail();
        $keranjang = Keranjang::where('nama_produk', $request->nama_produk)->firstOrFail();
        $jumlah =  $keranjang->jumlah_keranjang;
        $totalHarga = $produk->harga * $jumlah;


        // Kirim data produk yang dipilih dan total harga ke view pembayaran
        return view('dashboard.keranjang.bayar', compact('keranjang','totalHarga','jumlah','produk'));
    }


// Controller: Proses Pembayaran
// Proses Pembayaran
public function prosesPembayaran(Request $request)
{
    // Validasi input pengiriman dan pembayaran
    $validatedData = $request->validate([
        'metode_pengiriman' => 'required|string',
        'alamat_pelanggan' => 'required|string',
        'metode_pembayaran' => 'required|string',
    ]);

    // Ambil semua produk yang dipilih
    $produkList = $request->input('nama_produk');
    $jumlahList = $request->input('jumlah');
    $totalHargaList = $request->input('total_harga');

    $totalHarga = 0;

    // Simpan transaksi penjualan untuk setiap produk yang dipilih
    foreach ($produkList as $index => $namaProduk) {
        $produk = Produk::where('nama_produk', $namaProduk)->firstOrFail();
        $jumlah = $jumlahList[$namaProduk];
        $totalHargaPerProduk = $produk->harga * $jumlah;

        Penjualan::create([
            'nama_produk' => $namaProduk,
            'jumlah_pesanan' => $jumlah,
            'nama_pelanggan' => Auth::user()->name,
            'status' => 'pending',
            'total_harga' => $totalHargaPerProduk,
            'metode_pengiriman' => $validatedData['metode_pengiriman'],
            'alamat_pelanggan' => $validatedData['alamat_pelanggan'],
            'metode_pembayaran' => $validatedData['metode_pembayaran'],
            'tgl_transaksi' => now(),
        ]);

        $totalHarga += $totalHargaPerProduk;
    }

    // Hapus produk dari keranjang setelah pembayaran
    Keranjang::whereIn('nama_produk', $produkList)->delete();

    return redirect()->route('dashboard.keranjang')->with('success', 'Pembayaran berhasil diproses');
}

}
