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
        Schema::create('parts', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->string('slug')->unique();
            $table->string('url');
            $table->foreignId('instrument_id')->constrained();
            $table->foreignId('voice_id')->constrained();
            $table->foreignId('full_score_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
