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
        Schema::create('pengesahan_laporans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_laporan');
            $table->string('periode');
            $table->date('tgl_disahkan')->nullable();
            $table->string('status_kepsek')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengesahan_laporans');
    }
};
