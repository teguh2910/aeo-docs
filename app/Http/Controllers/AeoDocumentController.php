<?php

namespace App\Http\Controllers;

use App\Imports\AeoDocumentImport;
use App\Models\AeoDocument;
use App\Models\AeoQuestion;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AeoDocumentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $query = AeoDocument::with('question');

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dokumen', 'like', "%{$search}%")
                    ->orWhere('no_sop_wi_std_form_other', 'like', "%{$search}%");
            });
        }

        $documents = $query->orderBy('created_at', 'desc')->get();

        return view('aeo.documents.index', compact('documents'));
    }

    public function create()
    {
        $questions = AeoQuestion::orderBy('subcriteria')->get();

        return view('aeo.documents.create', compact('questions'));
    }

    public function store(Request $r)
    {
        $user = Auth::user();

        // Ensure user has a department, fallback to 'GENERAL'
        $userDept = $user->dept ?? 'GENERAL';

        $data = $r->validate([
            'aeo_question_id' => 'required|exists:aeo_questions,id',
            'document_type' => 'required|in:master,new',
            'dept' => 'required|string|max:255',
            'nama_dokumen' => 'required|string|max:255',
            'no_sop_wi_std_form_other' => 'nullable|string|max:255',
            'files.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif', // 10MB per file, specific file types
            'validation_files.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif',
            'validation_notes' => 'nullable|string',
            'is_valid' => 'nullable|boolean',
            'mark_as_valid' => 'nullable|boolean',
            'replace_invalid_doc' => 'nullable|exists:aeo_documents,id',
        ], [
            'aeo_question_id.required' => 'Question selection is required.',
            'aeo_question_id.exists' => 'Selected question is invalid.',
            'document_type.required' => 'Document type is required.',
            'document_type.in' => 'Document type must be either master or new.',
            'dept.required' => 'Department is required.',
            'nama_dokumen.required' => 'Document name is required.',
        ]);

        $paths = [];
        if ($r->hasFile('files')) {
            foreach ($r->file('files') as $file) {
                // Generate unique filename to prevent conflicts
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = time().'_'.uniqid().'_'.preg_replace('/[^A-Za-z0-9\-_.]/', '', $originalName);
                $path = $file->storeAs('aeo', $filename, 'public');
                $paths[] = $path;
            }
        }

        $validationPaths = [];
        if ($r->hasFile('validation_files')) {
            foreach ($r->file('validation_files') as $file) {
                // Generate unique filename to prevent conflicts
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = time().'_'.uniqid().'_validation_'.preg_replace('/[^A-Za-z0-9\-_.]/', '', $originalName);
                $path = $file->storeAs('aeo/validation', $filename, 'public');
                $validationPaths[] = $path;
            }
        }

        // Determine validation status
        // New documents are ALWAYS created as invalid, master documents are AUTOMATICALLY approved and valid
        $isValid = false; // Initialize default value
        $status = null; // Initialize status

        if ($data['document_type'] === 'new') {
            // Force new documents to be invalid
            $validationData = [
                'is_valid' => false,
                'validation_notes' => $r->validation_notes,
            ];
            $status = 'draft'; // New documents start as draft
        } else {
            // Master documents are AUTOMATICALLY validated but AEO Manager approval remains MANUAL
            $isValid = true; // Always true for master documents
            $status = 'in_review'; // Needs AEO Manager approval

            $validationData = [
                'is_valid' => true,
                'validated_at' => now(),
                'validated_by' => $user->id,
                // AEO Manager fields remain null for manual approval
                'aeo_manager_valid' => null,
                'aeo_manager_validated_at' => null,
                'aeo_manager_validated_by' => null,
                'aeo_manager_notes' => null,
            ];

            // Add validation_files for master documents when provided
            if (! empty($validationPaths)) {
                $validationData['validation_files'] = $validationPaths;
            }
        }

        // Create new document
        $newDocument = AeoDocument::create([
            'aeo_question_id' => $data['aeo_question_id'],
            'document_type' => $data['document_type'],
            'dept' => $data['dept'] ?? $userDept,
            'nama_dokumen' => $data['nama_dokumen'],
            'no_sop_wi_std_form_other' => $data['no_sop_wi_std_form_other'] ?? null,
            'files' => $paths,
            'status' => $status,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ] + $validationData);

        // If this is replacing an invalid document, optionally mark the old one for reference
        if ($r->has('replace_invalid_doc') && $r->replace_invalid_doc) {
            $oldDocument = AeoDocument::find($r->replace_invalid_doc);
            if ($oldDocument) {
                // Add a note to the old document that it was replaced
                $oldDocument->update([
                    'validation_notes' => ($oldDocument->validation_notes ? $oldDocument->validation_notes.' | ' : '')
                        .'Replaced by new document on '.now()->format('d M Y H:i'),
                ]);
            }
        }

        $message = $data['document_type'] === 'master'
            ? 'Master document created and automatically validated - awaiting AEO Manager approval'
            : 'New document created successfully';

        return redirect()->route('aeo.questions.index')->with('success', $message);
    }

    public function show(AeoDocument $document)
    {
        $this->authorize('view', $document);

        return view('aeo.documents.show', compact('document'));
    }

    public function edit(AeoDocument $document)
    {
        $this->authorize('update', $document);
        $questions = AeoQuestion::orderBy('subcriteria')->get();

        return view('aeo.documents.edit', compact('document', 'questions'));
    }

    public function update(Request $r, AeoDocument $document)
    {
        $this->authorize('update', $document);

        // Update with all fields (from edit page)
        $data = $r->validate([
            'aeo_question_id' => 'required|exists:aeo_questions,id',
            'document_type' => 'required|in:master,new',
            'dept' => 'required|string|max:255',
            'nama_dokumen' => 'required|string',
            'no_sop_wi_std_form_other' => 'nullable|string|max:255',
            'status' => 'nullable|in:draft,in_review,approved,rejected,pending',
            'files.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif',
            'keep_files' => 'nullable|array',
            'keep_files.*' => 'integer',
            'replace_all_files' => 'nullable|boolean',
        ]);

        // Handle file management
        $currentFiles = $document->files ?? [];
        $newPaths = [];

        // Check if user wants to replace all files
        if ($r->has('replace_all_files') && $r->replace_all_files) {
            // Delete all existing files from storage
            foreach ($currentFiles as $filePath) {
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
            $newPaths = []; // Start with empty array
        } else {
            // Keep selected existing files
            $keepFiles = $r->input('keep_files', []);
            foreach ($keepFiles as $index) {
                if (isset($currentFiles[$index])) {
                    $newPaths[] = $currentFiles[$index];
                } else {
                    // If file index doesn't exist, keep it anyway for safety
                    if (isset($currentFiles[$index])) {
                        $newPaths[] = $currentFiles[$index];
                    }
                }
            }

            // Delete files that weren't selected to keep
            foreach ($currentFiles as $index => $filePath) {
                if (! in_array($index, $keepFiles)) {
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }
        }

        // Add new uploaded files
        if ($r->hasFile('files')) {
            foreach ($r->file('files') as $file) {
                // Generate unique filename to prevent conflicts
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = time().'_'.uniqid().'_'.preg_replace('/[^A-Za-z0-9\-_.]/', '', $originalName);
                $path = $file->storeAs('aeo', $filename, 'public');
                $newPaths[] = $path;
            }
        }

        $document->update([
            'aeo_question_id' => $data['aeo_question_id'],
            'document_type' => $data['document_type'],
            'dept' => $data['dept'],
            'nama_dokumen' => $data['nama_dokumen'],
            'no_sop_wi_std_form_other' => $data['no_sop_wi_std_form_other'] ?? null,
            'status' => $data['status'] ?? null,
            'files' => $newPaths,
            'updated_by' => auth()->id(),
        ]);

        $message = 'Document updated successfully';
        if ($r->has('replace_all_files') && $r->replace_all_files) {
            $message .= ' (all files replaced)';
        } elseif ($r->hasFile('files')) {
            $message .= ' (new files added)';
        }

        return redirect()->route('aeo.questions.index')->with('success', $message);
    }

    public function destroy(AeoDocument $document)
    {
        $this->authorize('delete', $document);

        // Delete all stored files from storage
        foreach (($document->files ?? []) as $p) {
            if (Storage::disk('public')->exists($p)) {
                Storage::disk('public')->delete($p);
            }
        }

        $document->delete();

        return redirect()->route('aeo.questions.index')->with('success', 'Document deleted successfully');
    }

    public function toggleValidation(Request $request, AeoDocument $document)
    {
        $this->authorize('update', $document);

        $validated = $request->validate([
            'is_valid' => 'nullable|boolean',
            'nama_dokumen' => 'nullable|string|max:255',
            'no_sop_wi_std_form_other' => 'nullable|string|max:255',
            'validation_notes' => 'nullable|string|max:500',
            'validation_files.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif',
        ]);

        // Checkbox sends value only when checked, so default to false if not present
        $isValid = $request->has('is_valid') && $validated['is_valid'] == 1;

        // Handle validation file uploads
        $validationFilePaths = $document->validation_files ?? [];
        if ($request->hasFile('validation_files')) {
            foreach ($request->file('validation_files') as $file) {
                // Generate unique filename to prevent conflicts
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = time().'_'.uniqid().'_validation_'.preg_replace('/[^A-Za-z0-9\-_.]/', '', $originalName);
                $path = $file->storeAs('aeo/validation', $filename, 'public');
                $validationFilePaths[] = $path;
            }
        }

        // Prepare update data
        $updateData = [
            'is_valid' => $isValid,
            'validation_notes' => $validated['validation_notes'] ?? null,
            'validation_files' => $validationFilePaths,
            'validated_at' => now(),
            'validated_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ];

        // Update document name and number if provided (always update these fields when submitted)
        if ($request->filled('nama_dokumen')) {
            $updateData['nama_dokumen'] = $validated['nama_dokumen'];
        }
        if ($request->has('no_sop_wi_std_form_other')) {
            $updateData['no_sop_wi_std_form_other'] = $validated['no_sop_wi_std_form_other'];
        }

        $document->update($updateData);

        $status = $isValid ? 'valid' : 'invalid';

        $message = "Document marked as {$status} successfully";

        // Add feedback if document details were updated
        if ($request->filled('nama_dokumen') || $request->has('no_sop_wi_std_form_other')) {
            $message .= ' and document details updated';
        }

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_valid' => $isValid,
                'status' => $status,
            ]);
        }

        return redirect()->route('aeo.questions.index')->with('success', $message);
    }

    public function importForm()
    {
        return view('aeo.documents.import');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        try {
            Excel::import(new AeoDocumentImport, $request->file('excel_file'));

            return redirect()->route('aeo.questions.index')->with('success', 'Documents imported successfully from Excel file');
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

    public function aeoManagerToggle(Request $request, AeoDocument $document)
    {
        $this->authorize('update', $document);

        $validated = $request->validate([
            'aeo_manager_valid' => 'nullable|boolean',
            'aeo_manager_notes' => 'nullable|string|max:500',
        ]);

        // Checkbox sends value only when checked, so default to false if not present
        $isValid = $request->has('aeo_manager_valid') && $validated['aeo_manager_valid'] == 1;

        // Prepare update data
        $updateData = [
            'aeo_manager_valid' => $isValid,
            'aeo_manager_notes' => $validated['aeo_manager_notes'] ?? null,
            'aeo_manager_validated_at' => now(),
            'aeo_manager_validated_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ];

        // Update status based on AEO Manager validation
        if ($isValid) {
            $updateData['status'] = 'approved';
        } else {
            $updateData['status'] = 'rejected';
        }

        $document->update($updateData);

        $status = $isValid ? 'valid' : 'invalid';
        $message = "Document marked as {$status} by AEO Manager successfully";

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'aeo_manager_valid' => $isValid,
                'status' => $status,
            ]);
        }

        return redirect()->route('aeo.questions.index')->with('success', $message);
    }

    public function aeoManagerUndo(Request $request, AeoDocument $document)
    {
        $this->authorize('update', $document);

        // Reset AEO Manager validation to null (undo approval/rejection)
        $updateData = [
            'aeo_manager_valid' => null,
            'aeo_manager_notes' => null,
            'aeo_manager_validated_at' => null,
            'aeo_manager_validated_by' => null,
            'updated_by' => auth()->id(),
        ];

        // Update status back to in_review for master documents, or draft for new documents
        if ($document->document_type === 'master') {
            $updateData['status'] = 'in_review'; // Back to awaiting AEO Manager approval
        } else {
            $updateData['status'] = 'draft'; // Back to draft for new documents
        }

        $document->update($updateData);

        $message = 'AEO Manager validation undone successfully - document back to pending status';

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'aeo_manager_valid' => null,
                'status' => $updateData['status'],
            ]);
        }

        return redirect()->route('aeo.questions.index')->with('success', $message);
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="aeo_documents_template.csv"',
        ];

        return response()->download(public_path('templates/aeo_documents_template.csv'), 'aeo_documents_template.csv', $headers);
    }
}
