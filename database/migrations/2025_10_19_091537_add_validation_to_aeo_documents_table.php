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
            $table->boolean('is_valid')->default(true)->after('files');
            $table->text('validation_notes')->nullable()->after('is_valid');
            $table->timestamp('validated_at')->nullable()->after('validation_notes');
            $table->foreignId('validated_by')->nullable()->constrained('users')->after('validated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aeo_documents', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropColumn(['is_valid', 'validation_notes', 'validated_at', 'validated_by']);
        });
    }
};
