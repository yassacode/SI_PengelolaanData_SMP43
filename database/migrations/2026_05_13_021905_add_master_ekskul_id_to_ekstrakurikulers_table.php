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
        Schema::table('ekstrakurikulers', function (Blueprint $table) {
            $table->foreignId('master_ekskul_id')->nullable()->after('user_id')->constrained('master_ekskuls')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ekstrakurikulers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('master_ekskul_id');
        });
    }
};
