<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up(): void {
Schema::create('aeo_documents', function (Blueprint $table) {
$table->id();
$table->foreignId('aeo_question_id')->constrained('aeo_questions')->cascadeOnDelete();
$table->string('dept', 100)->index();
$table->string('name');
$table->string('no_sop_wi_std_form_other')->nullable();
// multiple file paths stored as JSON, e.g. ["aeo/uuid1.pdf", "aeo/uuid2.jpg"]
$table->json('files')->nullable();
$table->foreignId('created_by')->constrained('users');
$table->foreignId('updated_by')->nullable()->constrained('users');
$table->timestamps();
});
}
public function down(): void { Schema::dropIfExists('aeo_documents'); }
};