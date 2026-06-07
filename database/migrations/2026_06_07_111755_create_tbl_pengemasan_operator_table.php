<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_pengemasan_operator', function (Blueprint $table) {
            $table->integer('id_pengemasan_operator', true);
            $table->integer('id_pengemasan');
            $table->integer('id_pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_pengemasan_operator');
    }
};
