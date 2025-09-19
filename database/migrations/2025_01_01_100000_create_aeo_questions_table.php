<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up(): void {
Schema::create('aeo_questions', function (Blueprint $table) {
$table->id();
$table->string('subcriteria');
$table->text('question');
$table->text('keterangan')->nullable();
$table->timestamps();
});
}
public function down(): void { Schema::dropIfExists('aeo_questions'); }
};