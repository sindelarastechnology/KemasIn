<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_pengemasan', function (Blueprint $table) {
            $table->integer('id_produk')->after('id_pengemasan');
            $table->foreign('id_produk')->references('id_produk')->on('tbl_produk');

            $table->integer('id_produksi')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tbl_pengemasan', function (Blueprint $table) {
            $table->dropForeign(['id_produk']);
            $table->dropColumn('id_produk');

            $table->integer('id_produksi')->nullable(false)->change();
        });
    }
};
