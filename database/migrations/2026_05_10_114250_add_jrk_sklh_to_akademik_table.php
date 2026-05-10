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
    Schema::table('akademiks', function (Blueprint $table) {
        $table->string('jrk_sklh')->nullable()->after('asal_sd');
    });
}

public function down()
{
    Schema::table('akademiks', function (Blueprint $table) {
        $table->dropColumn('jrk_sklh');
    });
}
};
