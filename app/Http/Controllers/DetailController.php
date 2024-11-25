<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index($id)
    {
        // Ambil data produk beserta stok yang terkait menggunakan relasi
        $produk = Produk::with('stok')->findOrFail($id);

        // Kirim data produk dan stok ke view detail
        return view('dashboard.detail.index', compact('produk'));
    }
}
