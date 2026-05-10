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
    Schema::table('disiplins', function (Blueprint $table) {
        // Saya menggunakan tipe 'text' agar bisa menampung cerita kronologi yang panjang
        $table->text('keterangan')->nullable()->after('tanggal'); 
    });
}

public function down()
{
    Schema::table('disiplins', function (Blueprint $table) {
        $table->dropColumn('keterangan');
    });
}
};
