<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'nama_produk', 'nama_produk');
    }
    public function penjualan() {
        return $this->hasOne(Penjualan::class);
    }
    public function User()
    {
        return $this->belongsTo(Produk::class, 'name', 'name');
    }


}
