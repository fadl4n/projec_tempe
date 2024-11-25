<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'nama_produk', 'nama_produk');
    }
    public function stok()
    {
        return $this->belongsTo(Stok::class, 'nama_produk', 'nama_produk');
    }

}
