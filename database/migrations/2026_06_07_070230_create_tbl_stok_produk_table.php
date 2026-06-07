<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_stok_produk', function (Blueprint $table) {
            $table->integer('id_stok', true);
            $table->integer('id_kemasan');
            $table->string('jenis_produk', 100);
            $table->integer('stok_tersedia')->default(0);
            $table->integer('stok_minimum');
            $table->datetime('updated_at')->nullable();

            $table->foreign('id_kemasan')->references('id_kemasan')->on('tbl_kemasan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_stok_produk');
    }
};
