<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_produk', function (Blueprint $table) {
            $table->integer('stok_sudah_dikemas')->default(0)->after('stok_tersedia');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_produk', function (Blueprint $table) {
            $table->dropColumn('stok_sudah_dikemas');
        });
    }
};
