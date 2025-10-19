
<?php $__env->startSection('content'); ?>
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
                        <form method="POST" action="<?php echo e(route('aeo.documents.update', $document)); ?>"
                            enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="mb-3">
                                <label for="aeo_question_id" class="form-label">Question <span
                                        class="text-danger">*</span></label>
                                <select name="aeo_question_id" id="aeo_question_id"
                                    class="form-select <?php $__errorArgs = ['aeo_question_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">-- Pilih Question --</option>
                                    <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($qs->id); ?>"
                                            <?php echo e(old('aeo_question_id', $document->aeo_question_id) == $qs->id ? 'selected' : ''); ?>>
                                            [<?php echo e($qs->subcriteria); ?>] <?php echo e(Str::limit($qs->question, 80)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['aeo_question_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label for="document_type" class="form-label">Document Type <span
                                        class="text-danger">*</span></label>
                                <select name="document_type" id="document_type"
                                    class="form-select <?php $__errorArgs = ['document_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">-- Select Document Type --</option>
                                    <option value="master"
                                        <?php echo e(old('document_type', $document->document_type) == 'master' ? 'selected' : ''); ?>>
                                        Master Document
                                    </option>
                                    <option value="new"
                                        <?php echo e(old('document_type', $document->document_type) == 'new' ? 'selected' : ''); ?>>
                                        New Document
                                    </option>
                                </select>
                                <?php $__errorArgs = ['document_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label for="dept" class="form-label">Department <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['dept'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="dept" name="dept"
                                    value="<?php echo e(old('dept', $document->dept ?? (auth()->user()->dept ?? 'GENERAL'))); ?>"
                                    required>
                                <div class="form-text">Department information for this document.</div>
                                <?php $__errorArgs = ['dept'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label for="nama_dokumen" class="form-label">Nama Dokumen <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['nama_dokumen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="nama_dokumen" name="nama_dokumen"
                                    value="<?php echo e(old('nama_dokumen', $document->nama_dokumen)); ?>" required>
                                <?php $__errorArgs = ['nama_dokumen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label for="no_sop_wi_std_form_other" class="form-label">No SOP/WI/STD/Form/Other</label>
                                <input type="text"
                                    class="form-control <?php $__errorArgs = ['no_sop_wi_std_form_other'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="no_sop_wi_std_form_other" name="no_sop_wi_std_form_other"
                                    value="<?php echo e(old('no_sop_wi_std_form_other', $document->no_sop_wi_std_form_other)); ?>">
                                <?php $__errorArgs = ['no_sop_wi_std_form_other'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">File Management</label>

                                <?php if($document->files && count($document->files) > 0): ?>
                                    <div class="mb-3">
                                        <h6>Existing Files:</h6>
                                        <div class="list-group list-group-flush">
                                            <?php $__currentLoopData = $document->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="keep_files[]"
                                                            value="<?php echo e($index); ?>" id="keep_file_<?php echo e($index); ?>"
                                                            checked>
                                                        <label class="form-check-label"
                                                            for="keep_file_<?php echo e($index); ?>">
                                                            <i class="fas fa-file"></i> <?php echo e(basename($f)); ?>

                                                        </label>
                                                    </div>
                                                    <div class="btn-group" role="group">
                                                        <a href="<?php echo e(Storage::url($f)); ?>" target="_blank"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i>
                                            Uncheck files you want to remove. Checked files will be kept.
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label for="files" class="form-label">
                                        <?php echo e($document->files && count($document->files) > 0 ? 'Add New Files' : 'Upload Files'); ?>

                                    </label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['files.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="files" name="files[]" multiple>
                                    <div class="form-text">You can select multiple files. Maximum size: 10MB per file.</div>
                                    <?php $__errorArgs = ['files.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <?php if($document->files && count($document->files) > 0): ?>
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
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="rekomendasi" class="form-label">Rekomendasi</label>
                                <textarea class="form-control <?php $__errorArgs = ['rekomendasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="rekomendasi" name="rekomendasi"
                                    rows="3" placeholder="Enter recommendations..."><?php echo e(old('rekomendasi', $document->rekomendasi)); ?></textarea>
                                <?php $__errorArgs = ['rekomendasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control <?php $__errorArgs = ['due_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="due_date" name="due_date"
                                    value="<?php echo e(old('due_date', $document->due_date?->format('Y-m-d'))); ?>">
                                <?php $__errorArgs = ['due_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status"
                                    class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="draft"
                                        <?php echo e(old('status', $document->status) == 'draft' ? 'selected' : ''); ?>>
                                        Draft
                                    </option>
                                    <option value="in_review"
                                        <?php echo e(old('status', $document->status) == 'in_review' ? 'selected' : ''); ?>>
                                        In Review
                                    </option>
                                    <option value="approved"
                                        <?php echo e(old('status', $document->status) == 'approved' ? 'selected' : ''); ?>>
                                        Approved
                                    </option>
                                    <option value="rejected"
                                        <?php echo e(old('status', $document->status) == 'rejected' ? 'selected' : ''); ?>>
                                        Rejected
                                    </option>
                                    <option value="pending"
                                        <?php echo e(old('status', $document->status) == 'pending' ? 'selected' : ''); ?>>
                                        Pending
                                    </option>
                                </select>
                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="<?php echo e(route('aeo.questions.index')); ?>" class="btn btn-secondary me-md-2">
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\aeo-docs\resources\views/aeo/documents/edit.blade.php ENDPATH**/ ?>