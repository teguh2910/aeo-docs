@extends('layouts.app')

@push('styles')
    <style>
        .subcriteria-group-secondary {
            background-color: #f8f9fa !important;
            border-left: 3px solid #0d6efd;
        }

        .subcriteria-indicator {
            color: #6c757d;
            font-size: 0.85em;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-file-shield"></i> AEO Questions & Documents Management
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex gap-2">
                                <a href="{{ route('aeo.questions.import.form') }}" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i> Import Excel
                                </a>
                                <a href="{{ route('aeo.questions.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Question
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="aeoQuestionsTable" class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kondisi dan Persyaratan</th>
                                        <th>Pertanyaan</th>
                                        {{-- <th>Keterangan</th> --}}
                                        <th>Jawaban</th>
                                        <th class="text-center">Evident Validasi AEO</th>
                                        <th class="text-center">Self Audit by Audity</th>
                                        <th class="text-center">New Documents</th>
                                        <th class="text-center">Final Validasi by AEO Mgr</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @forelse ($rows as $subcriteria => $questions)
                                        @foreach ($questions as $questionIndex => $row)
                                            <tr
                                                class="align-top {{ $questionIndex > 0 ? 'subcriteria-group-secondary' : '' }}">
                                                <td class="text-center">{{ $counter++ }}</td>
                                                <td>
                                                    @if ($questionIndex == 0)
                                                        <strong class="text-primary">{{ $subcriteria }}</strong>
                                                        @if ($questions->count() > 1)
                                                            <small class="badge bg-info ms-2">{{ $questions->count() }}
                                                                questions</small>
                                                        @endif
                                                    @else
                                                        <div class="ms-3">
                                                            <span class="subcriteria-indicator">
                                                                <i class="fas fa-level-down-alt fa-rotate-90"></i>
                                                                Question {{ $questionIndex + 1 }} of
                                                                {{ $questions->count() }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="mb-2">{{ $row->question }}</div>

                                                    @if ($row->files && count($row->files) > 0)
                                                        <div class="border-top pt-2">
                                                            <small class="text-muted d-block"><strong>Question
                                                                    Files:</strong></small>
                                                            @foreach ($row->files as $f)
                                                                <div class="mb-1">
                                                                    <a href="{{ Storage::url($f) }}" target="_blank"
                                                                        class="btn btn-sm btn-outline-secondary">
                                                                        <i class="fas fa-download"></i> {{ basename($f) }}
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                @if ($row->keterangan)
                                                    <div class="alert alert-info py-2">
                                                        {{ $row->keterangan }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">No recommendations yet</span>
                                                @endif
                                            </td> --}}
                                                <td>
                                                    @if ($row->jawaban)
                                                        <div class="py-2">
                                                            {{ $row->jawaban }}
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>

                                                <!-- COLUMN: MASTER DOCUMENT -->
                                                <td class="bg-light">
                                                    <!-- Add Document Button -->
                                                    <div class="mb-3">
                                                        <button class="btn btn-sm btn-success" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#addDoc{{ $row->id }}">
                                                            <i class="fas fa-plus"></i> Add Master Document
                                                        </button>
                                                    </div>

                                                    <!-- Add Document Form (Collapsed) -->
                                                    <div class="collapse" id="addDoc{{ $row->id }}">
                                                        <div class="card card-body mb-3 bg-light">
                                                            <form action="{{ route('aeo.documents.store') }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="aeo_question_id"
                                                                    value="{{ $row->id }}">
                                                                <input type="hidden" name="document_type" value="master">

                                                                <div class="mb-2">
                                                                    <input type="text" name="nama_dokumen"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Master Document Name" required>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <label class="form-label form-label-sm text-muted">
                                                                        <i class="fas fa-building"></i> Department
                                                                        (Auto-filled)
                                                                    </label>
                                                                    <input type="text" name="dept"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ auth()->user()->dept ?? 'GENERAL' }}"
                                                                        readonly
                                                                        style="background-color: #f8f9fa; cursor: not-allowed;">
                                                                </div>

                                                                <div class="mb-2">
                                                                    <input type="text" name="no_sop_wi_std_form_other"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="No SOP/WI/STD/Form/Other">
                                                                </div>

                                                                <div class="mb-2">
                                                                    <input type="file" name="files[]"
                                                                        class="form-control form-control-sm" multiple>
                                                                </div>

                                                                <div class="d-flex gap-1">
                                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-save"></i> Save
                                                                    </button>
                                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#addDoc{{ $row->id }}">
                                                                        Cancel
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <!-- Master Documents -->
                                                    @php
                                                        $masterDocs = $row->documents
                                                            ? $row->documents->where('document_type', 'master')
                                                            : collect();
                                                    @endphp
                                                    @if ($masterDocs->count() > 0)
                                                        @foreach ($masterDocs as $doc)
                                                            <div class="border rounded p-2 mb-2 bg-white">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-start">
                                                                    <div class="flex-grow-1">
                                                                        <!-- Document Name -->
                                                                        <strong class="d-block text-primary">
                                                                            {{ $doc->nama_dokumen }}
                                                                        </strong>

                                                                        @if ($doc->no_sop_wi_std_form_other)
                                                                            <small class="text-muted d-block">
                                                                                No: {{ $doc->no_sop_wi_std_form_other }}
                                                                            </small>
                                                                        @endif

                                                                        @if ($doc->dept)
                                                                            <small class="text-muted d-block">
                                                                                <i class="fas fa-building"></i> Dept:
                                                                                {{ $doc->dept }}
                                                                            </small>
                                                                        @endif

                                                                        <small class="text-muted d-block">
                                                                            <i class="fas fa-clock"></i> Updated:
                                                                            {{ $doc->updated_at->format('d/m/Y H:i') }}
                                                                        </small>

                                                                        @if ($doc->files && count($doc->files) > 0)
                                                                            <div class="mt-2">
                                                                                @foreach ($doc->files as $f)
                                                                                    <a href="{{ Storage::url($f) }}"
                                                                                        target="_blank"
                                                                                        class="btn btn-sm btn-outline-primary me-1 mb-1">
                                                                                        <i class="fas fa-download"></i>
                                                                                        File
                                                                                    </a>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    <!-- Document Actions -->
                                                                    <div class="ms-2">
                                                                        <div class="btn-group-vertical" role="group">
                                                                            <a href="{{ route('aeo.documents.edit', $doc) }}"
                                                                                class="btn btn-sm btn-warning"
                                                                                title="Edit Document">
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                            <form
                                                                                action="{{ route('aeo.documents.destroy', $doc) }}"
                                                                                method="POST" class="d-inline">
                                                                                @csrf @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-danger"
                                                                                    onclick="return confirm('Delete this master document?')"
                                                                                    title="Delete Document">
                                                                                    <i class="fas fa-trash"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="text-muted text-center py-3">
                                                            <i class="fas fa-inbox"></i><br>
                                                            <small>No master documents yet</small>
                                                        </div>
                                                    @endif
                                                </td>

                                                <!-- COLUMN: VALIDASI DOKUMEN -->
                                                <td class="bg-light">
                                                    <br>
                                                    <br>
                                                    @php
                                                        $masterDocs = $row->documents
                                                            ? $row->documents->where('document_type', 'master')
                                                            : collect();
                                                    @endphp
                                                    @if ($masterDocs->count() > 0)
                                                        @foreach ($masterDocs as $doc)
                                                            <div class="border rounded p-2 mb-2 bg-white">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-start">
                                                                    <div class="flex-grow-1">
                                                                        <!-- Document Name -->
                                                                        <strong class="d-block text-primary">
                                                                            {{ $doc->nama_dokumen }}
                                                                        </strong>

                                                                        @if ($doc->no_sop_wi_std_form_other)
                                                                            <small class="text-muted d-block">
                                                                                No: {{ $doc->no_sop_wi_std_form_other }}
                                                                            </small>
                                                                        @endif

                                                                        @if ($doc->dept)
                                                                            <small class="text-muted d-block">
                                                                                <i class="fas fa-building"></i> Dept:
                                                                                {{ $doc->dept }}
                                                                            </small>
                                                                        @endif

                                                                        <small class="text-muted d-block">
                                                                            <i class="fas fa-clock"></i> Updated:
                                                                            {{ $doc->updated_at->format('d/m/Y H:i') }}
                                                                        </small>

                                                                        <!-- Status Badge -->
                                                                        <div class="mt-2 mb-2">
                                                                            <span
                                                                                class="badge {{ $doc->is_valid ? 'bg-success' : 'bg-danger' }}">
                                                                                <i
                                                                                    class="fas {{ $doc->is_valid ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                                                {{ $doc->is_valid ? 'Valid' : 'Invalid' }}
                                                                            </span>
                                                                        </div>

                                                                        <!-- Validation Question -->
                                                                        <div class="mb-2">
                                                                        </div>

                                                                        @if (!$doc->is_valid && $doc->validation_notes)
                                                                            <div class="alert alert-warning py-1 mt-2">
                                                                                <small><strong>Reason:</strong>
                                                                                    {{ $doc->validation_notes }}</small>
                                                                            </div>
                                                                        @endif

                                                                        @if ($doc->validation_files && count($doc->validation_files) > 0)
                                                                            <div class="mt-2">
                                                                                <small class="text-muted d-block"><strong>Validation
                                                                                        Files:</strong></small>
                                                                                @foreach ($doc->validation_files as $vf)
                                                                                    <a href="{{ Storage::url($vf) }}"
                                                                                        target="_blank"
                                                                                        class="btn btn-xs btn-outline-danger me-1 mb-1">
                                                                                        <i class="fas fa-file"></i>
                                                                                        File
                                                                                    </a>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    <!-- Validation Actions -->
                                                                    <div class="ms-2">
                                                                        <div class="btn-group-vertical" role="group">
                                                                            <!-- Toggle Switch -->
                                                                            <div class="form-check form-switch mb-2">
                                                                                <input
                                                                                    class="form-check-input validation-toggle"
                                                                                    type="checkbox"
                                                                                    id="validationToggle{{ $doc->id }}"
                                                                                    {{ $doc->is_valid ? 'checked' : '' }}
                                                                                    data-doc-id="{{ $doc->id }}"
                                                                                    data-route="{{ route('aeo.documents.toggle-validation', $doc) }}">
                                                                                <label class="form-check-label fw-bold"
                                                                                    for="validationToggle{{ $doc->id }}">
                                                                                    <span
                                                                                        class="valid-text {{ $doc->is_valid ? 'text-success' : 'text-muted' }}">
                                                                                        <i class="fas fa-check"></i> Valid
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            <!-- Add New Document Button -->
                                                                            <button type="button"
                                                                                class="btn btn-outline-primary btn-sm mb-1"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#newDocForm{{ $doc->id }}"
                                                                                title="Add New Document">
                                                                                <i class="fas fa-plus"></i> New Doc
                                                                            </button>

                                                                            <!-- Edit Master Document Button -->
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary btn-sm"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#invalidForm{{ $doc->id }}"
                                                                                title="Edit Master Document">
                                                                                <i class="fas fa-edit"></i> Edit
                                                                            </button>
                                                                        </div>

                                                                        <!-- Edit Master Document Form -->
                                                                        <div class="collapse mt-2"
                                                                            id="invalidForm{{ $doc->id }}">
                                                                            <form
                                                                                action="{{ route('aeo.documents.toggle-validation', $doc) }}"
                                                                                method="POST" class="validation-form"
                                                                                enctype="multipart/form-data">
                                                                                @csrf
                                                                                <input type="hidden" name="is_valid"
                                                                                    value="0">

                                                                                <!-- Document Information Edit -->
                                                                                <div class="alert alert-info py-2 mb-2">
                                                                                    <small><i
                                                                                            class="fas fa-info-circle"></i>
                                                                                        <strong>Edit Master
                                                                                            Document:</strong>
                                                                                        You can modify the master document
                                                                                        details
                                                                                        below before marking as
                                                                                        invalid.</small>
                                                                                </div>

                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label form-label-sm"><strong>Document
                                                                                            Name:</strong></label>
                                                                                    <input type="text"
                                                                                        name="nama_dokumen"
                                                                                        class="form-control form-control-sm"
                                                                                        value="{{ $doc->nama_dokumen }}"
                                                                                        placeholder="Enter document name"
                                                                                        required>
                                                                                </div>

                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label form-label-sm"><strong>Document
                                                                                            No:</strong></label>
                                                                                    <input type="text"
                                                                                        name="no_sop_wi_std_form_other"
                                                                                        class="form-control form-control-sm"
                                                                                        value="{{ $doc->no_sop_wi_std_form_other }}"
                                                                                        placeholder="Enter document number (optional)">
                                                                                </div>

                                                                                <!-- File Upload -->
                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label form-label-sm"><strong>Upload
                                                                                            Additional
                                                                                            Files:</strong></label>
                                                                                    <input type="file"
                                                                                        name="validation_files[]"
                                                                                        class="form-control form-control-sm"
                                                                                        multiple
                                                                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif">
                                                                                    <small class="text-muted">Optional:
                                                                                        Upload
                                                                                        files related to validation
                                                                                        issues</small>
                                                                                </div>

                                                                                <!-- Validation Notes -->
                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label form-label-sm"><strong>Reason
                                                                                            for Invalid:</strong></label>
                                                                                    <textarea name="validation_notes" class="form-control form-control-sm" rows="3"
                                                                                        placeholder="Please provide reason for marking this document as invalid..."></textarea>
                                                                                </div>

                                                                                <div class="d-flex gap-1">
                                                                                    <button type="submit"
                                                                                        class="btn btn-sm btn-danger">
                                                                                        <i class="fas fa-save"></i> Update
                                                                                        &
                                                                                        Mark
                                                                                        Invalid
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-secondary"
                                                                                        data-bs-toggle="collapse"
                                                                                        data-bs-target="#invalidForm{{ $doc->id }}">
                                                                                        Cancel
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>

                                                                        <!-- Add New Document Form -->
                                                                        <div class="collapse mt-2"
                                                                            id="newDocForm{{ $doc->id }}">

                                                                            <form
                                                                                action="{{ route('aeo.documents.store') }}"
                                                                                method="POST"
                                                                                class="validation-form bg-success bg-opacity-10"
                                                                                enctype="multipart/form-data">
                                                                                @csrf
                                                                                <input type="hidden"
                                                                                    name="aeo_question_id"
                                                                                    value="{{ $row->id }}">
                                                                                <input type="hidden" name="document_type"
                                                                                    value="new">
                                                                                <input type="hidden" name="is_valid"
                                                                                    value="0">

                                                                                <!-- New Document Information -->
                                                                                <div class="alert alert-success py-2 mb-2">
                                                                                    <small><i
                                                                                            class="fas fa-plus-circle"></i>
                                                                                        <strong>Add New Document:</strong>
                                                                                        Create a new document with
                                                                                        validation
                                                                                        files
                                                                                        and mark as invalid.</small>
                                                                                </div>

                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label form-label-sm"><strong>New
                                                                                            Document
                                                                                            Name:</strong></label>
                                                                                    <input type="text"
                                                                                        name="nama_dokumen"
                                                                                        class="form-control form-control-sm"
                                                                                        placeholder="Enter new document name"
                                                                                        required>
                                                                                </div>

                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label form-label-sm text-muted">
                                                                                        <i class="fas fa-building"></i>
                                                                                        Department (Auto-filled)
                                                                                    </label>
                                                                                    <input type="text" name="dept"
                                                                                        class="form-control form-control-sm"
                                                                                        value="{{ auth()->user()->dept ?? 'GENERAL' }}"
                                                                                        readonly
                                                                                        style="background-color: #f8f9fa; cursor: not-allowed;">
                                                                                </div>

                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label form-label-sm"><strong>Document
                                                                                            No:</strong></label>
                                                                                    <input type="text"
                                                                                        name="no_sop_wi_std_form_other"
                                                                                        class="form-control form-control-sm"
                                                                                        placeholder="Enter document number (optional)">
                                                                                </div>

                                                                                <!-- Document Files -->
                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label form-label-sm"><strong>Document
                                                                                            Files:</strong></label>
                                                                                    <input type="file" name="files[]"
                                                                                        class="form-control form-control-sm"
                                                                                        multiple
                                                                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif">
                                                                                    <small class="text-muted">Upload main
                                                                                        document
                                                                                        files</small>
                                                                                </div>

                                                                                <!-- Validation Notes -->
                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label form-label-sm"><strong>Notes/Reason:</strong></label>
                                                                                    <textarea name="validation_notes" class="form-control form-control-sm" rows="3"
                                                                                        placeholder="Provide notes or reason for this new document..."></textarea>
                                                                                </div>

                                                                                <div class="d-flex gap-1">
                                                                                    <button type="submit"
                                                                                        class="btn btn-sm btn-success">
                                                                                        <i class="fas fa-save"></i> Create
                                                                                        New
                                                                                        Document
                                                                                    </button>
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-secondary"
                                                                                        data-bs-toggle="collapse"
                                                                                        data-bs-target="#newDocForm{{ $doc->id }}">
                                                                                        Cancel
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="text-muted text-center py-3">
                                                            <i class="fas fa-inbox"></i><br>
                                                            <small>No master documents yet</small>
                                                        </div>
                                                    @endif
                                                </td>

                                                <!-- COLUMN: NEW DOCUMENTS -->
                                                <td class="bg-light">
                                                    <br><br>
                                                    @php
                                                        $newDocs = $row->documents
                                                            ? $row->documents->where('document_type', 'new')
                                                            : collect();
                                                    @endphp
                                                    @if ($newDocs->count() > 0)
                                                        @foreach ($newDocs as $newDoc)
                                                            <div class="border rounded p-2 mb-2 bg-white">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-start">
                                                                    <div class="flex-grow-1">
                                                                        <!-- Document Name -->
                                                                        <strong class="d-block text-success">
                                                                            {{ $newDoc->nama_dokumen }}
                                                                        </strong>

                                                                        @if ($newDoc->no_sop_wi_std_form_other)
                                                                            <small class="text-muted d-block">
                                                                                No: {{ $newDoc->no_sop_wi_std_form_other }}
                                                                            </small>
                                                                        @endif

                                                                        @if ($newDoc->dept)
                                                                            <small class="text-muted d-block">
                                                                                <i class="fas fa-building"></i> Dept:
                                                                                {{ $newDoc->dept }}
                                                                            </small>
                                                                        @endif

                                                                        <small class="text-muted d-block">
                                                                            <i class="fas fa-clock"></i> Created:
                                                                            {{ $newDoc->created_at->format('d/m/Y H:i') }}
                                                                        </small>

                                                                        <!-- Status Badge -->
                                                                        <div class="mt-2 mb-2">
                                                                            <span class="badge bg-warning">
                                                                                <i class="fas fa-exclamation-triangle"></i>
                                                                                New Document
                                                                            </span>
                                                                        </div>

                                                                        @if ($newDoc->validation_notes)
                                                                            <div class="alert alert-info py-1 mt-2">
                                                                                <small><strong>Notes:</strong>
                                                                                    {{ $newDoc->validation_notes }}</small>
                                                                            </div>
                                                                        @endif

                                                                        <!-- Document Files -->
                                                                        @if ($newDoc->files && count($newDoc->files) > 0)
                                                                            <div class="mt-2">
                                                                                <small class="text-muted d-block"><strong>Document
                                                                                        Files:</strong></small>
                                                                                @foreach ($newDoc->files as $f)
                                                                                    <a href="{{ Storage::url($f) }}"
                                                                                        target="_blank"
                                                                                        class="btn btn-xs btn-outline-primary me-1 mb-1">
                                                                                        <i class="fas fa-download"></i>
                                                                                        File
                                                                                    </a>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif

                                                                        <!-- Validation Files -->
                                                                        @if ($newDoc->validation_files && count($newDoc->validation_files) > 0)
                                                                            <div class="mt-2">
                                                                                <small class="text-muted d-block"><strong>Validation
                                                                                        Files:</strong></small>
                                                                                @foreach ($newDoc->validation_files as $vf)
                                                                                    <a href="{{ Storage::url($vf) }}"
                                                                                        target="_blank"
                                                                                        class="btn btn-xs btn-outline-success me-1 mb-1">
                                                                                        <i class="fas fa-file"></i>
                                                                                        File
                                                                                    </a>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    <!-- Document Actions -->
                                                                    <div class="ms-2">
                                                                        <div class="btn-group-vertical" role="group">
                                                                            <a href="{{ route('aeo.documents.edit', $newDoc) }}"
                                                                                class="btn btn-sm btn-warning"
                                                                                title="Edit New Document">
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                            <form
                                                                                action="{{ route('aeo.documents.destroy', $newDoc) }}"
                                                                                method="POST" class="d-inline">
                                                                                @csrf @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-danger"
                                                                                    onclick="return confirm('Delete this new document?')"
                                                                                    title="Delete New Document">
                                                                                    <i class="fas fa-trash"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="text-muted text-center py-3">
                                                            <i class="fas fa-inbox"></i><br>
                                                            <small>No new documents yet</small>
                                                        </div>
                                                    @endif
                                                </td>

                                                <!-- COLUMN: FINAL VALIDASI BY AEO MGR -->
                                                <td class="bg-light">
                                                    @php
                                                        $allDocs = $row->documents ?? collect();
                                                    @endphp
                                                    @if ($allDocs->count() > 0)
                                                        @foreach ($allDocs as $doc)
                                                            <div class="border rounded p-2 mb-2 bg-white">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-start">
                                                                    <div class="flex-grow-1">
                                                                        <strong class="d-block text-primary">
                                                                            {{ Str::limit($doc->nama_dokumen, 25) }}
                                                                        </strong>

                                                                        <!-- AEO Manager Validation Status -->
                                                                        <div class="mt-2 mb-2">
                                                                            @if ($doc->aeo_manager_valid === true)
                                                                                <span class="badge bg-success">
                                                                                    <i class="fas fa-check-circle"></i>
                                                                                    Valid
                                                                                </span>
                                                                            @elseif ($doc->aeo_manager_valid === false)
                                                                                <span class="badge bg-danger">
                                                                                    <i class="fas fa-times-circle"></i>
                                                                                    Invalid
                                                                                </span>
                                                                            @else
                                                                                <span class="badge bg-secondary">
                                                                                    <i class="fas fa-clock"></i> Pending
                                                                                </span>
                                                                            @endif
                                                                        </div>

                                                                        @if ($doc->aeo_manager_notes)
                                                                            <div class="alert alert-info py-1 mt-2">
                                                                                <small><strong>Notes:</strong>
                                                                                    {{ Str::limit($doc->aeo_manager_notes, 50) }}</small>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    <!-- AEO Manager Toggle -->
                                                                    <div class="ms-2">
                                                                        <div class="form-check form-switch">
                                                                            <input
                                                                                class="form-check-input aeo-manager-toggle"
                                                                                type="checkbox"
                                                                                id="aeoManagerToggle{{ $doc->id }}"
                                                                                {{ $doc->aeo_manager_valid ? 'checked' : '' }}
                                                                                data-doc-id="{{ $doc->id }}"
                                                                                data-route="{{ route('aeo.documents.aeo-manager-toggle', $doc) }}">
                                                                            <label class="form-check-label fw-bold"
                                                                                for="aeoManagerToggle{{ $doc->id }}">
                                                                                <span
                                                                                    class="aeo-valid-text {{ $doc->aeo_manager_valid ? 'text-success' : 'text-muted' }}">
                                                                                    <i class="fas fa-check"></i>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="text-muted text-center py-3">
                                                            <i class="fas fa-inbox"></i><br>
                                                            <small>No documents</small>
                                                        </div>
                                                    @endif
                                                </td>

                                                <!-- COLUMN: STATUS -->
                                                <td class="bg-light">
                                                    @if ($allDocs->count() > 0)
                                                        @foreach ($allDocs as $doc)
                                                            <div class="border rounded p-2 mb-2 bg-white">
                                                                <div class="text-center">
                                                                    @php
                                                                        $statusColors = [
                                                                            'draft' => 'bg-secondary',
                                                                            'in_review' => 'bg-primary',
                                                                            'approved' => 'bg-success',
                                                                            'rejected' => 'bg-danger',
                                                                            'pending' => 'bg-warning',
                                                                        ];
                                                                        $statusIcons = [
                                                                            'draft' => 'fa-edit',
                                                                            'in_review' => 'fa-eye',
                                                                            'approved' => 'fa-check',
                                                                            'rejected' => 'fa-times',
                                                                            'pending' => 'fa-clock',
                                                                        ];
                                                                    @endphp
                                                                    <span
                                                                        class="badge {{ $statusColors[$doc->status] ?? 'bg-secondary' }}">
                                                                        <i
                                                                            class="fas {{ $statusIcons[$doc->status] ?? 'fa-question' }}"></i>
                                                                        {{ ucfirst($doc->status) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="text-muted text-center py-3">
                                                            <small>-</small>
                                                        </div>
                                                    @endif
                                                </td>

                                                <!-- COLUMN: AKSI -->
                                                <td class="text-center">
                                                    <div class="btn-group-vertical" role="group">
                                                        <a href="{{ route('aeo.questions.edit', $row) }}"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('aeo.questions.destroy', $row) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                onclick="return confirm('Delete this question and all related documents?')"
                                                                class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="13" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                    No questions found. <a href="{{ route('aeo.questions.create') }}">Add
                                                        your first question</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom DataTables styling */
        #aeoQuestionsTable_wrapper .row {
            margin-bottom: 1rem;
        }

        /* Make No column narrower */
        #aeoQuestionsTable th:first-child,
        #aeoQuestionsTable td:first-child {
            width: 60px;
            min-width: 60px;
            max-width: 60px;
            text-align: center;
        }

        .dataTables_length select,
        .dataTables_filter input {
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .dataTables_info {
            padding-top: 0.85rem;
        }

        /* Make action buttons smaller in DataTables */
        .dt-buttons {
            margin-bottom: 1rem;
        }

        .dt-button {
            margin-right: 0.5rem !important;
        }

        /* Validation button styling */
        .validation-form {
            background-color: #f8f9fa;
            padding: 0.5rem;
            border-radius: 0.25rem;
        }

        .badge.fs-6 {
            font-size: 1rem !important;
            padding: 0.5em 0.75em;
        }

        .btn-group-sm .btn {
            font-size: 0.875rem;
        }

        /* Upload form styling */
        .upload-form {
            border: 2px dashed #dee2e6;
            margin-top: 0.5rem;
        }

        .upload-form:hover {
            border-color: #0d6efd;
        }

        .alert-danger small,
        .alert-warning small {
            margin: 0;
        }

        /* New Document styling */
        .new-document-form {
            background-color: #d1edff;
            border: 1px solid #0dcaf0;
        }

        /* Dropdown menu styling */
        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-menu .dropdown-item i {
            width: 16px;
            margin-right: 5px;
        }

        /* Validation toggle styling */
        .form-switch .form-check-input {
            width: 2.5em;
            height: 1.25em;
        }

        .form-switch .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }

        .form-switch .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }

        .validation-toggle:disabled {
            opacity: 0.6;
            pointer-events: none;
        }

        .valid-text {
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .toast {
            min-width: 300px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#aeoQuestionsTable').DataTable({
                // Enable features
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,

                // Page length options
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "pageLength": 10,
                // Default ordering
                "order": [
                    [0, 'asc']
                ], // Sort by No column

                // Column definitions
                "columnDefs": [{
                    "targets": 0, // No column
                    "width": "60px",
                    "className": "text-center",
                    "orderable": true
                }],

                // Language customization
                "language": {
                    "lengthMenu": "Show _MENU_ entries per page",
                    "zeroRecords": "No matching records found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries available",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "search": "Search:",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                },

                // Export buttons
                "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                    '<"row"<"col-sm-12 col-md-6"B>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',

                "buttons": [{
                        extend: 'copy',
                        className: 'btn btn-secondary btn-sm',
                        text: '<i class="fas fa-copy"></i> Copy',
                        exportOptions: {
                            columns: [1, 2, 3, 4] // Export only specific columns
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success btn-sm',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger btn-sm',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        },
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-info btn-sm',
                        text: '<i class="fas fa-print"></i> Print',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        }
                    }
                ]
            });

            // Handle AEO Manager validation toggle switches
            $('.aeo-manager-toggle').on('change', function() {
                const toggle = $(this);
                const docId = toggle.data('doc-id');
                const route = toggle.data('route');
                const isValid = toggle.is(':checked');
                const validText = toggle.closest('.form-check').find('.aeo-valid-text');

                // Show loading state
                toggle.prop('disabled', true);

                // Create form data
                const formData = new FormData();
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('aeo_manager_valid', isValid ? '1' : '0');

                // Send AJAX request
                fetch(route, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update UI based on validation status
                            if (isValid) {
                                validText.removeClass('text-muted').addClass('text-success');
                                showToast('Document marked as valid by AEO Manager!', 'success');
                            } else {
                                validText.removeClass('text-success').addClass('text-muted');
                                showToast('Document marked as invalid by AEO Manager', 'info');
                            }

                            // Refresh the page after a short delay to show updated data
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            // Revert toggle state on error
                            toggle.prop('checked', !isValid);
                            showToast('Error updating AEO Manager validation status', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Revert toggle state on error
                        toggle.prop('checked', !isValid);
                        showToast('Error updating AEO Manager validation status', 'error');
                    })
                    .finally(() => {
                        // Re-enable toggle
                        toggle.prop('disabled', false);
                    });
            });

            // Handle validation toggle switches
            $('.validation-toggle').on('change', function() {
                const toggle = $(this);
                const docId = toggle.data('doc-id');
                const route = toggle.data('route');
                const isValid = toggle.is(':checked');
                const validText = toggle.closest('.btn-group-vertical').find('.valid-text');

                // Show loading state
                toggle.prop('disabled', true);

                // Create form data
                const formData = new FormData();
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('is_valid', isValid ? '1' : '0');

                // Send AJAX request
                fetch(route, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update UI based on validation status
                            if (isValid) {
                                validText.removeClass('text-muted').addClass('text-success');
                                // Show success message
                                showToast('Document marked as valid!', 'success');
                            } else {
                                validText.removeClass('text-success').addClass('text-muted');
                                // Show info message
                                showToast('Document marked as invalid', 'info');
                            }

                            // Refresh the page after a short delay to show updated data
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            // Revert toggle state on error
                            toggle.prop('checked', !isValid);
                            showToast('Error updating validation status', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Revert toggle state on error
                        toggle.prop('checked', !isValid);
                        showToast('Error updating validation status', 'error');
                    })
                    .finally(() => {
                        // Re-enable toggle
                        toggle.prop('disabled', false);
                    });
            });

            // Simple toast notification function
            function showToast(message, type = 'info') {
                const toastHtml = `
                    <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'primary'} border-0 position-fixed top-0 end-0 m-3" 
                         role="alert" style="z-index: 9999;">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
                                ${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `;

                $('body').append(toastHtml);
                const toast = new bootstrap.Toast($('.toast').last());
                toast.show();

                // Remove toast element after it's hidden
                $('.toast').last().on('hidden.bs.toast', function() {
                    $(this).remove();
                });
            }
        });
    </script>
@endpush
