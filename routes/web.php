<?php

use App\Http\Controllers\AeoDocumentController;
use App\Http\Controllers\AeoQuestionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('aeo/questions', AeoQuestionController::class)->except(['show'])->names('aeo.questions');

    // Question detail page for documents
    Route::get('aeo/questions/{question}/documents', [AeoQuestionController::class, 'showDocuments'])->name('aeo.questions.documents');

    // AEO Manager validation route
    Route::post('aeo/questions/{question}/aeo-manager-validation', [AeoQuestionController::class, 'updateAeoManagerValidation'])->name('aeo.questions.aeo-manager-validation');

    // AEO Manager undo all validations route
    Route::post('aeo/questions/{question}/aeo-manager-undo-all', [AeoQuestionController::class, 'undoAllAeoManagerValidations'])->name('aeo.questions.aeo-manager-undo-all');

    // Approval route
    Route::post('aeo/questions/{question}/approval', [AeoQuestionController::class, 'processApproval'])->name('aeo.questions.approval');

    // Internal Audit Approval route
    Route::post('aeo/questions/{question}/internal-audit-approval', [AeoQuestionController::class, 'processInternalAuditApproval'])->name('aeo.questions.internal-audit-approval');

    // Internal Audit Undo route
    Route::post('aeo/questions/{question}/internal-audit-undo', [AeoQuestionController::class, 'undoInternalAuditApproval'])->name('aeo.questions.internal-audit-undo');

    // Undo Approval route
    Route::post('aeo/questions/{question}/undo-approval', [AeoQuestionController::class, 'undoApproval'])->name('aeo.questions.undo-approval');

    // Excel import routes for questions
    Route::get('aeo/questions/import', [AeoQuestionController::class, 'importForm'])->name('aeo.questions.import.form');
    Route::post('aeo/questions/import', [AeoQuestionController::class, 'importExcel'])->name('aeo.questions.import');
    Route::get('aeo/questions/download-template', [AeoQuestionController::class, 'downloadTemplate'])->name('aeo.questions.download.template');

    Route::resource('aeo/documents', AeoDocumentController::class)->names('aeo.documents');
    Route::post('aeo/documents/{document}/toggle-validation', [AeoDocumentController::class, 'toggleValidation'])->name('aeo.documents.toggle-validation');
    Route::post('aeo/documents/{document}/aeo-manager-toggle', [AeoDocumentController::class, 'aeoManagerToggle'])->name('aeo.documents.aeo-manager-toggle');
    Route::post('aeo/documents/{document}/aeo-manager-undo', [AeoDocumentController::class, 'aeoManagerUndo'])->name('aeo.documents.aeo-manager-undo');

    // Excel import routes
    Route::get('aeos/documents/import', [AeoDocumentController::class, 'importForm'])->name('aeo.documents.import.form');
    Route::post('aeos/documents/import', [AeoDocumentController::class, 'importExcel'])->name('aeo.documents.import');
    Route::get('aeos/documents/download-template', [AeoDocumentController::class, 'downloadTemplate'])->name('aeo.documents.download.template');

    // Redirect documents index to questions index since documents are managed through questions
    Route::get('aeos/documents', fn () => redirect()->route('aeo.questions.index'));
});
