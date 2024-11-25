<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'nama_produk'); // Asumsikan ada foreign key stok_id di tabel penjualan
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'nama_produk', 'nama_produk');
    }

}
