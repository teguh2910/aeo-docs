@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-plus"></i> Tambah Pertanyaan AEO
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('aeo.questions.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="subcriteria" class="form-label">Subcriteria <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('subcriteria') is-invalid @enderror"
                                    id="subcriteria" name="subcriteria" value="{{ old('subcriteria') }}" required>
                                @error('subcriteria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('question') is-invalid @enderror" id="question" name="question" rows="4"
                                    required>{{ old('question') }}</textarea>
                                @error('question')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                    rows="3">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="files" class="form-label">Files</label>
                                <input type="file" class="form-control @error('files.*') is-invalid @enderror"
                                    id="files" name="files[]" multiple>
                                <div class="form-text">You can select multiple files. Maximum size: 10MB per file.</div>
                                @error('files.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
