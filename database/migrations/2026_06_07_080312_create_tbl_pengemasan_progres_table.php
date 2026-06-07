<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_pengemasan_progres', function (Blueprint $table) {
            $table->integer('id_progres', true);
            $table->integer('id_pengemasan');
            $table->integer('id_pengguna');
            $table->integer('jumlah_dikemas');
            $table->text('keterangan')->nullable();
            $table->datetime('waktu_diproses')->nullable();

            $table->foreign('id_pengemasan')->references('id_pengemasan')->on('tbl_pengemasan')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('tbl_pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_pengemasan_progres');
    }
};
