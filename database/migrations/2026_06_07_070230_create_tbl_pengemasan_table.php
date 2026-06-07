<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_pengemasan', function (Blueprint $table) {
            $table->integer('id_pengemasan', true);
            $table->integer('id_produksi');
            $table->integer('id_kemasan');
            $table->date('tgl_pengemasan');
            $table->integer('jumlah_dikemas')->nullable();
            $table->date('expired_date');
            $table->integer('id_pengguna');
            $table->timestamps();

            $table->foreign('id_produksi')->references('id_produksi')->on('tbl_produksi');
            $table->foreign('id_kemasan')->references('id_kemasan')->on('tbl_kemasan');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('tbl_pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_pengemasan');
    }
};
