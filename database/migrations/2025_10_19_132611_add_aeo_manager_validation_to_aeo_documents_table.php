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
            // AEO Manager Final Validation
            $table->boolean('aeo_manager_valid')->nullable()->after('validation_files');
            $table->text('aeo_manager_notes')->nullable()->after('aeo_manager_valid');
            $table->timestamp('aeo_manager_validated_at')->nullable()->after('aeo_manager_notes');
            $table->unsignedBigInteger('aeo_manager_validated_by')->nullable()->after('aeo_manager_validated_at');

            // Additional columns
            $table->text('rekomendasi')->nullable()->after('aeo_manager_validated_by');
            $table->date('due_date')->nullable()->after('rekomendasi');
            $table->enum('status', ['draft', 'in_review', 'approved', 'rejected', 'pending'])->default('draft')->after('due_date');

            // Foreign key constraint
            $table->foreign('aeo_manager_validated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aeo_documents', function (Blueprint $table) {
            $table->dropForeign(['aeo_manager_validated_by']);
            $table->dropColumn([
                'aeo_manager_valid',
                'aeo_manager_notes',
                'aeo_manager_validated_at',
                'aeo_manager_validated_by',
                'rekomendasi',
                'due_date',
                'status',
            ]);
        });
    }
};
