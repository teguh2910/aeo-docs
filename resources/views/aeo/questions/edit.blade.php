@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-edit"></i> Edit Pertanyaan AEO
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('aeo.questions.update', $question) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf @method('PUT')

                            <div class="mb-3">
                                <label for="subcriteria" class="form-label">Subcriteria <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('subcriteria') is-invalid @enderror"
                                    id="subcriteria" name="subcriteria"
                                    value="{{ old('subcriteria', $question->subcriteria) }}" required>
                                @error('subcriteria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('question') is-invalid @enderror" id="question" name="question" rows="4"
                                    required>{{ old('question', $question->question) }}</textarea>
                                @error('question')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                    rows="3">{{ old('keterangan', $question->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="files" class="form-label">Add New Files</label>
                                <input type="file" class="form-control @error('files.*') is-invalid @enderror"
                                    id="files" name="files[]" multiple>
                                <div class="form-text">You can select multiple files. Maximum size: 10MB per file.</div>
                                @error('files.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($question->files && count($question->files) > 0)
                                    <div class="mt-3">
                                        <h6>Existing Files:</h6>
                                        <div class="list-group list-group-flush">
                                            @foreach ($question->files as $f)
                                                <div
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span><i class="fas fa-file"></i> {{ basename($f) }}</span>
                                                    <a href="{{ Storage::url($f) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('aeo.questions.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
