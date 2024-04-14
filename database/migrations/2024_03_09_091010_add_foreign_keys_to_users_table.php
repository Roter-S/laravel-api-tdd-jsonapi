<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('instrument_id')->references('id')->on('instruments');
            $table->foreign('voice_id')->references('id')->on('voices');
            $table->foreign('entity_id')->references('id')->on('entities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['instrument_id']);
            $table->dropForeign(['voice_id']);
            $table->dropForeign(['entity_id']);

            $table->dropColumn('instrument_id');
            $table->dropColumn('voice_id');
            $table->dropColumn('entity_id');
        });
    }
};
