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
            $table->enum('document_type', ['master', 'new'])->default('master')->after('aeo_question_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aeo_documents', function (Blueprint $table) {
            $table->dropColumn('document_type');
        });
    }
};
