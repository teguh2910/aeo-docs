<?php

namespace App\Imports;

use App\Models\AeoQuestion;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class AeoQuestionImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        return new AeoQuestion([
            'subcriteria' => $row['subcriteria'],
            'question' => $row['question'],
            'keterangan' => $row['keterangan'] ?? null,
            'files' => null, // Files will be uploaded separately
        ]);
    }

    public function rules(): array
    {
        return [
            'subcriteria' => 'required|string|max:255|unique:aeo_questions,subcriteria',
            'question' => 'required|string',
            'keterangan' => 'nullable|string',
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