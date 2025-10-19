
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-file-alt"></i> Dokumen AEO (Dept: <?php echo e(auth()->user()->dept); ?>)
                        </h4>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('aeo.documents.import.form')); ?>" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Import Excel
                            </a>
                            <a href="<?php echo e(route('aeo.documents.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Upload Dokumen
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <form method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                        class="form-control" placeholder="Cari nama dokumen / no SOP">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Documents Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Subcriteria</th>
                                        <th>Question</th>
                                        <th>Nama Dokumen</th>
                                        <th>No SOP/WI/STD/Form/Other</th>
                                        <th>Files</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($doc->question->subcriteria); ?></td>
                                            <td style="max-width:320px"><?php echo e($doc->question->question); ?></td>
                                            <td><?php echo e($doc->nama_dokumen); ?></td>
                                            <td><?php echo e($doc->no_sop_wi_std_form_other); ?></td>
                                            <td>
                                                <?php if($doc->files && count($doc->files) > 0): ?>
                                                    <?php $__currentLoopData = $doc->files ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="mb-1">
                                                            <a href="<?php echo e(Storage::url($f)); ?>" target="_blank"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download"></i> <?php echo e(basename($f)); ?>

                                                            </a>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No files</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('aeo.documents.edit', $doc)); ?>"
                                                        class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="<?php echo e(route('aeo.documents.destroy', $doc)); ?>"
                                                        method="POST" style="display:inline-block">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Yakin ingin menghapus dokumen ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                Belum ada dokumen yang diupload
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\aeo-docs\resources\views/aeo/documents/index.blade.php ENDPATH**/ ?>