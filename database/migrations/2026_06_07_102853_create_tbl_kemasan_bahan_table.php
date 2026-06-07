<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_kemasan_bahan', function (Blueprint $table) {
            $table->integer('id_kemasan_bahan', true);
            $table->integer('id_kemasan');
            $table->integer('id_bahan');
            $table->decimal('jumlah_per_unit', 10, 2);

            $table->foreign('id_kemasan')->references('id_kemasan')->on('tbl_kemasan')->onDelete('cascade');
            $table->foreign('id_bahan')->references('id_bahan')->on('tbl_bahan_baku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_kemasan_bahan');
    }
};
