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
            // Internal Audit Approval fields
            $table->boolean('internal_audit_approval')->nullable()->after('approval_2_notes');
            $table->timestamp('internal_audit_approval_at')->nullable()->after('internal_audit_approval');
            $table->unsignedBigInteger('internal_audit_approval_by')->nullable()->after('internal_audit_approval_at');
            $table->text('internal_audit_approval_notes')->nullable()->after('internal_audit_approval_by');

            // Foreign key constraint
            $table->foreign('internal_audit_approval_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aeo_questions', function (Blueprint $table) {
            $table->dropForeign(['internal_audit_approval_by']);
            $table->dropColumn([
                'internal_audit_approval',
                'internal_audit_approval_at',
                'internal_audit_approval_by',
                'internal_audit_approval_notes',
            ]);
        });
    }
};
