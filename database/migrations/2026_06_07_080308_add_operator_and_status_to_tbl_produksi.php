<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_produksi', function (Blueprint $table) {
            $table->integer('id_operator_ditugaskan')->nullable()->after('id_pengguna');
            $table->foreign('id_operator_ditugaskan')->references('id_pengguna')->on('tbl_pengguna');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_produksi', function (Blueprint $table) {
            $table->dropForeign(['id_operator_ditugaskan']);
            $table->dropColumn('id_operator_ditugaskan');
        });

        // Status column is string type; no ALTER needed on rollback
    }
};
