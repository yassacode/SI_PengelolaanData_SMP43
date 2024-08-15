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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable();
            $table->foreignId('student_parent_id')->nullable();
            $table->foreignId('sibling_id')->nullable();
            $table->foreignId('history_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('achievement_id')->nullable();
            $table->string('nama')->nullable();;
            $table->integer('nisn')->nullable();;
            $table->string('ttl')->nullable();;
            $table->string('alamat')->nullable();;
            $table->integer('no_hp')->nullable();;
            $table->integer('tb')->nullable();;
            $table->integer('bb')->nullable();;
            $table->string('agama')->nullable();;
            $table->string('hobi')->nullable();;
            $table->integer('thn_msk')->nullable();;
            $table->enum('status', ['WAITING', 'ACCEPTED', 'DENIED'])->default('WAITING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
