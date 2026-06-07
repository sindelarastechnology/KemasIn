<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tbl_kemasan', function (Blueprint $table) {
            $table->dropColumn('stok_kemasan');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_kemasan', function (Blueprint $table) {
            $table->integer('stok_kemasan')->default(0);
        });
    }
};
