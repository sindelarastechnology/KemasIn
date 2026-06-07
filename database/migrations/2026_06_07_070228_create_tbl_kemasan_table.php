<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_kemasan', function (Blueprint $table) {
            $table->integer('id_kemasan', true);
            $table->string('nama_kemasan', 100);
            $table->string('ukuran', 50);
            $table->integer('stok_kemasan')->default(0);
            $table->decimal('harga_kemasan', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_kemasan');
    }
};
