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
    Schema::table('walis', function (Blueprint $table) {
        $table->string('alamat_ayah')->nullable()->after('no_hp_ayah');
        $table->string('alamat_ibu')->nullable()->after('no_hp_ibu');
    });
}

public function down()
{
    Schema::table('walis', function (Blueprint $table) {
        $table->dropColumn(['alamat_ayah', 'alamat_ibu']);
    });
}
};
