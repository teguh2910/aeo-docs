<?php

namespace App\Http\Controllers;

use App\Models\AeoDocument;
use App\Models\AeoQuestion;

class DashboardController extends Controller
{
    public function index()
    {
        $userDept = auth()->user()->dept ?? 'GENERAL';
        $isAeoOrAdmin = in_array($userDept, ['AEO', 'admin']);
        $isInternalAudit = $userDept === 'internal_audit';
        $isManagement = in_array($userDept, ['management1', 'management2']);

        // Build base query for questions
        $baseQuery = AeoQuestion::query();

        // Apply department filter based on user role
        if (! $isAeoOrAdmin && ! $isInternalAudit && ! $isManagement) {
            // Regular users can only see their department
            $baseQuery->where('dept', $userDept);
        }

        // Total questions
        $totalQuestions = (clone $baseQuery)->count();

        // Questions pending Approval 1
        $pendingApproval1 = (clone $baseQuery)->whereNull('approval_1')->count();

        // Questions with Approval 1 completed
        $completedApproval1 = (clone $baseQuery)->where('approval_1', true)->count();

        // Questions pending Approval 2
        $pendingApproval2 = (clone $baseQuery)->whereNull('approval_2')->count();

        // Questions with Approval 2 completed
        $completedApproval2 = (clone $baseQuery)->where('approval_2', true)->count();

        // Questions pending Internal Audit Approval
        $pendingInternalAudit = (clone $baseQuery)->whereNull('internal_audit_approval')->count();

        // Questions with Internal Audit Approval completed
        $completedInternalAudit = (clone $baseQuery)->where('internal_audit_approval', true)->count();

        // Questions with Internal Audit Rejected
        $rejectedInternalAudit = (clone $baseQuery)->where('internal_audit_approval', false)->count();

        // AEO Manager Validation - based on document validation status
        // Pending: questions without documents OR with documents that are not fully validated
        $pendingAeoManagerQuestions = (clone $baseQuery)
            ->where(function ($query) {
                // No documents yet
                $query->doesntHave('documents')
                    // OR has documents with NULL or false validation
                    ->orWhereHas('documents', function ($q) {
                        $q->whereNull('aeo_manager_valid')
                            ->orWhere('aeo_manager_valid', false);
                    });
            })
            ->count();

        // Completed: questions with documents where ALL are validated (true)
        $completedAeoManagerQuestions = (clone $baseQuery)
            ->has('documents')
            ->whereDoesntHave('documents', function ($query) {
                $query->whereNull('aeo_manager_valid')
                    ->orWhere('aeo_manager_valid', false);
            })
            ->count();

        // Document statistics
        $documentQuery = AeoDocument::query();

        // Apply department filter for documents
        if (! $isAeoOrAdmin && ! $isInternalAudit && ! $isManagement) {
            $documentQuery->where('dept', $userDept);
        }

        $totalDocuments = (clone $documentQuery)->count();

        // Documents pending validation
        $pendingValidation = (clone $documentQuery)->whereNull('is_valid')->count();

        // Documents validated
        $validatedDocuments = (clone $documentQuery)->where('is_valid', true)->count();

        // Documents pending AEO Manager validation
        $pendingAeoManagerValidation = (clone $documentQuery)->whereNull('aeo_manager_valid')->count();

        // Documents with AEO Manager validation completed
        $completedAeoManagerValidation = (clone $documentQuery)->where('aeo_manager_valid', true)->count();

        return view('dashboard.index', compact(
            'totalQuestions',
            'pendingApproval1',
            'completedApproval1',
            'pendingApproval2',
            'completedApproval2',
            'pendingInternalAudit',
            'completedInternalAudit',
            'rejectedInternalAudit',
            'pendingAeoManagerQuestions',
            'completedAeoManagerQuestions',
            'totalDocuments',
            'pendingValidation',
            'validatedDocuments',
            'pendingAeoManagerValidation',
            'completedAeoManagerValidation',
            'userDept',
            'isAeoOrAdmin',
            'isInternalAudit',
            'isManagement'
        ));
    }
}
