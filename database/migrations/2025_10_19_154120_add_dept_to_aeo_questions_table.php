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
        Schema::table('aeo_questions', function (Blueprint $table) {
            $table->string('dept')->nullable()->after('jawaban')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aeo_questions', function (Blueprint $table) {
            $table->dropColumn('dept');
        });
    }
};
