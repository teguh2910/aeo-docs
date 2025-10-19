<?php

namespace Database\Seeders;

use App\Models\AeoDocument;
use App\Models\AeoQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;

class AeoQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a sample question
        $question = AeoQuestion::create([
            'subcriteria' => 'Kepatuhan terhadap peraturan kepabeanan dan/atau peraturan lain terkait',
            'question' => 'Apakah Saudara memiliki prosedur terkait dengan pembuatan dan penyampaian dokumen kepabeanan dan penjaminan kualitas?',
            'keterangan' => 'Operator Ekonomi mempunyai prosedur terkait penyiapan dan penyampaian dokumen kepabeanan serta penjaminan mutunya',
            'files' => [],
        ]);

        // Get purchasing user
        $purchasingUser = User::where('email', 'purchasing@example.com')->first();
        $financeUser = User::where('email', 'finance@aeo.com')->first();

        // Create document for purchasing dept
        if ($purchasingUser) {
            AeoDocument::create([
                'aeo_question_id' => $question->id,
                'dept' => 'PURCHASING',
                'nama_dokumen' => 'SOP Purchasing Department',
                'no_sop_wi_std_form_other' => 'SOP-PUR-001',
                'files' => [],
                'created_by' => $purchasingUser->id,
                'updated_by' => $purchasingUser->id,
            ]);
        }

        // Create document for finance dept (purchasing user cannot edit this)
        if ($financeUser) {
            AeoDocument::create([
                'aeo_question_id' => $question->id,
                'dept' => 'FINANCE',
                'nama_dokumen' => 'SOP Finance Department',
                'no_sop_wi_std_form_other' => 'SOP-FIN-001',
                'files' => [],
                'created_by' => $financeUser->id,
                'updated_by' => $financeUser->id,
            ]);
        }
    }
}
