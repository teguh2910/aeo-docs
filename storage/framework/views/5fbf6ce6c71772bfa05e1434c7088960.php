
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-file-excel"></i> Import Dokumen AEO dari Excel
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Instruksi Import:</h6>
                            <ol class="mb-0">
                                <li>Download template CSV terlebih dahulu</li>
                                <li>Isi data dokumen sesuai format template</li>
                                <li>Buka file CSV dengan Excel atau spreadsheet editor</li>
                                <li>Simpan sebagai file Excel (.xlsx) jika diperlukan</li>
                                <li>Upload file Excel/CSV yang telah diisi</li>
                                <li>Sistem akan memvalidasi dan mengimport data</li>
                            </ol>
                        </div>

                        <div class="mb-4">
                            <a href="<?php echo e(route('aeo.documents.download.template')); ?>" class="btn btn-success">
                                <i class="fas fa-download"></i> Download Template CSV
                            </a>
                        </div>

                        <form method="POST" action="<?php echo e(route('aeo.documents.import')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <div class="mb-3">
                                <label for="excel_file" class="form-label">File Excel <span
                                        class="text-danger">*</span></label>
                                <input type="file" name="excel_file" id="excel_file"
                                    class="form-control <?php $__errorArgs = ['excel_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept=".xlsx,.xls,.csv"
                                    required>
                                <div class="form-text">
                                    Format yang didukung: .xlsx, .xls, .csv (Max: 10MB)
                                </div>
                                <?php $__errorArgs = ['excel_file'];
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

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Import Data
                                </button>
                                <a href="<?php echo e(route('aeo.questions.index')); ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-table"></i> Format Data Excel</h6>
                    </div>
                    <div class="card-body">
                        <p>Template Excel harus berisi kolom-kolom berikut:</p>
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Kolom</th>
                                    <th>Wajib</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>subcriteria</code></td>
                                    <td><span class="badge bg-danger">Ya</span></td>
                                    <td>Kode subcriteria dari tabel questions</td>
                                </tr>
                                <tr>
                                    <td><code>question</code></td>
                                    <td><span class="badge bg-warning">Opsional</span></td>
                                    <td>Teks pertanyaan (untuk referensi)</td>
                                </tr>
                                <tr>
                                    <td><code>dept</code></td>
                                    <td><span class="badge bg-warning">Opsional</span></td>
                                    <td>Departemen (jika kosong akan menggunakan dept user)</td>
                                </tr>
                                <tr>
                                    <td><code>nama_dokumen</code></td>
                                    <td><span class="badge bg-danger">Ya</span></td>
                                    <td>Nama dokumen</td>
                                </tr>
                                <tr>
                                    <td><code>no_sop_wi_std_form_other</code></td>
                                    <td><span class="badge bg-warning">Opsional</span></td>
                                    <td>Nomor SOP/WI/STD/Form/Other</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\aeo-docs\resources\views/aeo/documents/import.blade.php ENDPATH**/ ?>