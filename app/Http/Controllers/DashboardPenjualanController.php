<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\Stok;
use Illuminate\Http\Request;

class DashboardPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Penjualan::with('produk');

    // Filter berdasarkan bulan dan tahun jika ada
    if ($request->filled('bulan') && $request->filled('tahun')) {
        $query->whereMonth('tgl_transaksi', $request->bulan)
              ->whereYear('tgl_transaksi', $request->tahun);
    }

    // Urutkan berdasarkan status: pending -> proses -> selesai
    $query->orderByRaw("
        CASE
            WHEN status = 'pending' THEN 1
            WHEN status = 'proses' THEN 2
            WHEN status = 'selesai' THEN 3
            ELSE 4
        END
    ");

    // Urutkan tambahan berdasarkan tanggal transaksi
    $query->orderBy('tgl_transaksi', 'asc');

    $penjualan = $query->paginate(10);

    return view('dashboard.penjualan.index', ['penjualans' => $penjualan]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produk = Produk::all();
        return view('dashboard.penjualan.create', compact('produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'alamat_pelanggan' => 'required|string',
            'nama_produk' => 'required|string',
            'jumlah_pesanan' => 'required|integer|min:1',
            'tgl_transaksi' => 'required|date',
            'status' => 'required',
        ]);

        // Ambil harga produk berdasarkan nama produk
        $produk = Produk::where('nama_produk', $request->nama_produk)->firstOrFail();

        // Ambil stok berdasarkan nama produk
        $stok = Stok::where('nama_produk', $request->nama_produk)->firstOrFail();


    // Validasi stok tersedia
    if ($request->jumlah_pesanan > $stok->jumlah) {
        return back()->withInput()->with('error', 'Stok belum mencukupi! Total stok yang ada: ' . $stok->jumlah);
    }

        // Kurangi stok
        $stok->jumlah -= $request->jumlah_pesanan;
        $stok->save();

        // Kalkulasi total harga
        $validated['total_harga'] = $request->jumlah_pesanan * $produk->harga;

        // Buat penjualan
        Penjualan::create(array_merge($validated, ['nama_produk' => $produk->nama_produk]));

        return redirect()->route('dashboard-penjualan.index')
                         ->with('success', 'Data penjualan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $produk = Produk::all();

        return view('dashboard.penjualan.edit', compact('produk', 'penjualan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([

            'alamat_pelanggan' => 'required|string',
            'nama_produk' => 'required|string',
            'jumlah_pesanan' => 'required|integer|min:1',
            'tgl_transaksi' => 'required|date',
            'status' => 'required',
        ]);

        $penjualan = Penjualan::findOrFail($id);
        $stok = Stok::where('nama_produk', $penjualan->nama_produk)->firstOrFail();

        // Mengembalikan stok jika jumlah pesanan diupdate
        if ($request->jumlah_pesanan !== $penjualan->jumlah_pesanan) {
            $stok->jumlah += $penjualan->jumlah_pesanan;

            // Validasi stok setelah update
            if ($request->jumlah_pesanan > $stok->jumlah) {
                return back()->with('error', 'Jumlah pesanan melebihi stok yang tersedia setelah update!');
            }

            $stok->jumlah -= $request->jumlah_pesanan;
            $stok->save();
        }

        // Ambil harga produk berdasarkan nama produk
        $produk = Produk::where('nama_produk', $request->nama_produk)->firstOrFail();

        // Kalkulasi total harga
        $validated['total_harga'] = $request->jumlah_pesanan * $produk->harga;

        // Update penjualan
        Penjualan::where('id', $id)->update($validated);

        return redirect()->route('dashboard-penjualan.index')
                         ->with('success', 'Data penjualan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $stok = Stok::where('nama_produk', $penjualan->nama_produk)->firstOrFail();

        // Kembalikan stok yang terjual
        $stok->jumlah += $penjualan->jumlah_pesanan;
        $stok->save();

        // Hapus data penjualan
        $penjualan->delete();

        return redirect()->route('dashboard-penjualan.index')
                         ->with('success', 'Data penjualan berhasil dihapus.');
    }
    /**
 * Show the details of a resource.
 */
public function detail(string $id)
{
    $penjualan = Penjualan::findOrFail($id);
    return view('dashboard.penjualan.detail', compact('penjualan'));
}

/**
 * Update the status of a resource.
 */
public function updateStatus(Request $request, string $id)
{
    $penjualan = Penjualan::findOrFail($id);

   

    // Menyimpan jumlah stok yang akan diubah
    $stok = Stok::where('nama_produk', $penjualan->nama_produk)->firstOrFail();

    // Jika status diubah menjadi batal, kita kembalikan stok
    if ($request->status == 'batal' && $penjualan->status != 'batal') {
        // Mengembalikan stok jika status sebelumnya bukan 'batal'
        $stok->jumlah += $penjualan->jumlah_pesanan;
        $stok->save();
    }

    // Update status penjualan
    $penjualan->update(['status' => $request->status]);

    // Jika status berubah dari 'batal' ke status lain, kurangi stok lagi
    if ($request->status != 'batal' && $penjualan->status == 'batal') {
        $stok->jumlah -= $penjualan->jumlah_pesanan;
        $stok->save();
    }

    return redirect()->route('dashboard-penjualan.index')
                     ->with('success', 'Status penjualan berhasil diperbarui');
}


/**
 * Display the specified resource (detail penjualan).
 */
public function show($id)
{
    // Mengambil data penjualan berdasarkan ID
    $penjualan = Penjualan::findOrFail($id);

    // Mengambil produk yang memiliki nama yang sama dengan nama_produk di tabel penjualan
    $produk = Produk::where('nama_produk', $penjualan->nama_produk)->get();

    return view('dashboard.penjualan.detail', compact('penjualan', 'produk'));
}


}
