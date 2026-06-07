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
        Schema::create('tbl_mutasi_bahan', function (Blueprint $table) {
            $table->integer('id_mutasi', true);
            $table->integer('id_bahan');
            $table->string('jenis', 30); // pemakaian, penambahan, penyesuaian, bahan_baru
            $table->decimal('jumlah', 10, 2)->default(0);
            $table->decimal('stok_sebelum', 10, 2)->default(0);
            $table->decimal('stok_sesudah', 10, 2)->default(0);
            $table->decimal('harga_sebelum', 12, 2)->nullable();
            $table->decimal('harga_sesudah', 12, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('id_pengguna')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_mutasi_bahan');
    }
};
