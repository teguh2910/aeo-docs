<?php

namespace App\Http\Controllers;

use App\Imports\AeoQuestionImport;
use App\Models\AeoQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AeoQuestionController extends Controller
{
    public function index(Request $request)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';
        $isAeoOrAdmin = in_array($userDept, ['AEO', 'admin']);
        $isInternalAudit = $userDept === 'internal_audit';
        $isManagement = in_array($userDept, ['management1', 'management2']);

        // Get filter parameter
        $filterDept = $request->get('dept');

        // Get all unique departments for filter dropdown (only for AEO/admin/internal_audit/management)
        $departments = [];
        if ($isAeoOrAdmin || $isInternalAudit || $isManagement) {
            $departments = AeoQuestion::select('dept')
                ->distinct()
                ->whereNotNull('dept')
                ->orderBy('dept')
                ->pluck('dept')
                ->toArray();
        }

        // Build query
        $query = AeoQuestion::query();

        // Apply department filter based on user role
        if (! $isAeoOrAdmin && ! $isInternalAudit && ! $isManagement) {
            // Regular users can only see their department
            $query->where('dept', $userDept);
        } elseif ($filterDept && $filterDept !== 'all') {
            // AEO/admin/internal_audit/management can filter by specific department
            $query->where('dept', $filterDept);
        }
        // If no filter or 'all' is selected, AEO/admin/internal_audit/management see everything

        $rows = $query->with([
            'documents' => function ($query) use ($userDept, $isAeoOrAdmin, $isInternalAudit, $isManagement, $filterDept) {
                // For regular users, show only their dept documents
                if (! $isAeoOrAdmin && ! $isInternalAudit && ! $isManagement) {
                    $query->where('dept', $userDept);
                } elseif ($filterDept && $filterDept !== 'all') {
                    // For AEO/admin/internal_audit/management with filter, show filtered dept documents
                    $query->where('dept', $filterDept);
                }
                // Otherwise show all documents
            },
            'documents.creator',
            'documents.validator',
            'approval1By',
            'approval2By',
            'internalAuditApprovalBy',
        ])
            ->orderBy('subcriteria')
            ->orderBy('id')
            ->get()
            ->groupBy('subcriteria');

        return view('aeo.questions.index', compact('rows', 'departments', 'filterDept'));
    }

    public function showDocuments(AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Check if user can access this question
        // AEO, admin, internal_audit, and management can access any question, others only their department's questions
        if (! in_array($userDept, ['AEO', 'admin', 'internal_audit', 'management1', 'management2']) && $question->dept !== $userDept) {
            abort(403, 'You can only access questions from your department.');
        }

        // Load documents
        $question->load([
            'documents' => function ($query) use ($userDept) {
                // For AEO, admin, internal_audit, and management, show all documents; for others, show only their dept documents
                if (! in_array($userDept, ['AEO', 'admin', 'internal_audit', 'management1', 'management2'])) {
                    $query->where('dept', $userDept);
                }
            },
            'documents.creator',
            'documents.validator',
            'documents.aeoManagerValidator',
        ]);

        return view('aeo.questions.documents', compact('question'));
    }

    public function create()
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Internal audit cannot create questions
        if ($userDept === 'internal_audit') {
            abort(403, 'Internal Audit users cannot create questions.');
        }

        return view('aeo.questions.create');
    }

    public function store(Request $r)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Internal audit cannot create questions
        if ($userDept === 'internal_audit') {
            abort(403, 'Internal Audit users cannot create questions.');
        }

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

        // Internal audit cannot edit questions
        if ($userDept === 'internal_audit') {
            abort(403, 'Internal Audit users cannot edit questions.');
        }

        // AEO and admin can edit any question, others can only edit their department's questions
        if (! in_array($userDept, ['AEO', 'admin']) && $question->dept !== $userDept) {
            abort(403, 'You can only edit questions from your department.');
        }

        return view('aeo.questions.edit', compact('question'));
    }

    public function update(Request $r, AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Internal audit cannot update questions
        if ($userDept === 'internal_audit') {
            abort(403, 'Internal Audit users cannot update questions.');
        }

        // AEO and admin can update any question, others can only update their department's questions
        if (! in_array($userDept, ['AEO', 'admin']) && $question->dept !== $userDept) {
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

        // Internal audit cannot delete questions
        if ($userDept === 'internal_audit') {
            abort(403, 'Internal Audit users cannot delete questions.');
        }

        // AEO and admin can delete any question, others can only delete their department's questions
        if (! in_array($userDept, ['AEO', 'admin']) && $question->dept !== $userDept) {
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
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Internal audit cannot import questions
        if ($userDept === 'internal_audit') {
            abort(403, 'Internal Audit users cannot import questions.');
        }

        return view('aeo.questions.import');
    }

    public function importExcel(Request $request)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Internal audit cannot import questions
        if ($userDept === 'internal_audit') {
            abort(403, 'Internal Audit users cannot import questions.');
        }

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

        // Only AEO and admin can perform AEO Manager validation
        if (! in_array($userDept, ['AEO', 'admin'])) {
            abort(403, 'Only AEO Manager or Admin can validate questions.');
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

        // Only AEO and admin can undo validations
        if (! in_array($userDept, ['AEO', 'admin'])) {
            abort(403, 'Only AEO Manager or Admin can undo validations.');
        }

        // Get all documents for this question (AEO can access all departments)
        $documents = $question->documents()->get();

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

        $request->validate([
            'approval_type' => 'required|in:1,2',
            'notes' => 'nullable|string|max:1000',
        ]);

        $approvalType = $request->approval_type;
        $notes = $request->notes;

        // Check permission based on approval type
        if ($approvalType == 1) {
            // Only management1 and admin can process Approval 1
            if (! in_array($userDept, ['management1', 'admin'])) {
                abort(403, 'Only Management 1 or Admin can process Approval 1.');
            }
        } elseif ($approvalType == 2) {
            // Only management2 and admin can process Approval 2
            if (! in_array($userDept, ['management2', 'admin'])) {
                abort(403, 'Only Management 2 or Admin can process Approval 2.');
            }
        }

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

    public function processInternalAuditApproval(Request $request, AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Only internal_audit dept can process internal audit approvals
        if ($userDept !== 'internal_audit') {
            abort(403, 'Only Internal Audit department can process internal audit approvals.');
        }

        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string|max:1000',
        ]);

        $action = $request->action;
        $notes = $request->notes;

        // Check if this approval has already been processed
        if ($question->internal_audit_approval !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Audit Approval has already been processed for this question.',
            ], 422);
        }

        // Update the question with internal audit approval data
        $question->update([
            'internal_audit_approval' => $action === 'approve' ? true : false,
            'internal_audit_approval_at' => now(),
            'internal_audit_approval_by' => auth()->id(),
            'internal_audit_approval_notes' => $notes,
        ]);

        $message = 'Internal Audit Approval '.($action === 'approve' ? 'approved' : 'rejected').' successfully for question: '.$question->question;

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'action' => $action,
                'approved_at' => $question->internal_audit_approval_at,
                'approved_by' => auth()->user()->name ?? 'Unknown User',
            ]);
        }

        return redirect()->route('aeo.questions.index')->with('success', $message);
    }

    public function undoInternalAuditApproval(Request $request, AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        // Only internal_audit dept can undo internal audit approvals
        if ($userDept !== 'internal_audit') {
            abort(403, 'Only Internal Audit department can undo internal audit approvals.');
        }

        // Check if there is an approval to undo
        if ($question->internal_audit_approval === null) {
            return response()->json([
                'success' => false,
                'message' => 'No Internal Audit Approval to undo for this question.',
            ], 422);
        }

        // Reset the internal audit approval fields
        $question->update([
            'internal_audit_approval' => null,
            'internal_audit_approval_at' => null,
            'internal_audit_approval_by' => null,
            'internal_audit_approval_notes' => null,
        ]);

        $message = 'Internal Audit Approval undone successfully for question: '.$question->question;

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->route('aeo.questions.index')->with('success', $message);
    }

    public function undoApproval(Request $request, AeoQuestion $question)
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';

        $request->validate([
            'approval_type' => 'required|in:1,2',
        ]);

        $approvalType = $request->approval_type;

        // Check permission based on approval type
        if ($approvalType == 1) {
            // Only management1 and admin can undo Approval 1
            if (! in_array($userDept, ['management1', 'admin'])) {
                abort(403, 'Only Management 1 or Admin can undo Approval 1.');
            }
        } elseif ($approvalType == 2) {
            // Only management2 and admin can undo Approval 2
            if (! in_array($userDept, ['management2', 'admin'])) {
                abort(403, 'Only Management 2 or Admin can undo Approval 2.');
            }
        }

        // Check if there is an approval to undo
        $approvalField = 'approval_'.$approvalType;
        if ($question->$approvalField === null) {
            return response()->json([
                'success' => false,
                'message' => 'No Approval '.$approvalType.' to undo for this question.',
            ], 422);
        }

        // Reset the approval fields
        $question->update([
            'approval_'.$approvalType => null,
            'approval_'.$approvalType.'_at' => null,
            'approval_'.$approvalType.'_by' => null,
            'approval_'.$approvalType.'_notes' => null,
        ]);

        $message = 'Approval '.$approvalType.' undone successfully for question: '.$question->question;

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->route('aeo.questions.index')->with('success', $message);
    }
}
