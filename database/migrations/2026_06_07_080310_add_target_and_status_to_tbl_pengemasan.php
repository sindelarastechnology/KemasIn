<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_pengemasan', function (Blueprint $table) {
            $table->integer('target_jumlah')->after('tgl_pengemasan');
            $table->integer('hasil_pengemasan')->default(0)->after('target_jumlah');
            $table->integer('id_operator_ditugaskan')->nullable()->after('id_pengguna');
            $table->string('status')->default('direncanakan')->after('id_operator_ditugaskan');

            $table->foreign('id_operator_ditugaskan')->references('id_pengguna')->on('tbl_pengguna');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_pengemasan', function (Blueprint $table) {
            $table->dropForeign(['id_operator_ditugaskan']);
            $table->dropColumn(['target_jumlah', 'hasil_pengemasan', 'id_operator_ditugaskan', 'status']);
        });
    }
};
