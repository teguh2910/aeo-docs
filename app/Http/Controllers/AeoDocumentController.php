<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\AeoDocument;
use App\Models\AeoQuestion;
use App\Imports\AeoDocumentImport;
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
        $data = $r->validate([
            'aeo_question_id' => 'required|exists:aeo_questions,id',
            'nama_dokumen' => 'required|string|max:255',
            'no_sop_wi_std_form_other' => 'nullable|string|max:255',
            'files.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif', // 10MB per file, specific file types
        ]);

        $paths = [];
        if ($r->hasFile('files')) {
            foreach ($r->file('files') as $file) {
                // Generate unique filename to prevent conflicts
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '_' . preg_replace('/[^A-Za-z0-9\-_.]/', '', $originalName);
                $path = $file->storeAs('aeo', $filename, 'public');
                $paths[] = $path;
            }
        }

        AeoDocument::create([
            'aeo_question_id' => $data['aeo_question_id'],
            'dept' => $user->dept,
            'nama_dokumen' => $data['nama_dokumen'],
            'no_sop_wi_std_form_other' => $data['no_sop_wi_std_form_other'] ?? null,
            'files' => $paths,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        return redirect()->route('aeo.questions.index')->with('success', 'Document saved successfully');
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
        return view('aeo.documents.edit', compact('document','questions'));
    }

    public function update(Request $r, AeoDocument $document)
    {
        $this->authorize('update', $document);
        $data = $r->validate([
            'aeo_question_id' => 'required|exists:aeo_questions,id',
            'nama_dokumen' => 'required|string|max:255',
            'no_sop_wi_std_form_other' => 'nullable|string|max:255',
            'files.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif',
        ]);

        $paths = $document->files ?? [];
        if ($r->hasFile('files')) {
            foreach ($r->file('files') as $file) {
                // Generate unique filename to prevent conflicts
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '_' . preg_replace('/[^A-Za-z0-9\-_.]/', '', $originalName);
                $path = $file->storeAs('aeo', $filename, 'public');
                $paths[] = $path;
            }
        }

        $document->update([
            'aeo_question_id' => $data['aeo_question_id'],
            'nama_dokumen' => $data['nama_dokumen'],
            'no_sop_wi_std_form_other' => $data['no_sop_wi_std_form_other'] ?? null,
            'files' => $paths,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('aeo.questions.index')->with('success', 'Document updated successfully');
    }

    public function destroy(AeoDocument $document)
    {
        $this->authorize('delete', $document);
        // (Optional) delete stored files
        foreach (($document->files ?? []) as $p) { if (Storage::exists($p)) Storage::delete($p); }
        $document->delete();
        return redirect()->route('aeo.questions.index')->with('success', 'Document deleted successfully');
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
                $errors[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
            }

            return redirect()->back()->withErrors($errors);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['excel_file' => 'Error importing Excel file: ' . $e->getMessage()]);
        }
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