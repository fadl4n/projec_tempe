<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->timestamp('tanggal_keranjang')->useCurrent(); // Menambahkan kolom timestamp dengan default CURRENT_TIMESTAMP
        });
    }

    public function down()
    {
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->dropColumn('tanggal_keranjang');
        });
    }
};
