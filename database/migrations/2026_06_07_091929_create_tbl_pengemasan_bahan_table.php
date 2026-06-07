<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_pengemasan_bahan', function (Blueprint $table) {
            $table->integer('id_pengemasan_bahan', true);
            $table->integer('id_pengemasan');
            $table->integer('id_bahan');
            $table->decimal('jumlah_per_unit', 10, 2);
            $table->decimal('total_terealisasi', 10, 2)->default(0);

            $table->foreign('id_pengemasan')->references('id_pengemasan')->on('tbl_pengemasan')->cascadeOnDelete();
            $table->foreign('id_bahan')->references('id_bahan')->on('tbl_bahan_baku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_pengemasan_bahan');
    }
};
