<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class PelangganController extends Controller
{
    /**
     * Buat middleware untuk memastikan hanya pengguna non-admin yang bisa mengakses controller ini.
     */
   

    /**
     * Menampilkan daftar produk kepada pelanggan.
     */
    public function index()
    {
        // Mengambil data produk dari database dengan paginasi
        $produks = Produk::paginate(8); // Sesuaikan jumlah produk per halaman jika diperlukan

        // Menampilkan view 'dashboard.dash-user.index' dan mengirimkan data produk
        return view('dashboard.dash-user.index', compact('produks'));
    }

    /**
     * Fungsi-fungsi berikut ini (create, store, show, edit, update, destroy)
     * tidak diperlukan jika pelanggan hanya bisa melihat daftar produk.
     * Jika nantinya ingin menambah fitur lain untuk pelanggan,
     * bisa menggunakan fungsi-fungsi ini.
     */

    public function create()
    {
        // Tidak diperlukan untuk pelanggan
    }

    public function store(Request $request)
    {
        // Tidak diperlukan untuk pelanggan
    }

    public function show(string $id)
    {
        // Tidak diperlukan untuk pelanggan
    }

    public function edit(string $id)
    {
        // Tidak diperlukan untuk pelanggan
    }

    public function update(Request $request, string $id)
    {
        // Tidak diperlukan untuk pelanggan
    }

    public function destroy(string $id)
    {
        // Tidak diperlukan untuk pelanggan
    }
}
