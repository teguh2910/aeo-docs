<?php

namespace App\Imports;

use App\Models\AeoDocument;
use App\Models\AeoQuestion;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class AeoDocumentImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        $user = Auth::user();

        // Find the question by subcriteria or question text
        $question = AeoQuestion::where('subcriteria', $row['subcriteria'])
            ->orWhere('question', $row['question'])
            ->first();

        if (!$question) {
            // Skip if question not found
            return null;
        }

        return new AeoDocument([
            'aeo_question_id' => $question->id,
            'dept' => $row['dept'] ?? $user->dept,
            'nama_dokumen' => $row['nama_dokumen'],
            'no_sop_wi_std_form_other' => $row['no_sop_wi_std_form_other'] ?? null,
            'files' => null, // Files will be uploaded separately
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'subcriteria' => 'required|string|max:255',
            'question' => 'nullable|string|max:255',
            'dept' => 'nullable|string|max:100',
            'nama_dokumen' => 'required|string|max:255',
            'no_sop_wi_std_form_other' => 'nullable|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'subcriteria.required' => 'The subcriteria field is required.',
            'nama_dokumen.required' => 'The document name field is required.',
        ];
    }
}