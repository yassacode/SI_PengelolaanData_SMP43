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
        Schema::create('disciplines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('student_id')->nullable();
            $table->string('masalah');
            $table->string('kelas');
            $table->date('tanggal');
            $table->string('foto')->nullable();
            $table->string('solusi');
            $table->string('keterangan');
            $table->enum('status', ['WAITING', 'ACCEPTED', 'DENIED'])->default('WAITING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplines');
    }
};
