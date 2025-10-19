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
                                        <th class="text-center">Kondisi dan Persyaratan</th>
                                        <th class="text-center">Pertanyaan</th>
                                        {{-- <th>Keterangan</th> --}}
                                        <th class="text-center">Jawaban</th>
                                        <th class="text-center">Detail</th>
                                        <th class="text-center">Final Validasi by AEO Mgr</th>
                                        <th class="text-center">Approval</th>
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

                                                <!-- COLUMN: DETAIL -->
                                                <td class="bg-light text-center">
                                                    <div class="py-3">
                                                        <a href="{{ route('aeo.questions.documents', $row) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>
                                                        <div class="mt-2">
                                                            @php
                                                                $totalDocs = $row->documents
                                                                    ? $row->documents->count()
                                                                    : 0;
                                                                $masterDocs = $row->documents
                                                                    ? $row->documents
                                                                        ->where('document_type', 'master')
                                                                        ->count()
                                                                    : 0;
                                                                $newDocs = $row->documents
                                                                    ? $row->documents
                                                                        ->where('document_type', 'new')
                                                                        ->count()
                                                                    : 0;
                                                            @endphp
                                                            <small class="text-muted">
                                                                {{ $totalDocs }} documents<br>
                                                                ({{ $masterDocs }} master documents)
                                                            </small>
                                                        </div>
                                                </td>

                                                <!-- COLUMN: FINAL VALIDASI BY AEO MGR -->
                                                <td class="text-center">
                                                    @php
                                                        $hasValidatedDocs =
                                                            $row->documents
                                                                ->where('aeo_manager_validated_at', '!=', null)
                                                                ->count() > 0;
                                                        $allValid = $row->documents->every(
                                                            fn($doc) => $doc->aeo_manager_valid === true,
                                                        );
                                                        $hasInvalid = $row->documents->some(
                                                            fn($doc) => $doc->aeo_manager_valid === false,
                                                        );
                                                    @endphp

                                                    @if ($hasValidatedDocs)
                                                        @if ($allValid)
                                                            <span class="badge bg-success">Sesuai</span>
                                                            <br>
                                                            <button type="button"
                                                                class="btn btn-outline-secondary btn-sm mt-1 aeo-undo-all-btn"
                                                                data-question-id="{{ $row->id }}"
                                                                title="Undo All AEO Manager Validations">
                                                                <i class="fas fa-undo"></i> Undo All
                                                            </button>
                                                        @elseif ($hasInvalid)
                                                            <span class="badge bg-danger">Tidak Sesuai</span>
                                                            <br>
                                                            <button type="button"
                                                                class="btn btn-outline-secondary btn-sm mt-1 aeo-undo-all-btn"
                                                                data-question-id="{{ $row->id }}"
                                                                title="Undo All AEO Manager Validations">
                                                                <i class="fas fa-undo"></i> Undo All
                                                            </button>
                                                            @if ($row->documents->where('aeo_manager_valid', false)->first()?->due_date)
                                                                <br><small class="text-muted">Due:
                                                                    {{ $row->documents->where('aeo_manager_valid', false)->first()->due_date }}</small>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-warning">Partial</span>
                                                            <br>
                                                            <button type="button"
                                                                class="btn btn-outline-secondary btn-sm mt-1 aeo-undo-all-btn"
                                                                data-question-id="{{ $row->id }}"
                                                                title="Undo All AEO Manager Validations">
                                                                <i class="fas fa-undo"></i> Undo All
                                                            </button>
                                                        @endif
                                                    @else
                                                        <div class="btn-group-vertical gap-1">
                                                            <button type="button"
                                                                class="btn btn-success btn-sm aeo-validation-btn"
                                                                data-question-id="{{ $row->id }}"
                                                                data-status="sesuai">
                                                                <i class="fas fa-check"></i> Sesuai
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm aeo-validation-btn"
                                                                data-question-id="{{ $row->id }}"
                                                                data-status="tidak_sesuai" data-bs-toggle="modal"
                                                                data-bs-target="#aeoValidationModal">
                                                                <i class="fas fa-times"></i> Tidak Sesuai
                                                            </button>
                                                        </div>
                                                    @endif
                                                </td>



                                                <!-- COLUMN: APPROVAL -->
                                                <td class="text-center">
                                                    <div class="btn-group-vertical gap-1">
                                                        @if ($row->approval_1 === true)
                                                            <div class="mb-2">
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-check"></i> Approval 1 ✓
                                                                </span>
                                                                <br>
                                                                <small class="text-muted">
                                                                    {{ $row->approval_1_at ? $row->approval_1_at->format('d/m/Y H:i') : '' }}
                                                                </small>
                                                                @if ($row->approval1By)
                                                                    <br><small class="text-muted">by
                                                                        {{ $row->approval1By->name }}</small>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-primary btn-sm approval-btn"
                                                                data-question-id="{{ $row->id }}"
                                                                data-approval-type="1">
                                                                <i class="fas fa-check"></i> Approval 1
                                                            </button>
                                                        @endif

                                                        @if ($row->approval_2 === true)
                                                            <div class="mb-2">
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-check-double"></i> Approval 2 ✓
                                                                </span>
                                                                <br>
                                                                <small class="text-muted">
                                                                    {{ $row->approval_2_at ? $row->approval_2_at->format('d/m/Y H:i') : '' }}
                                                                </small>
                                                                @if ($row->approval2By)
                                                                    <br><small class="text-muted">by
                                                                        {{ $row->approval2By->name }}</small>
                                                                @endif
                                                            </div>
                                                        @elseif ($row->approval_1 === true)
                                                            <button type="button"
                                                                class="btn btn-success btn-sm approval-btn"
                                                                data-question-id="{{ $row->id }}"
                                                                data-approval-type="2">
                                                                <i class="fas fa-check-double"></i> Approval 2
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                disabled title="Complete Approval 1 first">
                                                                <i class="fas fa-check-double"></i> Approval 2
                                                            </button>
                                                        @endif
                                                    </div>
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
                                            <td colspan="8" class="text-center py-4">
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

    <!-- AEO Manager Validation Modal -->
    <div class="modal fade" id="aeoValidationModal" tabindex="-1" aria-labelledby="aeoValidationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aeoValidationModalLabel">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Validasi AEO Manager - Tidak Sesuai
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="aeoValidationForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="questionId" name="question_id">
                        <input type="hidden" name="validation_status" value="tidak_sesuai">

                        <div class="mb-3">
                            <label for="aeoManagerNotes" class="form-label">
                                <i class="fas fa-sticky-note"></i> Catatan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="aeoManagerNotes" name="aeo_manager_notes" rows="4"
                                placeholder="Masukkan catatan mengapa dokumen tidak sesuai..." required></textarea>
                            <div class="form-text">Jelaskan alasan mengapa dokumen dinyatakan tidak sesuai.</div>
                        </div>

                        <div class="mb-3">
                            <label for="dueDate" class="form-label">
                                <i class="fas fa-calendar-alt"></i> Tanggal Jatuh Tempo <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="dueDate" name="due_date"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            <div class="form-text">Tentukan batas waktu untuk perbaikan dokumen.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-save"></i> Simpan Validasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Approval Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel">
                        <i class="fas fa-check-circle text-success"></i>
                        Process Approval
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="approvalForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="approvalQuestionId" name="question_id">
                        <input type="hidden" id="approvalType" name="approval_type">

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <span id="approvalMessage">You are about to process this approval.</span>
                        </div>

                        <div class="mb-3">
                            <label for="approvalNotes" class="form-label">
                                <i class="fas fa-sticky-note"></i> Notes (Optional)
                            </label>
                            <textarea class="form-control" id="approvalNotes" name="notes" rows="3"
                                placeholder="Add any notes for this approval..."></textarea>
                            <div class="form-text">You can add optional notes to document the approval decision.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-success" id="approvalSubmitBtn">
                            <i class="fas fa-check"></i> Approve
                        </button>
                    </div>
                </form>
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

        /* AEO Manager Validation Buttons */
        .aeo-validation-btn {
            font-size: 0.875rem;
            margin-bottom: 2px;
        }

        .aeo-validation-btn:disabled {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Modal styling improvements */
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        /* Form validation styling */
        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6.7.8L6.6 6l-.1 1.4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
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
                            columns: [0, 1, 2, 3, 4, 5, 6] // Export all columns except Actions
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success btn-sm',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger btn-sm',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-info btn-sm',
                        text: '<i class="fas fa-print"></i> Print',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }
                ]
            });

            // Handle AEO Manager validation buttons
            $('.aeo-validation-btn').on('click', function() {
                const button = $(this);
                const questionId = button.data('question-id');
                const status = button.data('status');

                if (status === 'sesuai') {
                    // Handle "Sesuai" directly
                    handleAeoValidation(questionId, 'sesuai', null, null);
                } else if (status === 'tidak_sesuai') {
                    // Set the question ID in the modal
                    $('#questionId').val(questionId);
                    // Modal will be shown by Bootstrap automatically due to data-bs-toggle
                }
            });

            // Handle AEO Validation Form submission
            $('#aeoValidationForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const questionId = $('#questionId').val();
                const notes = $('#aeoManagerNotes').val().trim();
                const dueDate = $('#dueDate').val();

                if (!notes) {
                    showToast('Catatan harus diisi', 'error');
                    return;
                }

                if (!dueDate) {
                    showToast('Tanggal jatuh tempo harus diisi', 'error');
                    return;
                }

                handleAeoValidation(questionId, 'tidak_sesuai', notes, dueDate);
            });

            // Function to handle AEO validation
            function handleAeoValidation(questionId, status, notes, dueDate) {
                const route = `{{ route('aeo.questions.aeo-manager-validation', ':id') }}`.replace(':id',
                    questionId);

                // Create form data
                const formData = new FormData();
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('validation_status', status);
                if (notes) formData.append('aeo_manager_notes', notes);
                if (dueDate) formData.append('due_date', dueDate);

                // Show loading state
                if (status === 'sesuai') {
                    $(`.aeo-validation-btn[data-question-id="${questionId}"]`).prop('disabled', true);
                } else {
                    $('#aeoValidationForm button[type="submit"]').prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
                }

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
                            if (status === 'sesuai') {
                                showToast('Dokumen berhasil divalidasi sebagai Sesuai', 'success');
                            } else {
                                showToast(
                                    'Dokumen berhasil divalidasi sebagai Tidak Sesuai dengan catatan dan tenggat waktu',
                                    'success');
                                // Hide modal
                                $('#aeoValidationModal').modal('hide');
                            }

                            // Refresh the page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showToast('Error saat memvalidasi dokumen', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Error saat memvalidasi dokumen', 'error');
                    })
                    .finally(() => {
                        // Re-enable buttons
                        if (status === 'sesuai') {
                            $(`.aeo-validation-btn[data-question-id="${questionId}"]`).prop('disabled', false);
                        } else {
                            $('#aeoValidationForm button[type="submit"]').prop('disabled', false).html(
                                '<i class="fas fa-save"></i> Simpan Validasi');
                        }
                    });
            }

            // Reset modal when closed
            $('#aeoValidationModal').on('hidden.bs.modal', function() {
                $('#aeoValidationForm')[0].reset();
                $('#aeoValidationForm').removeClass('was-validated');
                $('#questionId').val('');
                $('.form-control').removeClass('is-invalid');
            });

            // Real-time validation for notes field
            $('#aeoManagerNotes').on('input', function() {
                const value = $(this).val().trim();
                if (value.length > 0) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            });

            // Real-time validation for due date field
            $('#dueDate').on('change', function() {
                const value = $(this).val();
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const tomorrowStr = tomorrow.toISOString().split('T')[0];

                if (value && value >= tomorrowStr) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
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

            // Handle AEO Manager Undo All button clicks
            $('.aeo-undo-all-btn').on('click', function() {
                const questionId = $(this).data('question-id');
                const button = $(this);

                if (confirm(
                        'Are you sure you want to undo ALL AEO Manager validations for this question? This will reset all validated documents to pending status.'
                    )) {
                    // Disable button during request
                    button.prop('disabled', true);

                    const csrfToken = $('meta[name="csrf-token"]').attr('content');

                    fetch(`/aeo/questions/${questionId}/aeo-manager-undo-all`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast(data.message, 'success');

                                // Refresh the page to show updated status
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                showToast('Error undoing AEO Manager validations', 'error');
                                button.prop('disabled', false);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Error undoing AEO Manager validations', 'error');
                            button.prop('disabled', false);
                        });
                } else {
                    // Re-enable button if user cancelled
                    button.prop('disabled', false);
                }
            });

            // Handle Approval buttons
            $('.approval-btn').on('click', function() {
                const button = $(this);
                const questionId = button.data('question-id');
                const approvalType = button.data('approval-type');

                // Set modal data
                $('#approvalQuestionId').val(questionId);
                $('#approvalType').val(approvalType);
                $('#approvalMessage').text(
                    `You are about to process Approval ${approvalType} for this question.`);
                $('#approvalModalLabel').html(
                    `<i class="fas fa-check-circle text-success"></i> Process Approval ${approvalType}`);

                // Show modal
                $('#approvalModal').modal('show');
            });

            // Handle Approval Form submission
            $('#approvalForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const questionId = $('#approvalQuestionId').val();
                const approvalType = $('#approvalType').val();
                const notes = $('#approvalNotes').val().trim();

                // Show loading state
                $('#approvalSubmitBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Processing...');

                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                fetch(`/aeo/questions/${questionId}/approval`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            approval_type: approvalType,
                            notes: notes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(`Approval ${approvalType} processed successfully!`, 'success');

                            // Hide modal
                            $('#approvalModal').modal('hide');

                            // Refresh the page to show updated status
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showToast(data.message || `Error processing Approval ${approvalType}`,
                                'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast(`Error processing Approval ${approvalType}`, 'error');
                    })
                    .finally(() => {
                        // Re-enable button
                        $('#approvalSubmitBtn').prop('disabled', false).html(
                            '<i class="fas fa-check"></i> Approve');
                    });
            });

            // Reset approval modal when closed
            $('#approvalModal').on('hidden.bs.modal', function() {
                $('#approvalForm')[0].reset();
                $('#approvalQuestionId').val('');
                $('#approvalType').val('');
                $('#approvalNotes').val('');
            });
        });
    </script>
@endpush
