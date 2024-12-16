<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    // Izinkan semua kolom untuk diisi
    protected $guarded = [];

    /**
     * Relasi ke model Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'nama_produk', 'nama_produk');
    }

    /**
     * Relasi ke model Stok
     */
    public function stok()
    {
        return $this->belongsTo(Stok::class, 'nama_produk', 'nama_produk');
    }
     // Relasi dengan User (Pelanggan)
     public function user()
     {
         return $this->belongsTo(User::class, 'nama_pelanggan', 'name');
     }

    /**
     * Fungsi untuk mendapatkan label metode pembayaran.
     */
    public function getMetodePembayaranLabelAttribute()
    {
        $labels = [
            'cash' => 'Tunai',
            'rekening' => 'Transfer Rekening',
        ];

        return $labels[$this->metode_pembayaran] ?? 'Metode Lain';
    }

    /**
     * Fungsi untuk mengecek apakah pembayaran adalah cash.
     */
    public function isCash()
    {
        return $this->metode_pembayaran === 'cash';
    }

    /**
     * Fungsi untuk mengecek apakah pembayaran adalah rekening.
     */
    public function isRekening()
    {
        return $this->metode_pembayaran === 'rekening';
    }
    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'nama_produk', 'nama_produk');
    }
    // app/Models/Penjualan.php
protected $casts = [
    'tgl_transaksi' => 'datetime',
];

}
