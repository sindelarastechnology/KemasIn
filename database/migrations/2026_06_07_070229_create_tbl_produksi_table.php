<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_produksi', function (Blueprint $table) {
            $table->integer('id_produksi', true);
            $table->string('kode_batch', 20)->unique();
            $table->date('tgl_produksi');
            $table->string('jenis_produk', 100);
            $table->integer('target_jumlah');
            $table->integer('hasil_produksi')->default(0);
            $table->integer('id_pengguna');
            $table->string('status')->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('tbl_pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_produksi');
    }
};
