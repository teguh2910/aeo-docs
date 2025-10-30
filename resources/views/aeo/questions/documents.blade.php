@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title mb-0">
                                    <i class="fas fa-file-alt"></i> Question Documents Detail
                                </h4>
                                <small class="text-muted">
                                    Subcriteria: <strong>{{ $question->subcriteria }}</strong>
                                </small>
                            </div>
                            <a href="{{ route('aeo.questions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Questions
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Question Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">Question</h6>
                                        <p class="card-text">{{ $question->question }}</p>

                                        @if ($question->jawaban)
                                            <h6 class="card-subtitle mb-2 text-muted mt-3">Answer</h6>
                                            <p class="card-text">{{ $question->jawaban }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div class="row">
                            <!-- Master Documents -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-file-archive"></i> Master Documents
                                            <span class="badge bg-light text-dark ms-2">
                                                {{ $question->documents->where('document_type', 'master')->count() }}
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $masterDocs = $question->documents->where('document_type', 'master');
                                        @endphp

                                        @if ($masterDocs->count() > 0)
                                            @foreach ($masterDocs as $doc)
                                                <div class="border rounded p-3 mb-3">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="flex-grow-1">
                                                            <h6 class="text-primary mb-2">{{ $doc->nama_dokumen }}</h6>

                                                            @if ($doc->no_sop_wi_std_form_other)
                                                                <p class="text-muted mb-1">
                                                                    <small><strong>No:</strong>
                                                                        {{ $doc->no_sop_wi_std_form_other }}</small>
                                                                </p>
                                                            @endif

                                                            <p class="text-muted mb-1">
                                                                <small><i class="fas fa-building"></i>
                                                                    {{ $doc->dept }}</small>
                                                            </p>

                                                            <p class="text-muted mb-2">
                                                                <small><i class="fas fa-clock"></i> Updated:
                                                                    {{ $doc->updated_at->format('d/m/Y H:i') }}</small>
                                                            </p>

                                                            <!-- Validation Status -->
                                                            <div class="mb-2">
                                                                <span
                                                                    class="badge {{ $doc->is_valid ? 'bg-success' : 'bg-danger' }}">
                                                                    <i
                                                                        class="fas {{ $doc->is_valid ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                                    {{ $doc->is_valid ? 'Valid' : 'Invalid' }}
                                                                </span>

                                                                <!-- Validation Toggle Button -->
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-primary ms-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#validationModal{{ $doc->id }}"
                                                                    title="Toggle Validation">
                                                                    <i class="fas fa-toggle-on"></i> Toggle
                                                                </button>

                                                                @if ($doc->aeo_manager_valid !== null)
                                                                    <span
                                                                        class="badge {{ $doc->aeo_manager_valid ? 'bg-success' : 'bg-warning' }} ms-1">
                                                                        <i class="fas fa-user-shield"></i>
                                                                        AEO Mgr:
                                                                        {{ $doc->aeo_manager_valid ? 'Valid' : 'Invalid' }}
                                                                    </span>

                                                                    <!-- AEO Manager Undo Button -->
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-secondary ms-1 aeo-manager-undo-btn"
                                                                        data-document-id="{{ $doc->id }}"
                                                                        title="Undo AEO Manager Validation">
                                                                        <i class="fas fa-undo"></i> Undo
                                                                    </button>
                                                                @endif
                                                            </div>

                                                            <!-- Status Badge -->
                                                            @if ($doc->status)
                                                                @php
                                                                    $statusColors = [
                                                                        'draft' => 'bg-secondary',
                                                                        'in_review' => 'bg-primary',
                                                                        'approved' => 'bg-success',
                                                                        'rejected' => 'bg-danger',
                                                                        'pending' => 'bg-warning',
                                                                    ];
                                                                @endphp
                                                                {{-- <span
                                                                    class="badge {{ $statusColors[$doc->status] ?? 'bg-secondary' }}">
                                                                    {{ ucfirst($doc->status) }}
                                                                </span> --}}
                                                            @endif

                                                            <!-- Files -->
                                                            @if ($doc->files && count($doc->files) > 0)
                                                                <div class="mt-3">
                                                                    <h6 class="text-muted">Files:</h6>
                                                                    @foreach ($doc->files as $file)
                                                                        <div class="mb-2">
                                                                            <a href="{{ Storage::url($file) }}"
                                                                                target="_blank"
                                                                                class="btn btn-outline-primary btn-sm">
                                                                                <i class="fas fa-download"></i>
                                                                                File
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            <!-- Validation Files -->
                                                            @if ($doc->validation_files && count($doc->validation_files) > 0)
                                                                <div class="mt-3">
                                                                    <h6 class="text-muted">Validation Files:</h6>
                                                                    @foreach ($doc->validation_files as $file)
                                                                        <div class="mb-2">
                                                                            <a href="{{ Storage::url($file) }}"
                                                                                target="_blank"
                                                                                class="btn btn-outline-success btn-sm">
                                                                                <i class="fas fa-download"></i>
                                                                                {{ basename($file) }}
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            <!-- Notes -->
                                                            @if ($doc->validation_notes)
                                                                <div class="alert alert-warning mt-3">
                                                                    <small><strong>Validation Notes:</strong>
                                                                        {{ $doc->validation_notes }}</small>
                                                                </div>
                                                            @endif

                                                            @if ($doc->aeo_manager_notes)
                                                                <div class="alert alert-info mt-3">
                                                                    <small><strong>AEO Manager Notes:</strong>
                                                                        {{ $doc->aeo_manager_notes }}</small>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="ms-3">
                                                            <div class="btn-group-vertical" role="group">
                                                                <a href="{{ route('aeo.documents.edit', $doc) }}"
                                                                    class="btn btn-sm btn-warning" title="Edit Document">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('aeo.documents.destroy', $doc) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit"
                                                                        onclick="return confirm('Delete this document?')"
                                                                        class="btn btn-sm btn-danger"
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
                                            <div class="text-center py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No master documents yet</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Validation Modals for Master Documents -->
                            @foreach ($question->documents->where('document_type', 'master') as $doc)
                                <div class="modal fade" id="validationModal{{ $doc->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('aeo.documents.toggle-validation', $doc) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-check-circle"></i> Toggle Document Validation
                                                    </h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <strong>Document:</strong> {{ $doc->nama_dokumen }}
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="is_valid" id="isValid{{ $doc->id }}"
                                                                value="1" {{ $doc->is_valid ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="isValid{{ $doc->id }}">
                                                                Mark as Valid
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="validationNotes{{ $doc->id }}"
                                                            class="form-label">
                                                            Validation Notes (optional)
                                                        </label>
                                                        <textarea class="form-control" name="validation_notes" id="validationNotes{{ $doc->id }}" rows="3"
                                                            placeholder="Add notes about the validation...">{{ $doc->validation_notes }}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="validationFiles{{ $doc->id }}"
                                                            class="form-label">
                                                            Validation Files (optional)
                                                        </label>
                                                        <input type="file" class="form-control"
                                                            name="validation_files[]"
                                                            id="validationFiles{{ $doc->id }}" multiple
                                                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif">
                                                        <small class="text-muted">You can upload multiple files (max 10MB
                                                            each)</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save"></i> Update Validation
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- New Documents -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-file-plus"></i> New Documents
                                            <span class="badge bg-light text-dark ms-2">
                                                {{ $question->documents->where('document_type', 'new')->count() }}
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $newDocs = $question->documents->where('document_type', 'new');
                                        @endphp

                                        @if ($newDocs->count() > 0)
                                            @foreach ($newDocs as $doc)
                                                <div class="border rounded p-3 mb-3">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="flex-grow-1">
                                                            <h6 class="text-success mb-2">{{ $doc->nama_dokumen }}</h6>

                                                            @if ($doc->no_sop_wi_std_form_other)
                                                                <p class="text-muted mb-1">
                                                                    <small><strong>No:</strong>
                                                                        {{ $doc->no_sop_wi_std_form_other }}</small>
                                                                </p>
                                                            @endif

                                                            <p class="text-muted mb-1">
                                                                <small><i class="fas fa-building"></i>
                                                                    {{ $doc->dept }}</small>
                                                            </p>

                                                            <p class="text-muted mb-2">
                                                                <small><i class="fas fa-clock"></i> Created:
                                                                    {{ $doc->created_at->format('d/m/Y H:i') }}</small>
                                                            </p>

                                                            <!-- Status Badge -->
                                                            <div class="mb-2">
                                                                <span class="badge bg-warning">
                                                                    <i class="fas fa-exclamation-circle"></i> New Document
                                                                </span>

                                                                @if ($doc->aeo_manager_valid !== null)
                                                                    <span
                                                                        class="badge {{ $doc->aeo_manager_valid ? 'bg-success' : 'bg-danger' }} ms-1">
                                                                        <i class="fas fa-user-shield"></i>
                                                                        AEO Mgr:
                                                                        {{ $doc->aeo_manager_valid ? 'Valid' : 'Invalid' }}
                                                                    </span>

                                                                    <!-- AEO Manager Undo Button -->
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-secondary ms-1 aeo-manager-undo-btn"
                                                                        data-document-id="{{ $doc->id }}"
                                                                        title="Undo AEO Manager Validation">
                                                                        <i class="fas fa-undo"></i> Undo
                                                                    </button>
                                                                @endif
                                                            </div>

                                                            <!-- Status Badge -->
                                                            @if ($doc->status)
                                                                @php
                                                                    $statusColors = [
                                                                        'draft' => 'bg-secondary',
                                                                        'in_review' => 'bg-primary',
                                                                        'approved' => 'bg-success',
                                                                        'rejected' => 'bg-danger',
                                                                        'pending' => 'bg-warning',
                                                                    ];
                                                                @endphp
                                                                <span
                                                                    class="badge {{ $statusColors[$doc->status] ?? 'bg-secondary' }}">
                                                                    {{ ucfirst($doc->status) }}
                                                                </span>
                                                            @endif

                                                            <!-- Files -->
                                                            @if ($doc->files && count($doc->files) > 0)
                                                                <div class="mt-3">
                                                                    <h6 class="text-muted">Files:</h6>
                                                                    @foreach ($doc->files as $file)
                                                                        <div class="mb-2">
                                                                            <a href="{{ Storage::url($file) }}"
                                                                                target="_blank"
                                                                                class="btn btn-outline-success btn-sm">
                                                                                <i class="fas fa-download"></i>
                                                                                {{ basename($file) }}
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            <!-- Validation Files -->
                                                            @if ($doc->validation_files && count($doc->validation_files) > 0)
                                                                <div class="mt-3">
                                                                    <h6 class="text-muted">Validation Files:</h6>
                                                                    @foreach ($doc->validation_files as $file)
                                                                        <div class="mb-2">
                                                                            <a href="{{ Storage::url($file) }}"
                                                                                target="_blank"
                                                                                class="btn btn-outline-info btn-sm">
                                                                                <i class="fas fa-download"></i>
                                                                                {{ basename($file) }}
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            <!-- Notes -->
                                                            @if ($doc->validation_notes)
                                                                <div class="alert alert-info mt-3">
                                                                    <small><strong>Notes:</strong>
                                                                        {{ $doc->validation_notes }}</small>
                                                                </div>
                                                            @endif

                                                            @if ($doc->aeo_manager_notes)
                                                                <div class="alert alert-info mt-3">
                                                                    <small><strong>AEO Manager Notes:</strong>
                                                                        {{ $doc->aeo_manager_notes }}</small>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="ms-3">
                                                            <div class="btn-group-vertical" role="group">
                                                                <a href="{{ route('aeo.documents.edit', $doc) }}"
                                                                    class="btn btn-sm btn-warning" title="Edit Document">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('aeo.documents.destroy', $doc) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit"
                                                                        onclick="return confirm('Delete this document?')"
                                                                        class="btn btn-sm btn-danger"
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
                                            <div class="text-center py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No new documents yet</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            $userDept = auth()->user()->dept ?? 'GENERAL';
                        @endphp

                        @if (!in_array($userDept, ['internal_audit', 'AEO', 'management1', 'management2']))
                            <!-- Add Document Section -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="fas fa-plus"></i> Add New Document
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Add Master Document -->
                                                <div class="col-md-6">
                                                    <div class="card border-primary">
                                                        <div class="card-header bg-primary text-white">
                                                            <h6 class="mb-0">Add Master Document</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <form action="{{ route('aeo.documents.store') }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="aeo_question_id"
                                                                    value="{{ $question->id }}">
                                                                <input type="hidden" name="document_type"
                                                                    value="master">

                                                                <div class="mb-3">
                                                                    <label for="nama_dokumen_master"
                                                                        class="form-label">Document Name</label>
                                                                    <input type="text" name="nama_dokumen"
                                                                        id="nama_dokumen_master" class="form-control"
                                                                        required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="dept_master"
                                                                        class="form-label">Department</label>
                                                                    <input type="text" name="dept" id="dept_master"
                                                                        class="form-control"
                                                                        value="{{ auth()->user()->dept ?? 'GENERAL' }}"
                                                                        readonly style="background-color: #f8f9fa;">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="no_sop_master" class="form-label">No
                                                                        SOP/WI/STD/Form/Other</label>
                                                                    <input type="text" name="no_sop_wi_std_form_other"
                                                                        id="no_sop_master" class="form-control">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="files_master"
                                                                        class="form-label">Files</label>
                                                                    <input type="file" name="files[]"
                                                                        id="files_master" class="form-control" multiple>
                                                                </div>

                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fas fa-save"></i> Add Master Document
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Add New Document -->
                                                <div class="col-md-6">
                                                    <div class="card border-success">
                                                        <div class="card-header bg-success text-white">
                                                            <h6 class="mb-0">Add New Document</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <form action="{{ route('aeo.documents.store') }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="aeo_question_id"
                                                                    value="{{ $question->id }}">
                                                                <input type="hidden" name="document_type"
                                                                    value="new">

                                                                <div class="mb-3">
                                                                    <label for="nama_dokumen_new"
                                                                        class="form-label">Document
                                                                        Name</label>
                                                                    <input type="text" name="nama_dokumen"
                                                                        id="nama_dokumen_new" class="form-control"
                                                                        required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="dept_new"
                                                                        class="form-label">Department</label>
                                                                    <input type="text" name="dept" id="dept_new"
                                                                        class="form-control"
                                                                        value="{{ auth()->user()->dept ?? 'GENERAL' }}"
                                                                        readonly style="background-color: #f8f9fa;">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="no_sop_new" class="form-label">No
                                                                        SOP/WI/STD/Form/Other</label>
                                                                    <input type="text" name="no_sop_wi_std_form_other"
                                                                        id="no_sop_new" class="form-control">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="files_new"
                                                                        class="form-label">Files</label>
                                                                    <input type="file" name="files[]" id="files_new"
                                                                        class="form-control" multiple>
                                                                </div>

                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="fas fa-save"></i> Add New Document
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Handle AEO Manager Undo button clicks
                                document.querySelectorAll('.aeo-manager-undo-btn').forEach(button => {
                                    button.addEventListener('click', function() {
                                        const documentId = this.dataset.documentId;

                                        if (confirm(
                                                'Are you sure you want to undo the AEO Manager validation for this document?'
                                            )) {
                                            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                                                .getAttribute('content');

                                            fetch(`/aeo/documents/${documentId}/aeo-manager-undo`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': csrfToken,
                                                        'Accept': 'application/json'
                                                    },
                                                    body: JSON.stringify({})
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        // Show success message
                                                        if (typeof showToast !== 'undefined') {
                                                            showToast(data.message, 'success');
                                                        } else {
                                                            alert(data.message);
                                                        }

                                                        // Reload the page to show updated status
                                                        setTimeout(() => {
                                                            window.location.reload();
                                                        }, 1000);
                                                    } else {
                                                        if (typeof showToast !== 'undefined') {
                                                            showToast('Error undoing AEO Manager validation',
                                                                'error');
                                                        } else {
                                                            alert('Error undoing AEO Manager validation');
                                                        }
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Error:', error);
                                                    if (typeof showToast !== 'undefined') {
                                                        showToast('Error undoing AEO Manager validation', 'error');
                                                    } else {
                                                        alert('Error undoing AEO Manager validation');
                                                    }
                                                });
                                        }
                                    });
                                });
                            });
                        </script>
                    @endpush

                @endsection
