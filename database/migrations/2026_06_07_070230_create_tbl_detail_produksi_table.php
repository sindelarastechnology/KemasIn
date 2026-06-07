<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_detail_produksi', function (Blueprint $table) {
            $table->integer('id_detail', true);
            $table->integer('id_produksi');
            $table->integer('id_bahan');
            $table->decimal('jumlah_digunakan', 10, 2);

            $table->foreign('id_produksi')->references('id_produksi')->on('tbl_produksi')->onDelete('cascade');
            $table->foreign('id_bahan')->references('id_bahan')->on('tbl_bahan_baku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_detail_produksi');
    }
};
