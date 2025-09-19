
<?php $__env->startSection('content'); ?>
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
                                <a href="<?php echo e(route('aeo.questions.import.form')); ?>" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i> Import Excel
                                </a>
                                <a href="<?php echo e(route('aeo.questions.create')); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Question
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;" class="text-center">#</th>
                                        <th style="width: 200px;">SUB KRITERIA AEO</th>
                                        <th style="width: 350px;">PERTANYAAN</th>
                                        <th style="width: 400px;">DOCUMENTS</th>
                                        <th style="width: 250px;">REKOMENDASI</th>
                                        <th style="width: 120px;" class="text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="align-top">
                                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                            <td>
                                                <strong class="text-primary"><?php echo e($row->subcriteria); ?></strong>
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
                                                                    class="btn btn-xs btn-outline-secondary">
                                                                    <i class="fas fa-download"></i> <?php echo e(basename($f)); ?>

                                                                </a>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <!-- Add Document Button -->
                                                <div class="mb-2">
                                                    <button class="btn btn-sm btn-success" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#addDoc<?php echo e($row->id); ?>">
                                                        <i class="fas fa-plus"></i> Add Document
                                                    </button>
                                                </div>

                                                <!-- Add Document Form (Collapsed) -->
                                                <div class="collapse" id="addDoc<?php echo e($row->id); ?>">
                                                    <div class="card card-body mb-3 bg-light">
                                                        <form action="<?php echo e(route('aeo.documents.store')); ?>" method="POST"
                                                            enctype="multipart/form-data">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="aeo_question_id"
                                                                value="<?php echo e($row->id); ?>">

                                                            <div class="mb-2">
                                                                <input type="text" name="nama_dokumen"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="Document Name" required>
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
                                                                    data-bs-target="#addDoc<?php echo e($row->id); ?>">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <!-- Existing Documents -->
                                                <?php if($row->documents && count($row->documents) > 0): ?>
                                                    <?php $__currentLoopData = $row->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="border rounded p-2 mb-2 bg-white">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div class="flex-grow-1">
                                                                    <strong
                                                                        class="d-block text-primary"><?php echo e($doc->nama_dokumen); ?></strong>
                                                                    <?php if($doc->no_sop_wi_std_form_other): ?>
                                                                        <small class="text-muted d-block">No:
                                                                            <?php echo e($doc->no_sop_wi_std_form_other); ?></small>
                                                                    <?php endif; ?>

                                                                    <?php if($doc->files && count($doc->files) > 0): ?>
                                                                        <div class="mt-2">
                                                                            <?php $__currentLoopData = $doc->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <a href="<?php echo e(Storage::url($f)); ?>"
                                                                                    target="_blank"
                                                                                    class="btn btn-xs btn-outline-info me-1 mb-1">
                                                                                    <i class="fas fa-download"></i>
                                                                                    <?php echo e(basename($f)); ?>

                                                                                </a>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>

                                                                <div class="ms-2">
                                                                    <div class="btn-group-vertical" role="group">
                                                                        <a href="<?php echo e(route('aeo.documents.edit', $doc)); ?>"
                                                                            class="btn btn-xs btn-warning"
                                                                            title="Edit Document">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <form
                                                                            action="<?php echo e(route('aeo.documents.destroy', $doc)); ?>"
                                                                            method="POST" class="d-inline">
                                                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                                            <button type="submit"
                                                                                class="btn btn-xs btn-danger"
                                                                                onclick="return confirm('Delete this document?')"
                                                                                title="Delete Document">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox"></i> No documents yet
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($row->keterangan): ?>
                                                    <div class="alert alert-info py-2">
                                                        <?php echo e($row->keterangan); ?>

                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">No recommendations yet</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group-vertical" role="group">
                                                    <a href="<?php echo e(route('aeo.questions.edit', $row)); ?>"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="<?php echo e(route('aeo.questions.destroy', $row)); ?>"
                                                        method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        <button type="submit"
                                                            onclick="return confirm('Delete this question and all related documents?')"
                                                            class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                    No questions found. <a href="<?php echo e(route('aeo.questions.create')); ?>">Add
                                                        your first question</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if($rows->hasPages()): ?>
                            <div class="mt-3">
                                <?php echo e($rows->links()); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\aeo-docs\resources\views/aeo/questions/index.blade.php ENDPATH**/ ?>