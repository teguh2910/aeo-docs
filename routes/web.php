<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AeoDocumentController;
use App\Http\Controllers\AeoQuestionController;


Route::get('/', fn() => redirect()->route('aeo.questions.index'));


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
Route::resource('aeo/questions', AeoQuestionController::class)->except(['show'])->names('aeo.questions');

// Excel import routes for questions
Route::get('aeo/questions/import', [AeoQuestionController::class, 'importForm'])->name('aeo.questions.import.form');
Route::post('aeo/questions/import', [AeoQuestionController::class, 'importExcel'])->name('aeo.questions.import');
Route::get('aeo/questions/download-template', [AeoQuestionController::class, 'downloadTemplate'])->name('aeo.questions.download.template');

Route::resource('aeo/documents', AeoDocumentController::class)->names('aeo.documents');

// Excel import routes
Route::get('aeos/documents/import', [AeoDocumentController::class, 'importForm'])->name('aeo.documents.import.form');
Route::post('aeos/documents/import', [AeoDocumentController::class, 'importExcel'])->name('aeo.documents.import');
Route::get('aeos/documents/download-template', [AeoDocumentController::class, 'downloadTemplate'])->name('aeo.documents.download.template');

// Redirect documents index to questions index since documents are managed through questions
Route::get('aeos/documents', fn() => redirect()->route('aeo.questions.index'));
});
