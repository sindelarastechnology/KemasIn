<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_bahan_baku', function (Blueprint $table) {
            $table->integer('id_bahan', true);
            $table->string('nama_bahan', 100);
            $table->string('satuan', 20);
            $table->decimal('stok_tersedia', 10, 2)->default(0);
            $table->decimal('stok_minimum', 10, 2);
            $table->decimal('harga_per_satuan', 12, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_bahan_baku');
    }
};
