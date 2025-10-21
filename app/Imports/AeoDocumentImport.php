<?php

namespace App\Imports;

use App\Models\AeoDocument;
use App\Models\AeoQuestion;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AeoDocumentImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        $user = Auth::user();

        $documentType = strtolower(trim($row['document_type'] ?? 'master'));
        if (! in_array($documentType, ['master', 'new'], true)) {
            $documentType = 'master';
        }

        $dept = $row['dept'] ?? ($user->dept ?? 'GENERAL');
        if ($user && method_exists($user, 'canAccessAllDepartments') && ! $user->canAccessAllDepartments()) {
            $dept = $user->dept ?? 'GENERAL';
        }

        // Find the question by subcriteria or question text
        $question = AeoQuestion::where('subcriteria', $row['subcriteria'])
            ->orWhere('question', $row['question'])
            ->first();

        if (! $question) {
            // Skip if question not found
            return null;
        }

        return new AeoDocument([
            'aeo_question_id' => $question->id,
            'document_type' => $documentType,
            'dept' => $dept,
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
            'question' => 'nullable|string',
            'dept' => 'nullable|string|max:100',
            'document_type' => 'nullable|in:master,new',
            'nama_dokumen' => 'required|string|max:255',
            'no_sop_wi_std_form_other' => 'nullable|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'subcriteria.required' => 'The subcriteria field is required.',
            'nama_dokumen.required' => 'The document name field is required.',
            'document_type.in' => 'The document type must be either master or new.',
        ];
    }
}
