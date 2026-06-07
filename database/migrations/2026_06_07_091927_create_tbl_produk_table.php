<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_produk', function (Blueprint $table) {
            $table->integer('id_produk', true);
            $table->string('nama_produk', 100);
            $table->integer('stok_tersedia')->default(0);
            $table->integer('stok_minimum');
            $table->decimal('harga_produk', 12, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_produk');
    }
};
