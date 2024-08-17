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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('kegiatan1')->nullable(); 
            $table->integer('juara1')->nullable(); 
            $table->string('kegiatan2')->nullable(); 
            $table->integer('juara2')->nullable(); 
            $table->string('kegiatan3')->nullable(); 
            $table->integer('juara3')->nullable(); 
            $table->string('kegiatan4')->nullable(); 
            $table->integer('juara4')->nullable(); 
            $table->string('kegiatan5')->nullable(); 
            $table->integer('juara5')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
