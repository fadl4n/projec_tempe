<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            $table->string('gambar');
            $table->string('nama_produk');
            $table->string('jumlah_keranjang');
            $table->string('harga');
            $table->string('total_harga_keranjang');
            $table->string('tanggal_keranjang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
