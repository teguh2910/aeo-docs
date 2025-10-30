

<?php $__env->startPush('styles'); ?>
    <style>
        /* Subcriteria grouping styles */
        .subcriteria-group-secondary {
            background-color: #f8f9fa !important;
            border-left: 3px solid #0d6efd;
        }

        .subcriteria-indicator {
            color: #6c757d;
            font-size: 0.85em;
        }

        /* DataTables Bootstrap 5 Integration */
        #aeoQuestionsTable_wrapper {
            padding: 0;
        }

        #aeoQuestionsTable_wrapper .row {
            margin-bottom: 1rem;
        }



        /* Export buttons styling */
        .dt-buttons {
            margin-bottom: 1rem;
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .dt-button {
            margin: 0 !important;
        }

        /* Table styling */
        #aeoQuestionsTable {
            width: 100% !important;
        }

        #aeoQuestionsTable thead th {
            background-color: #212529;
            color: white;
            font-weight: 600;
            border-color: #212529;
            padding: 0.5rem 0.4rem;
            vertical-align: middle;
            font-size: 0.875rem;
        }

        #aeoQuestionsTable tbody td {
            padding: 0.5rem 0.4rem;
            vertical-align: top;
            font-size: 0.85rem;
        }

        /* Column width customization */
        #aeoQuestionsTable th:first-child,
        #aeoQuestionsTable td:first-child {
            width: 50px;
            min-width: 50px;
            text-align: center;
        }

        #aeoQuestionsTable th:nth-child(2),
        #aeoQuestionsTable td:nth-child(2) {
            width: 80px;
            min-width: 80px;
            text-align: center;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dt-buttons {
                justify-content: center;
            }

            #aeoQuestionsTable {
                font-size: 0.875rem;
            }
        }

        /* Badge styling */
        .badge {
            font-weight: 500;
            padding: 0.25em 0.5em;
            font-size: 0.75rem;
        }

        /* Button group styling */
        .btn-group-vertical {
            width: 100%;
        }

        .btn-group-vertical .btn {
            margin-bottom: 0.25rem;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        /* Smaller buttons in table */
        #aeoQuestionsTable .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        /* Compact action buttons */
        #aeoQuestionsTable .btn-group-vertical .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.4rem;
        }

        /* Compact alerts */
        .alert {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }

        .alert ul {
            font-size: 0.85rem;
            padding-left: 1.25rem;
        }

        .alert small {
            font-size: 0.75rem;
        }

        /* Validation button styling */
        .validation-form {
            background-color: #f8f9fa;
            padding: 0.5rem;
            border-radius: 0.25rem;
        }

        .badge.fs-6 {
            font-size: 0.8rem !important;
            padding: 0.35em 0.6em;
        }

        .btn-group-sm .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        /* Smaller text in table */
        #aeoQuestionsTable small {
            font-size: 0.7rem;
        }

        #aeoQuestionsTable .text-muted {
            font-size: 0.75rem;
        }

        /* Smaller icons in buttons */
        #aeoQuestionsTable .btn i,
        .btn-sm i {
            font-size: 0.85em;
        }

        /* Compact card header */
        .card-header h5 {
            font-size: 1.1rem;
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-shield"></i> AEO Questions & Documents Management
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php
                            $userDept = auth()->user()->dept ?? 'GENERAL';
                            $isAeoOrAdmin = in_array($userDept, ['AEO', 'admin']);
                            $canApprove = $userDept === 'admin'; // Only admin can approve
                            $canValidate = in_array($userDept, ['AEO', 'admin']); // AEO and admin can validate
                        ?>

                        <div class="mb-3">
                            <?php if($userDept === 'admin'): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-crown"></i>
                                    <strong>Administrator Access:</strong> You have full permissions:
                                    <ul class="mb-0 mt-2">
                                        <li>View questions from <strong>all departments</strong></li>
                                        <li>Edit and delete <strong>any question</strong></li>
                                        <li>Validate documents (AEO Manager validation)</li>
                                        <li><strong>Process Approval 1 & 2 (Admin only)</strong></li>
                                        <li>Import and export data</li>
                                    </ul>
                                    <small class="text-muted mt-2 d-block">Your Department:
                                        <strong><?php echo e($userDept); ?></strong> | Logged
                                        in as: <strong><?php echo e(auth()->user()->name); ?></strong></small>
                                </div>
                            <?php elseif($userDept === 'AEO'): ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-shield-alt"></i>
                                    <strong>AEO Manager Access:</strong> You have validation permissions:
                                    <ul class="mb-0 mt-2">
                                        <li>View questions from <strong>all departments</strong></li>
                                        <li>Edit and delete <strong>any question</strong></li>
                                        <li>Validate documents (AEO Manager validation)</li>
                                        <li class="text-muted"><s>Process approvals</s> (Admin only)</li>
                                        <li>Import and export data</li>
                                    </ul>
                                    <small class="text-muted mt-2 d-block">Your Department:
                                        <strong><?php echo e($userDept); ?></strong> | Logged
                                        in as: <strong><?php echo e(auth()->user()->name); ?></strong></small>
                                </div>
                            <?php elseif($userDept === 'internal_audit'): ?>
                                <div class="alert alert-primary">
                                    <i class="fas fa-clipboard-check"></i>
                                    <strong>Internal Audit Access:</strong> You have internal audit approval permissions:
                                    <ul class="mb-0 mt-2">
                                        <li>View questions from <strong>all departments</strong></li>
                                        <li><strong>Approve or Reject questions (Internal Audit)</strong></li>
                                        <li>View all documents and validations</li>
                                        <li class="text-muted"><s>Edit/delete questions</s> (Department/AEO/Admin only)</li>
                                        <li class="text-muted"><s>Validate documents</s> (AEO/Admin only)</li>
                                        <li class="text-muted"><s>Process approvals 1 & 2</s> (Admin only)</li>
                                    </ul>
                                    <small class="text-muted mt-2 d-block">Your Department:
                                        <strong><?php echo e($userDept); ?></strong> | Logged
                                        in as: <strong><?php echo e(auth()->user()->name); ?></strong></small>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Department View:</strong> You are viewing questions for your department only:
                                    <strong><?php echo e($userDept); ?></strong>
                                    <ul class="mb-0 mt-2">
                                        <li>You can only see questions assigned to <strong><?php echo e($userDept); ?></strong></li>
                                        <li>You can edit and delete questions from your department</li>
                                        <li>Validations require AEO/Admin access</li>
                                        <li>Approvals require Admin access only</li>
                                    </ul>
                                    <small class="text-muted mt-2 d-block">Logged in as:
                                        <strong><?php echo e(auth()->user()->name); ?></strong></small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="d-flex gap-2">
                                    <a href="<?php echo e(route('aeo.questions.import.form')); ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-file-excel"></i> Import Excel
                                    </a>
                                    <a href="<?php echo e(route('aeo.questions.create')); ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add Question
                                    </a>
                                </div>

                                <?php if(($isAeoOrAdmin || $userDept === 'internal_audit') && !empty($departments)): ?>
                                    <div class="d-flex gap-2 align-items-center">
                                        <label for="deptFilter" class="mb-0 fw-semibold">
                                            <i class="fas fa-filter"></i> Filter by Department:
                                        </label>
                                        <select id="deptFilter" class="form-select form-select-sm"
                                            style="width: auto; min-width: 150px;">
                                            <option value="all"
                                                <?php echo e(!$filterDept || $filterDept == 'all' ? 'selected' : ''); ?>>
                                                All Departments
                                            </option>
                                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($dept); ?>"
                                                    <?php echo e($filterDept == $dept ? 'selected' : ''); ?>>
                                                    <?php echo e($dept); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="aeoQuestionsTable" class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Dept</th>
                                        <th class="text-center">Kondisi dan Persyaratan</th>
                                        <th class="text-center">Pertanyaan</th>
                                        
                                        <th class="text-center">Jawaban</th>
                                        <th class="text-center">Detail</th>
                                        <th class="text-center">Internal Audit Approval</th>
                                        <th class="text-center">Final Validasi by AEO Mgr</th>
                                        <th class="text-center">Approval</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; ?>
                                    <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcriteria => $questions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questionIndex => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr
                                                class="align-top <?php echo e($questionIndex > 0 ? 'subcriteria-group-secondary' : ''); ?>">
                                                <td class="text-center"><?php echo e($counter++); ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary"><?php echo e($row->dept); ?></span>
                                                </td>
                                                <td>
                                                    <?php if($questionIndex == 0): ?>
                                                        <strong class="text-primary"><?php echo e($subcriteria); ?></strong>
                                                        <?php if($questions->count() > 1): ?>
                                                            <small class="badge bg-info ms-2"><?php echo e($questions->count()); ?>

                                                                questions</small>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <div class="ms-3">
                                                            <span class="subcriteria-indicator">
                                                                <i class="fas fa-level-down-alt fa-rotate-90"></i>
                                                                Question <?php echo e($questionIndex + 1); ?> of
                                                                <?php echo e($questions->count()); ?>

                                                            </span>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <div class="mb-2"><?php echo e($row->question); ?></div>

                                                    <?php if($row->files && count($row->files) > 0): ?>
                                                        <div class="border-top pt-2">
                                                            <small class="text-muted d-block"><strong>Question
                                                                    Files:</strong></small>
                                                            <?php $__currentLoopData = $row->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="mb-1">
                                                                    <a href="<?php echo e(Storage::url($f)); ?>" target="_blank"
                                                                        class="btn btn-sm btn-outline-secondary">
                                                                        <i class="fas fa-download"></i> <?php echo e(basename($f)); ?>

                                                                    </a>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                
                                                <td>
                                                    <?php if($row->jawaban): ?>
                                                        <div class="py-2">
                                                            <?php echo e($row->jawaban); ?>

                                                        </div>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>

                                                <!-- COLUMN: DETAIL -->
                                                <td class="bg-light text-center">
                                                    <div class="py-3">
                                                        <a href="<?php echo e(route('aeo.questions.documents', $row)); ?>"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>
                                                        <div class="mt-2">
                                                            <?php
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
                                                            ?>
                                                            <small class="text-muted">
                                                                <?php echo e($totalDocs); ?> documents<br>
                                                                (<?php echo e($masterDocs); ?> master documents)
                                                            </small>
                                                        </div>
                                                </td>

                                                <!-- COLUMN: INTERNAL AUDIT APPROVAL -->
                                                <td class="text-center">
                                                    <?php
                                                        $isInternalAudit = $userDept === 'internal_audit';
                                                    ?>

                                                    <?php if($row->internal_audit_approval === true): ?>
                                                        <div class="mb-2">
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-circle"></i> Approved
                                                            </span>
                                                            <br>
                                                            <small class="text-muted">
                                                                <?php echo e($row->internal_audit_approval_at ? $row->internal_audit_approval_at->format('d/m/Y H:i') : ''); ?>

                                                            </small>
                                                            <?php if($row->internalAuditApprovalBy): ?>
                                                                <br><small class="text-muted">by
                                                                    <?php echo e($row->internalAuditApprovalBy->name); ?></small>
                                                            <?php endif; ?>
                                                            <?php if($row->internal_audit_approval_notes): ?>
                                                                <br><small class="text-info"><i
                                                                        class="fas fa-sticky-note"></i>
                                                                    <?php echo e(Str::limit($row->internal_audit_approval_notes, 50)); ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php elseif($row->internal_audit_approval === false): ?>
                                                        <div class="mb-2">
                                                            <span class="badge bg-danger">
                                                                <i class="fas fa-times-circle"></i> Rejected
                                                            </span>
                                                            <br>
                                                            <small class="text-muted">
                                                                <?php echo e($row->internal_audit_approval_at ? $row->internal_audit_approval_at->format('d/m/Y H:i') : ''); ?>

                                                            </small>
                                                            <?php if($row->internalAuditApprovalBy): ?>
                                                                <br><small class="text-muted">by
                                                                    <?php echo e($row->internalAuditApprovalBy->name); ?></small>
                                                            <?php endif; ?>
                                                            <?php if($row->internal_audit_approval_notes): ?>
                                                                <br><small class="text-danger"><i
                                                                        class="fas fa-sticky-note"></i>
                                                                    <?php echo e(Str::limit($row->internal_audit_approval_notes, 50)); ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <?php if($isInternalAudit): ?>
                                                            <div class="btn-group-vertical gap-1">
                                                                <button type="button"
                                                                    class="btn btn-success btn-sm internal-audit-btn"
                                                                    data-question-id="<?php echo e($row->id); ?>"
                                                                    data-action="approve">
                                                                    <i class="fas fa-check"></i> Approve
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm internal-audit-btn"
                                                                    data-question-id="<?php echo e($row->id); ?>"
                                                                    data-action="reject">
                                                                    <i class="fas fa-times"></i> Reject
                                                                </button>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">
                                                                <i class="fas fa-clock"></i> Pending
                                                                <br><small class="text-muted">(Internal Audit only)</small>
                                                            </span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>

                                                <!-- COLUMN: FINAL VALIDASI BY AEO MGR -->
                                                <td class="text-center">
                                                    <?php
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
                                                        $canValidateAeoManager = in_array($userDept, ['AEO', 'admin']);
                                                    ?>

                                                    <?php if($hasValidatedDocs): ?>
                                                        <?php if($allValid): ?>
                                                            <span class="badge bg-success">Sesuai</span>
                                                            <?php if($canValidateAeoManager): ?>
                                                                <br>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary btn-sm mt-1 aeo-undo-all-btn"
                                                                    data-question-id="<?php echo e($row->id); ?>"
                                                                    title="Undo All AEO Manager Validations">
                                                                    <i class="fas fa-undo"></i> Undo All
                                                                </button>
                                                            <?php endif; ?>
                                                        <?php elseif($hasInvalid): ?>
                                                            <span class="badge bg-danger">Tidak Sesuai</span>
                                                            <?php if($canValidateAeoManager): ?>
                                                                <br>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary btn-sm mt-1 aeo-undo-all-btn"
                                                                    data-question-id="<?php echo e($row->id); ?>"
                                                                    title="Undo All AEO Manager Validations">
                                                                    <i class="fas fa-undo"></i> Undo All
                                                                </button>
                                                            <?php endif; ?>
                                                            <?php if($row->documents->where('aeo_manager_valid', false)->first()?->due_date): ?>
                                                                <br><small class="text-muted">Due:
                                                                    <?php echo e($row->documents->where('aeo_manager_valid', false)->first()->due_date); ?></small>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning">Partial</span>
                                                            <?php if($canValidateAeoManager): ?>
                                                                <br>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary btn-sm mt-1 aeo-undo-all-btn"
                                                                    data-question-id="<?php echo e($row->id); ?>"
                                                                    title="Undo All AEO Manager Validations">
                                                                    <i class="fas fa-undo"></i> Undo All
                                                                </button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php if($canValidateAeoManager): ?>
                                                            <div class="btn-group-vertical gap-1">
                                                                <button type="button"
                                                                    class="btn btn-success btn-sm aeo-validation-btn"
                                                                    data-question-id="<?php echo e($row->id); ?>"
                                                                    data-status="sesuai">
                                                                    <i class="fas fa-check"></i> Sesuai
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm aeo-validation-btn"
                                                                    data-question-id="<?php echo e($row->id); ?>"
                                                                    data-status="tidak_sesuai" data-bs-toggle="modal"
                                                                    data-bs-target="#aeoValidationModal">
                                                                    <i class="fas fa-times"></i> Tidak Sesuai
                                                                </button>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">
                                                                <i class="fas fa-lock"></i> AEO Access Only
                                                            </span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>

                                                <!-- COLUMN: APPROVAL -->
                                                <td class="text-center">
                                                    <div class="btn-group-vertical gap-1">
                                                        <?php if($row->approval_1 === true): ?>
                                                            <div class="mb-2">
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-check"></i> Approval 1 ✓
                                                                </span>
                                                                <br>
                                                                <small class="text-muted">
                                                                    <?php echo e($row->approval_1_at ? $row->approval_1_at->format('d/m/Y H:i') : ''); ?>

                                                                </small>
                                                                <?php if($row->approval1By): ?>
                                                                    <br><small class="text-muted">by
                                                                        <?php echo e($row->approval1By->name); ?></small>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php else: ?>
                                                            <?php if($canApprove): ?>
                                                                <button type="button"
                                                                    class="btn btn-primary btn-sm approval-btn"
                                                                    data-question-id="<?php echo e($row->id); ?>"
                                                                    data-approval-type="1">
                                                                    <i class="fas fa-check"></i> Approval 1
                                                                </button>
                                                            <?php else: ?>
                                                                <span class="badge bg-secondary">
                                                                    <i class="fas fa-clock"></i> Pending Approval 1
                                                                    <?php if($userDept === 'AEO'): ?>
                                                                        <br><small class="text-muted">(Admin only)</small>
                                                                    <?php endif; ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if($row->approval_2 === true): ?>
                                                            <div class="mb-2">
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-check-double"></i> Approval 2 ✓
                                                                </span>
                                                                <br>
                                                                <small class="text-muted">
                                                                    <?php echo e($row->approval_2_at ? $row->approval_2_at->format('d/m/Y H:i') : ''); ?>

                                                                </small>
                                                                <?php if($row->approval2By): ?>
                                                                    <br><small class="text-muted">by
                                                                        <?php echo e($row->approval2By->name); ?></small>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php elseif($row->approval_1 === true): ?>
                                                            <?php if($canApprove): ?>
                                                                <button type="button"
                                                                    class="btn btn-success btn-sm approval-btn"
                                                                    data-question-id="<?php echo e($row->id); ?>"
                                                                    data-approval-type="2">
                                                                    <i class="fas fa-check-double"></i> Approval 2
                                                                </button>
                                                            <?php else: ?>
                                                                <span class="badge bg-secondary">
                                                                    <i class="fas fa-clock"></i> Pending Approval 2
                                                                    <?php if($userDept === 'AEO'): ?>
                                                                        <br><small class="text-muted">(Admin only)</small>
                                                                    <?php endif; ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <?php if($canApprove): ?>
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    disabled title="Complete Approval 1 first">
                                                                    <i class="fas fa-check-double"></i> Approval 2
                                                                </button>
                                                            <?php else: ?>
                                                                <span class="badge bg-light text-muted">
                                                                    <i class="fas fa-minus"></i> Awaiting Approval 1
                                                                    <?php if($userDept === 'AEO'): ?>
                                                                        <br><small class="text-muted">(Admin only)</small>
                                                                    <?php endif; ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>

                                                <!-- COLUMN: AKSI -->
                                                <td class="text-center">
                                                    <?php
                                                        // AEO and admin can edit/delete any question
                                                        // Other users can only edit/delete questions from their department
                                                        $canEditDelete = $isAeoOrAdmin || $row->dept === $userDept;
                                                    ?>

                                                    <div class="btn-group-vertical" role="group">
                                                        <?php if($canEditDelete): ?>
                                                            <a href="<?php echo e(route('aeo.questions.edit', $row)); ?>"
                                                                class="btn btn-sm btn-warning" title="Edit Question">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <form action="<?php echo e(route('aeo.questions.destroy', $row)); ?>"
                                                                method="POST" class="d-inline">
                                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                                <button type="submit"
                                                                    onclick="return confirm('Delete this question and all related documents?')"
                                                                    class="btn btn-sm btn-danger" title="Delete Question">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        <?php else: ?>
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                disabled
                                                                title="You can only edit/delete questions from your department">
                                                                <i class="fas fa-lock"></i> Locked
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                    <?php if($isAeoOrAdmin): ?>
                                                        No questions found in the system.
                                                    <?php else: ?>
                                                        No questions found for your department (<?php echo e($userDept); ?>).
                                                    <?php endif; ?>
                                                    <br>
                                                    <a href="<?php echo e(route('aeo.questions.create')); ?>"
                                                        class="btn btn-primary mt-2">
                                                        <i class="fas fa-plus"></i> Add your first question
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
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
                    <?php echo csrf_field(); ?>
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
                                min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" required>
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
                    <?php echo csrf_field(); ?>
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

    <!-- Internal Audit Approval Modal -->
    <div class="modal fade" id="internalAuditModal" tabindex="-1" aria-labelledby="internalAuditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="internalAuditModalLabel">
                        <i class="fas fa-clipboard-check text-primary"></i>
                        Internal Audit Approval
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="internalAuditForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" id="internalAuditQuestionId" name="question_id">
                        <input type="hidden" id="internalAuditAction" name="action">

                        <div class="alert" id="internalAuditAlert">
                            <i class="fas fa-info-circle"></i>
                            <span id="internalAuditMessage">You are about to process this internal audit approval.</span>
                        </div>

                        <div class="mb-3">
                            <label for="internalAuditNotes" class="form-label">
                                <i class="fas fa-sticky-note"></i> Notes (Optional)
                            </label>
                            <textarea class="form-control" id="internalAuditNotes" name="notes" rows="3"
                                placeholder="Add any notes for this internal audit decision..."></textarea>
                            <div class="form-text">You can add optional notes to document the internal audit decision.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn" id="internalAuditSubmitBtn">
                            <i class="fas fa-check"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Department Filter Styling */
        #deptFilter {
            border: 2px solid #0d6efd;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #deptFilter:hover {
            border-color: #0a58ca;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        #deptFilter:focus {
            border-color: #0a58ca;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

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
            font-size: 0.8rem !important;
            padding: 0.35em 0.6em;
        }

        .btn-group-sm .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
                "responsive": true,

                // Page length options
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "pageLength": 25,

                // Default ordering
                "order": [
                    [0, 'asc']
                ], // Sort by No column

                // Column definitions
                "columnDefs": [{
                        "targets": 0, // No column
                        "width": "50px",
                        "className": "text-center",
                        "orderable": true
                    },
                    {
                        "targets": 1, // Dept column
                        "width": "80px",
                        "className": "text-center",
                        "orderable": true
                    },
                    {
                        "targets": [5, 6, 7, 8,
                        9], // Detail, Internal Audit, Validasi, Approval, Aksi columns
                        "orderable": false
                    }
                ],

                // Bootstrap 5 styling
                "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                    '<"row"<"col-sm-12 col-md-6"B>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',

                // Export buttons
                "buttons": [{
                        extend: 'copy',
                        className: 'btn btn-secondary btn-sm',
                        text: '<i class="fas fa-copy"></i> Salin',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Export relevant columns
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success btn-sm',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        title: 'AEO Questions - <?php echo e(now()->format('d-m-Y')); ?>'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger btn-sm',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'AEO Questions',
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 9;
                            doc.styles.tableHeader.fontSize = 10;
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-info btn-sm',
                        text: '<i class="fas fa-print"></i> Cetak',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        title: 'AEO Questions',
                        customize: function(win) {
                            $(win.document.body).css('font-size', '10pt');
                            $(win.document.body).find('table').addClass('compact').css('font-size',
                                '10pt');
                        }
                    }
                ]
            });

            // Handle department filter change
            $('#deptFilter').on('change', function() {
                const selectedDept = $(this).val();
                const currentUrl = new URL(window.location.href);

                if (selectedDept === 'all') {
                    currentUrl.searchParams.delete('dept');
                } else {
                    currentUrl.searchParams.set('dept', selectedDept);
                }

                window.location.href = currentUrl.toString();
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
                const route = `<?php echo e(route('aeo.questions.aeo-manager-validation', ':id')); ?>`.replace(':id',
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

            // Handle Internal Audit Approval buttons
            $('.internal-audit-btn').on('click', function() {
                const button = $(this);
                const questionId = button.data('question-id');
                const action = button.data('action');

                // Set modal data
                $('#internalAuditQuestionId').val(questionId);
                $('#internalAuditAction').val(action);

                // Update modal styling and text based on action
                const alertDiv = $('#internalAuditAlert');
                const submitBtn = $('#internalAuditSubmitBtn');

                if (action === 'approve') {
                    alertDiv.removeClass('alert-danger').addClass('alert-success');
                    $('#internalAuditMessage').text(
                        'You are about to approve this question for internal audit.');
                    submitBtn.removeClass('btn-danger').addClass('btn-success').html(
                        '<i class="fas fa-check"></i> Approve');
                } else {
                    alertDiv.removeClass('alert-success').addClass('alert-danger');
                    $('#internalAuditMessage').text(
                        'You are about to reject this question for internal audit.');
                    submitBtn.removeClass('btn-success').addClass('btn-danger').html(
                        '<i class="fas fa-times"></i> Reject');
                }

                // Show modal
                $('#internalAuditModal').modal('show');
            });

            // Handle Internal Audit Form submission
            $('#internalAuditForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const questionId = $('#internalAuditQuestionId').val();
                const action = $('#internalAuditAction').val();
                const notes = $('#internalAuditNotes').val().trim();

                // Show loading state
                $('#internalAuditSubmitBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Processing...');

                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                fetch(`/aeo/questions/${questionId}/internal-audit-approval`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            action: action,
                            notes: notes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message, 'success');

                            // Hide modal
                            $('#internalAuditModal').modal('hide');

                            // Refresh the page to show updated status
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showToast(data.message || `Error processing Internal Audit ${action}`,
                                'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast(`Error processing Internal Audit ${action}`, 'error');
                    })
                    .finally(() => {
                        // Re-enable button
                        const action = $('#internalAuditAction').val();
                        const icon = action === 'approve' ? 'check' : 'times';
                        const text = action === 'approve' ? 'Approve' : 'Reject';
                        $('#internalAuditSubmitBtn').prop('disabled', false).html(
                            `<i class="fas fa-${icon}"></i> ${text}`);
                    });
            });

            // Reset internal audit modal when closed
            $('#internalAuditModal').on('hidden.bs.modal', function() {
                $('#internalAuditForm')[0].reset();
                $('#internalAuditQuestionId').val('');
                $('#internalAuditAction').val('');
                $('#internalAuditNotes').val('');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\aeo-docs\resources\views/aeo/questions/index.blade.php ENDPATH**/ ?>