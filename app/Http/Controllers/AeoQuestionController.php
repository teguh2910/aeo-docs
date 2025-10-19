<?php

namespace App\Http\Controllers;

use App\Imports\AeoQuestionImport;
use App\Models\AeoQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AeoQuestionController extends Controller
{
    public function index()
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Group questions by subcriteria for better display
        // Filter questions to show only those from user's department
        $rows = AeoQuestion::where('dept', $userDept)
            ->with([
                'documents' => function ($query) use ($userDept) {
                    $query->where('dept', $userDept);
                },
                'documents.creator',
                'documents.validator',
                'approval1By',
                'approval2By',
            ])
            ->orderBy('subcriteria')
            ->orderBy('id')
            ->get()
            ->groupBy('subcriteria');

        return view('aeo.questions.index', compact('rows'));
    }

    public function showDocuments(AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Check if user can access this question (question must be from their department)
        if ($question->dept !== $userDept) {
            abort(403, 'You can only access questions from your department.');
        }

        // Load documents filtered by user's department
        $question->load([
            'documents' => function ($query) use ($userDept) {
                $query->where('dept', $userDept);
            },
            'documents.creator',
            'documents.validator',
            'documents.aeoManagerValidator',
        ]);

        return view('aeo.questions.documents', compact('question'));
    }

    public function create()
    {
        return view('aeo.questions.create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'subcriteria' => 'required|string|max:255',
            'question' => 'required|string',
            'keterangan' => 'nullable|string',
            'jawaban' => 'nullable|string',
            'files.*' => 'file|max:10240',
        ]);

        $paths = [];
        if ($r->hasFile('files')) {
            foreach ($r->file('files') as $file) {
                $paths[] = $file->store('aeo', 'public');
            }
        }
        $data['files'] = $paths;

        // Automatically assign user's department to the question
        $data['dept'] = auth()->user()->dept ?? 'GENERAL';

        AeoQuestion::create($data);

        return redirect()->route('aeo.questions.index')->with('success', 'Question created successfully');
    }

    public function edit(AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Check if user can edit this question (question must be from their department)
        if ($question->dept !== $userDept) {
            abort(403, 'You can only edit questions from your department.');
        }

        return view('aeo.questions.edit', compact('question'));
    }

    public function update(Request $r, AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Check if user can update this question (question must be from their department)
        if ($question->dept !== $userDept) {
            abort(403, 'You can only update questions from your department.');
        }

        $data = $r->validate([
            'subcriteria' => 'required|string|max:255',
            'question' => 'required|string',
            'keterangan' => 'nullable|string',
            'jawaban' => 'nullable|string',
            'files.*' => 'file|max:10240',
        ]);

        $paths = $question->files ?? [];
        if ($r->hasFile('files')) {
            foreach ($r->file('files') as $file) {
                $paths[] = $file->store('aeo', 'public');
            }
        }
        $data['files'] = $paths;

        $question->update($data);

        return redirect()->route('aeo.questions.index')->with('success', 'Question updated successfully');
    }

    public function destroy(AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Check if user can delete this question (question must be from their department)
        if ($question->dept !== $userDept) {
            abort(403, 'You can only delete questions from your department.');
        }

        // Delete files from the question itself
        foreach (($question->files ?? []) as $p) {
            if (Storage::disk('public')->exists($p)) {
                Storage::disk('public')->delete($p);
            }
        }

        // Delete files from all related documents
        foreach ($question->documents as $document) {
            foreach (($document->files ?? []) as $p) {
                if (Storage::disk('public')->exists($p)) {
                    Storage::disk('public')->delete($p);
                }
            }
        }

        // Delete the question (cascade will delete documents via database)
        $question->delete();

        return back()->with('success', 'Question and all related documents deleted successfully');
    }

    public function importForm()
    {
        return view('aeo.questions.import');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        try {
            Excel::import(new AeoQuestionImport, $request->file('excel_file'));

            return redirect()->route('aeo.questions.index')->with('success', 'Questions imported successfully from Excel file');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Row {$failure->row()}: ".implode(', ', $failure->errors());
            }

            return redirect()->back()->withErrors($errors);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['excel_file' => 'Error importing Excel file: '.$e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="aeo_questions_template.csv"',
        ];

        return response()->download(public_path('templates/aeo_questions_template.csv'), 'aeo_questions_template.csv', $headers);
    }

    public function updateAeoManagerValidation(Request $request, AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Check if user can validate this question (question must be from their department)
        if ($question->dept !== $userDept) {
            abort(403, 'You can only validate questions from your department.');
        }

        $data = $request->validate([
            'validation_status' => 'required|in:sesuai,tidak_sesuai',
            'aeo_manager_notes' => 'nullable|string|max:1000',
            'due_date' => 'nullable|date|after:today',
        ]);

        // Update all documents for this question
        $question->documents()->update([
            'aeo_manager_valid' => $data['validation_status'] === 'sesuai' ? 1 : 0,
            'aeo_manager_notes' => $data['aeo_manager_notes'] ?? null,
            'due_date' => $data['due_date'] ?? null,
            'aeo_manager_validated_at' => now(),
            'aeo_manager_validated_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => $data['validation_status'] === 'sesuai'
                ? 'Documents marked as valid by AEO Manager'
                : 'Documents marked as invalid by AEO Manager with notes and due date',
        ]);
    }

    public function undoAllAeoManagerValidations(Request $request, AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Check if user can access this question (question must be from their department)
        if ($question->dept !== $userDept) {
            abort(403, 'You can only access questions from your department.');
        }

        // Get all documents for this question from user's department
        $documents = $question->documents()->where('dept', $userDept)->get();

        // Undo AEO Manager validation for all documents
        foreach ($documents as $document) {
            $document->update([
                'aeo_manager_valid' => null,
                'aeo_manager_notes' => null,
                'aeo_manager_validated_at' => null,
                'aeo_manager_validated_by' => null,
                'updated_by' => auth()->id(),
                // Update status based on document type
                'status' => $document->document_type === 'master' ? 'in_review' : 'draft',
            ]);
        }

        $message = 'All AEO Manager validations undone successfully - '.$documents->count().' documents reset to pending status';

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'documents_count' => $documents->count(),
            ]);
        }

        return redirect()->route('aeo.questions.index')->with('success', $message);
    }

    public function processApproval(Request $request, AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Check if user can access this question (question must be from their department)
        if ($question->dept !== $userDept) {
            abort(403, 'You can only access questions from your department.');
        }

        $request->validate([
            'approval_type' => 'required|in:1,2',
            'notes' => 'nullable|string|max:1000',
        ]);

        $approvalType = $request->approval_type;
        $notes = $request->notes;

        // Check if this approval has already been processed
        $approvalField = 'approval_'.$approvalType;
        if ($question->$approvalField !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Approval '.$approvalType.' has already been processed for this question.',
            ], 422);
        }

        // For approval 2, check if approval 1 is completed
        if ($approvalType == 2 && $question->approval_1 !== true) {
            return response()->json([
                'success' => false,
                'message' => 'Approval 1 must be completed before processing Approval 2.',
            ], 422);
        }

        // Update the question with approval data
        $question->update([
            'approval_'.$approvalType => true,
            'approval_'.$approvalType.'_at' => now(),
            'approval_'.$approvalType.'_by' => auth()->id(),
            'approval_'.$approvalType.'_notes' => $notes,
        ]);

        $message = 'Approval '.$approvalType.' processed successfully for question: '.$question->question;

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'approval_type' => $approvalType,
                'approved_at' => $question->{'approval_'.$approvalType.'_at'},
                'approved_by' => auth()->user()->name ?? 'Unknown User',
            ]);
        }

        return redirect()->route('aeo.questions.index')->with('success', $message);
    }
}
