<?php

namespace App\Imports;

use App\Models\AeoQuestion;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AeoQuestionImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        $userDept = Auth::user()->dept ?? 'GENERAL';

        // Handle both 'department_code' and 'dept' column names
        $dept = $row['department_code'] ?? $row['dept'] ?? $userDept;

        return new AeoQuestion([
            'subcriteria' => $row['subcriteria'],
            'question' => $row['question'],
            'keterangan' => $row['keterangan'] ?? null,
            'jawaban' => $row['jawaban'] ?? null,
            'files' => null, // Files will be uploaded separately
            'dept' => $dept,
        ]);
    }

    public function rules(): array
    {
        return [
            'subcriteria' => 'required|string|max:255',
            'question' => 'required|string',
            'keterangan' => 'nullable|string',
            'jawaban' => 'nullable|string',
            'department_code' => 'nullable|string|max:100',
            'dept' => 'nullable|string|max:100',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'subcriteria.required' => 'The subcriteria field is required.',
            'subcriteria.unique' => 'The subcriteria must be unique.',
            'question.required' => 'The question field is required.',
        ];
    }
}
