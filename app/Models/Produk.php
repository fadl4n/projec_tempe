<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Semua kolom dapat diisi kecuali yang ada di guarded
    protected $guarded = [];

    /**
     * Relasi ke model Stok
     * Produk memiliki satu stok
     */
    public function stok()
    {
        return $this->hasOne(Stok::class, 'nama_produk', 'nama_produk');
    }
}
