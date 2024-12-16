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
        Schema::table('penjualans', function (Blueprint $table) {
            $table->enum('metode_pengiriman', ['dijemput', 'diantar'])->default('dijemput');
            $table->enum('metode_pembayaran', ['cash', 'rekening'])->default('cash');
        });
    }

    public function down()
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->dropColumn(['metode_pengiriman', 'metode_pembayaran']);
        });
    }
};
