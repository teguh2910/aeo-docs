<?php

namespace Tests\Feature;

use App\Models\AeoDocument;
use App\Models\AeoQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AeoManagerValidationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected AeoQuestion $question;

    protected AeoDocument $document;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['dept' => 'IT']);

        $this->question = AeoQuestion::create([
            'subcriteria' => 'Test Subcriteria',
            'question' => 'Test Question',
            'dept' => 'IT',
        ]);

        $this->document = AeoDocument::create([
            'aeo_question_id' => $this->question->id,
            'dept' => 'IT',
            'nama_dokumen' => 'Test Document',
            'no_sop_wi_std_form_other' => 'TEST-001',
            'document_type' => 'master',
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
    }

    public function test_aeo_manager_can_mark_question_as_sesuai(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('aeo.questions.aeo-manager-validation', $this->question), [
                'validation_status' => 'sesuai',
            ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->document->refresh();
        $this->assertTrue($this->document->aeo_manager_valid);
        $this->assertNotNull($this->document->aeo_manager_validated_at);
        $this->assertEquals($this->user->id, $this->document->aeo_manager_validated_by);
    }

    public function test_aeo_manager_can_mark_question_as_tidak_sesuai_with_notes_and_due_date(): void
    {
        $notes = 'Document needs revision';
        $dueDate = now()->addDays(7)->format('Y-m-d');

        $response = $this->actingAs($this->user)
            ->postJson(route('aeo.questions.aeo-manager-validation', $this->question), [
                'validation_status' => 'tidak_sesuai',
                'aeo_manager_notes' => $notes,
                'due_date' => $dueDate,
            ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->document->refresh();
        $this->assertFalse($this->document->aeo_manager_valid);
        $this->assertEquals($notes, $this->document->aeo_manager_notes);
        $this->assertEquals($dueDate, $this->document->due_date->format('Y-m-d'));
        $this->assertNotNull($this->document->aeo_manager_validated_at);
        $this->assertEquals($this->user->id, $this->document->aeo_manager_validated_by);
    }

    public function test_validation_requires_valid_status(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('aeo.questions.aeo-manager-validation', $this->question), [
                'validation_status' => 'invalid_status',
            ]);

        $response->assertStatus(422);
    }

    public function test_user_cannot_validate_question_from_different_department(): void
    {
        $otherDeptQuestion = AeoQuestion::create([
            'subcriteria' => 'Other Dept Subcriteria',
            'question' => 'Other Dept Question',
            'dept' => 'HR',
        ]);

        $response = $this->actingAs($this->user)
            ->postJson(route('aeo.questions.aeo-manager-validation', $otherDeptQuestion), [
                'validation_status' => 'sesuai',
            ]);

        $response->assertStatus(403);
    }
}
