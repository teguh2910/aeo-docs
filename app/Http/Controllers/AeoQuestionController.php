<?php
namespace App\Http\Controllers;


use App\Models\AeoQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Imports\AeoQuestionImport;
use Maatwebsite\Excel\Facades\Excel;


class AeoQuestionController extends Controller
{
public function index() { 
    $rows = AeoQuestion::with('documents')->latest()->paginate(20); 
    return view('aeo.questions.index', compact('rows')); 
}
public function create() { return view('aeo.questions.create'); }
public function store(Request $r) {
$data = $r->validate([
'subcriteria' => 'required|string|max:255',
'question' => 'required|string',
'keterangan' => 'nullable|string',
'files.*' => 'file|max:10240',
]);

$paths = [];
if ($r->hasFile('files')) {
    foreach ($r->file('files') as $file) {
        $paths[] = $file->store('aeo');
    }
}
$data['files'] = $paths;

AeoQuestion::create($data);
return redirect()->route('aeo.questions.index');
}
public function edit(AeoQuestion $question) { return view('aeo.questions.edit', compact('question')); }
public function update(Request $r, AeoQuestion $question) {
$data = $r->validate([
'subcriteria' => 'required|string|max:255',
'question' => 'required|string',
'keterangan' => 'nullable|string',
'files.*' => 'file|max:10240',
]);

$paths = $question->files ?? [];
if ($r->hasFile('files')) {
    foreach ($r->file('files') as $file) {
        $paths[] = $file->store('aeo');
    }
}
$data['files'] = $paths;

$question->update($data);
return redirect()->route('aeo.questions.index');
}
public function destroy(AeoQuestion $question) { 
    foreach (($question->files ?? []) as $p) { if (Storage::exists($p)) Storage::delete($p); }
    $question->delete(); 
    return back(); 
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
        'Content-Disposition' => 'attachment; filename="aeo_questions_template.csv"',
    ];

    return response()->download(public_path('templates/aeo_questions_template.csv'), 'aeo_questions_template.csv', $headers);
}
}