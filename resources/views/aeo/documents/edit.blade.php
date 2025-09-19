@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-edit"></i> Edit Dokumen AEO
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('aeo.documents.update', $document) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="aeo_question_id" class="form-label">Question <span
                                        class="text-danger">*</span></label>
                                <select name="aeo_question_id" id="aeo_question_id"
                                    class="form-select @error('aeo_question_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Question --</option>
                                    @foreach ($questions as $qs)
                                        <option value="{{ $qs->id }}"
                                            {{ old('aeo_question_id', $document->aeo_question_id) == $qs->id ? 'selected' : '' }}>
                                            [{{ $qs->subcriteria }}] {{ Str::limit($qs->question, 80) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('aeo_question_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_dokumen" class="form-label">Nama Dokumen <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror"
                                    id="nama_dokumen" name="nama_dokumen"
                                    value="{{ old('nama_dokumen', $document->nama_dokumen) }}" required>
                                @error('nama_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="no_sop_wi_std_form_other" class="form-label">No SOP/WI/STD/Form/Other</label>
                                <input type="text"
                                    class="form-control @error('no_sop_wi_std_form_other') is-invalid @enderror"
                                    id="no_sop_wi_std_form_other" name="no_sop_wi_std_form_other"
                                    value="{{ old('no_sop_wi_std_form_other', $document->no_sop_wi_std_form_other) }}">
                                @error('no_sop_wi_std_form_other')
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

                                @if ($document->files && count($document->files) > 0)
                                    <div class="mt-3">
                                        <h6>Existing Files:</h6>
                                        <div class="list-group list-group-flush">
                                            @foreach ($document->files as $f)
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
