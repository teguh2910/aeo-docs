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
        Schema::table('aeo_documents', function (Blueprint $table) {
            $table->dropColumn(['rekomendasi', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aeo_documents', function (Blueprint $table) {
            $table->text('rekomendasi')->nullable()->after('aeo_manager_validated_by');
            $table->date('due_date')->nullable()->after('rekomendasi');
        });
    }
};
