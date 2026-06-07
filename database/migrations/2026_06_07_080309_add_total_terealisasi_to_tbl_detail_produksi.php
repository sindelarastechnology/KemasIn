<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_detail_produksi', function (Blueprint $table) {
            $table->decimal('total_terealisasi', 10, 2)->default(0)->after('jumlah_digunakan');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_detail_produksi', function (Blueprint $table) {
            $table->dropColumn('total_terealisasi');
        });
    }
};
