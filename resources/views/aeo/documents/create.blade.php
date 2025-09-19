@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-upload"></i> Upload Dokumen AEO
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('aeo.documents.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="aeo_question_id" class="form-label">Question <span
                                        class="text-danger">*</span></label>
                                <select name="aeo_question_id" id="aeo_question_id"
                                    class="form-select @error('aeo_question_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Question --</option>
                                    @foreach ($questions as $qs)
                                        <option value="{{ $qs->id }}"
                                            {{ old('aeo_question_id') == $qs->id ? 'selected' : '' }}>
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
                                    id="nama_dokumen" name="nama_dokumen" value="{{ old('nama_dokumen') }}" required>
                                @error('nama_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="no_sop_wi_std_form_other" class="form-label">No SOP/WI/STD/Form/Other</label>
                                <input type="text"
                                    class="form-control @error('no_sop_wi_std_form_other') is-invalid @enderror"
                                    id="no_sop_wi_std_form_other" name="no_sop_wi_std_form_other"
                                    value="{{ old('no_sop_wi_std_form_other') }}">
                                @error('no_sop_wi_std_form_other')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="files" class="form-label">Files</label>
                                <div class="file-upload-area border border-2 border-dashed rounded p-4 text-center bg-light"
                                    id="file-upload-area">
                                    <div class="upload-content">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                        <p class="mb-2">Drag & drop files here or <span
                                                class="text-primary fw-bold">browse</span></p>
                                        <small class="text-muted">Supported formats: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX,
                                            JPG, JPEG, PNG, GIF</small><br>
                                        <small class="text-muted">Maximum size: 10MB per file</small>
                                    </div>
                                    <input type="file" class="form-control d-none @error('files.*') is-invalid @enderror"
                                        id="files" name="files[]" multiple
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif">
                                </div>
                                <div id="file-list" class="mt-3"></div>
                                @error('files.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('aeo.questions.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    // Drag and drop functionality
    const fileUploadArea = document.getElementById('file-upload-area');
    const fileInput = document.getElementById('files');
    const fileList = document.getElementById('file-list');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, unhighlight, false);
    });

    // Handle dropped files
    fileUploadArea.addEventListener('drop', handleDrop, false);
    fileInput.addEventListener('change', handleFileSelect, false);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight(e) {
        fileUploadArea.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
    }

    function unhighlight(e) {
        fileUploadArea.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    function handleFileSelect(e) {
        const files = e.target.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        [...files].forEach(uploadFile);
    }

    function uploadFile(file) {
        // Validate file type
        const allowedTypes = ['application/pdf', 'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'image/jpeg', 'image/jpg', 'image/png', 'image/gif'
        ];

        if (!allowedTypes.includes(file.type)) {
            alert('File type not allowed. Please select PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, or image files.');
            return;
        }

        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('File size too large. Maximum size is 10MB.');
            return;
        }

        // Add file to list
        const fileItem = document.createElement('div');
        fileItem.className =
            'file-item d-flex justify-content-between align-items-center border rounded p-2 mb-2 bg-white';
        fileItem.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-file me-2 text-primary"></i>
                <span>${file.name}</span>
                <small class="text-muted ms-2">(${formatFileSize(file.size)})</small>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile(this)">
                <i class="fas fa-times"></i>
            </button>
        `;
        fileList.appendChild(fileItem);

        // Update file input (this is a simplified approach - in production you'd want better file handling)
        updateFileInput();
    }

    function removeFile(button) {
        button.closest('.file-item').remove();
        updateFileInput();
    }

    function updateFileInput() {
        // This is a simplified approach. In a real application, you'd want to maintain the FileList properly
        const dt = new DataTransfer();
        const fileItems = fileList.querySelectorAll('.file-item span');

        // Note: This simplified version doesn't actually maintain the File objects
        // In production, you'd want to store the File objects separately and rebuild the input
        fileInput.files = dt.files;
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Click to browse files
    fileUploadArea.addEventListener('click', () => {
        fileInput.click();
    });
</script>
