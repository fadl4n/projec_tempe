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
        Schema::table('pengeluarans', function (Blueprint $table) {
            // Adding a 'kategori' column with allowed values
            $table->enum('kategori', ['bahan', 'jasa', 'lainnya'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengeluarans', function (Blueprint $table) {
            // Dropping the 'kategori' column
            $table->dropColumn('kategori');
        });
    }
};
