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
                                <label for="document_type" class="form-label">Document Type <span
                                        class="text-danger">*</span></label>
                                <select name="document_type" id="document_type"
                                    class="form-select @error('document_type') is-invalid @enderror" required>
                                    <option value="">-- Select Document Type --</option>
                                    <option value="master"
                                        {{ old('document_type', $document->document_type) == 'master' ? 'selected' : '' }}>
                                        Master Document
                                    </option>
                                    <option value="new"
                                        {{ old('document_type', $document->document_type) == 'new' ? 'selected' : '' }}>
                                        New Document
                                    </option>
                                </select>
                                @error('document_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dept" class="form-label">Department <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('dept') is-invalid @enderror"
                                    id="dept" name="dept"
                                    value="{{ old('dept', $document->dept ?? (auth()->user()->dept ?? 'GENERAL')) }}"
                                    required>
                                <div class="form-text">Department information for this document.</div>
                                @error('dept')
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
                                <label class="form-label">File Management</label>

                                @if ($document->files && count($document->files) > 0)
                                    <div class="mb-3">
                                        <h6>Existing Files:</h6>
                                        <div class="list-group list-group-flush">
                                            @foreach ($document->files as $index => $f)
                                                <div
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="keep_files[]"
                                                            value="{{ $index }}" id="keep_file_{{ $index }}"
                                                            checked>
                                                        <label class="form-check-label"
                                                            for="keep_file_{{ $index }}">
                                                            <i class="fas fa-file"></i> {{ basename($f) }}
                                                        </label>
                                                    </div>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ Storage::url($f) }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i>
                                            Uncheck files you want to remove. Checked files will be kept.
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="files" class="form-label">
                                        {{ $document->files && count($document->files) > 0 ? 'Add New Files' : 'Upload Files' }}
                                    </label>
                                    <input type="file" class="form-control @error('files.*') is-invalid @enderror"
                                        id="files" name="files[]" multiple>
                                    <div class="form-text">You can select multiple files. Maximum size: 10MB per file.</div>
                                    @error('files.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if ($document->files && count($document->files) > 0)
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="replace_all_files"
                                                name="replace_all_files" value="1">
                                            <label class="form-check-label text-warning" for="replace_all_files">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                <strong>Replace all existing files</strong> with new uploads
                                            </label>
                                        </div>
                                        <div class="form-text text-muted">
                                            If checked, all existing files will be deleted and replaced with newly uploaded
                                            files.
                                            This option overrides individual file selections above.
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                    <option value="draft"
                                        {{ old('status', $document->status) == 'draft' ? 'selected' : '' }}>
                                        Draft
                                    </option>
                                    <option value="in_review"
                                        {{ old('status', $document->status) == 'in_review' ? 'selected' : '' }}>
                                        In Review
                                    </option>
                                    <option value="approved"
                                        {{ old('status', $document->status) == 'approved' ? 'selected' : '' }}>
                                        Approved
                                    </option>
                                    <option value="rejected"
                                        {{ old('status', $document->status) == 'rejected' ? 'selected' : '' }}>
                                        Rejected
                                    </option>
                                    <option value="pending"
                                        {{ old('status', $document->status) == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const replaceAllCheckbox = document.getElementById('replace_all_files');
            const keepFileCheckboxes = document.querySelectorAll('input[name="keep_files[]"]');
            const filesInput = document.getElementById('files');

            if (replaceAllCheckbox) {
                replaceAllCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Disable individual file checkboxes when replace all is checked
                        keepFileCheckboxes.forEach(checkbox => {
                            checkbox.disabled = true;
                            checkbox.parentElement.style.opacity = '0.5';
                        });

                        // Make file upload required when replacing all
                        if (filesInput) {
                            filesInput.required = true;
                            filesInput.parentElement.querySelector('.form-text').innerHTML =
                                '<strong class="text-warning">You must upload new files when replacing all existing files.</strong>';
                        }
                    } else {
                        // Re-enable individual file checkboxes
                        keepFileCheckboxes.forEach(checkbox => {
                            checkbox.disabled = false;
                            checkbox.parentElement.style.opacity = '1';
                        });

                        // Remove required from file upload
                        if (filesInput) {
                            filesInput.required = false;
                            filesInput.parentElement.querySelector('.form-text').innerHTML =
                                'You can select multiple files. Maximum size: 10MB per file.';
                        }
                    }
                });
            }

            // Add confirmation for replace all files
            const form = document.querySelector('form');
            if (form && replaceAllCheckbox) {
                form.addEventListener('submit', function(e) {
                    if (replaceAllCheckbox.checked) {
                        const hasNewFiles = filesInput && filesInput.files.length > 0;
                        if (!hasNewFiles) {
                            e.preventDefault();
                            alert('You must upload new files when choosing to replace all existing files.');
                            return false;
                        }

                        if (!confirm(
                                'Are you sure you want to replace ALL existing files? This action cannot be undone.'
                            )) {
                            e.preventDefault();
                            return false;
                        }
                    }
                });
            }
        });
    </script>
@endpush
