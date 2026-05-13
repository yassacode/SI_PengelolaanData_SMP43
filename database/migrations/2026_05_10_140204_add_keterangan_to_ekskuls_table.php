<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('ekstrakurikulers', function (Blueprint $table) {
        // Menggunakan tipe 'text' agar bisa memuat deskripsi kegiatan yang panjang
        $table->text('keterangan')->nullable()->after('lokasi'); 
    });
}

public function down()
{
    Schema::table('ekstrakurikulers', function (Blueprint $table) {
        $table->dropColumn('keterangan');
    });
}
};
