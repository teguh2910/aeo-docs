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
            // Approval 1 fields
            $table->boolean('approval_1')->nullable()->after('dept');
            $table->timestamp('approval_1_at')->nullable()->after('approval_1');
            $table->unsignedBigInteger('approval_1_by')->nullable()->after('approval_1_at');
            $table->text('approval_1_notes')->nullable()->after('approval_1_by');

            // Approval 2 fields
            $table->boolean('approval_2')->nullable()->after('approval_1_notes');
            $table->timestamp('approval_2_at')->nullable()->after('approval_2');
            $table->unsignedBigInteger('approval_2_by')->nullable()->after('approval_2_at');
            $table->text('approval_2_notes')->nullable()->after('approval_2_by');

            // Foreign key constraints
            $table->foreign('approval_1_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approval_2_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aeo_questions', function (Blueprint $table) {
            $table->dropForeign(['approval_1_by']);
            $table->dropForeign(['approval_2_by']);
            $table->dropColumn([
                'approval_1',
                'approval_1_at',
                'approval_1_by',
                'approval_1_notes',
                'approval_2',
                'approval_2_at',
                'approval_2_by',
                'approval_2_notes',
            ]);
        });
    }
};
