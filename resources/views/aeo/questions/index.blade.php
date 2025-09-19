@extends('layouts.app')
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
                                    @forelse ($rows as $index => $row)
                                        <tr class="align-top">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <strong class="text-primary">{{ $row->subcriteria }}</strong>
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
                                                                    class="btn btn-xs btn-outline-secondary">
                                                                    <i class="fas fa-download"></i> {{ basename($f) }}
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Add Document Button -->
                                                <div class="mb-2">
                                                    <button class="btn btn-sm btn-success" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#addDoc{{ $row->id }}">
                                                        <i class="fas fa-plus"></i> Add Document
                                                    </button>
                                                </div>

                                                <!-- Add Document Form (Collapsed) -->
                                                <div class="collapse" id="addDoc{{ $row->id }}">
                                                    <div class="card card-body mb-3 bg-light">
                                                        <form action="{{ route('aeo.documents.store') }}" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="aeo_question_id"
                                                                value="{{ $row->id }}">

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
                                                                    data-bs-target="#addDoc{{ $row->id }}">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <!-- Existing Documents -->
                                                @if ($row->documents && count($row->documents) > 0)
                                                    @foreach ($row->documents as $doc)
                                                        <div class="border rounded p-2 mb-2 bg-white">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div class="flex-grow-1">
                                                                    <strong
                                                                        class="d-block text-primary">{{ $doc->nama_dokumen }}</strong>
                                                                    @if ($doc->no_sop_wi_std_form_other)
                                                                        <small class="text-muted d-block">No:
                                                                            {{ $doc->no_sop_wi_std_form_other }}</small>
                                                                    @endif

                                                                    @if ($doc->files && count($doc->files) > 0)
                                                                        <div class="mt-2">
                                                                            @foreach ($doc->files as $f)
                                                                                <a href="{{ Storage::url($f) }}"
                                                                                    target="_blank"
                                                                                    class="btn btn-xs btn-outline-info me-1 mb-1">
                                                                                    <i class="fas fa-download"></i>
                                                                                    {{ basename($f) }}
                                                                                </a>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <div class="ms-2">
                                                                    <div class="btn-group-vertical" role="group">
                                                                        <a href="{{ route('aeo.documents.edit', $doc) }}"
                                                                            class="btn btn-xs btn-warning"
                                                                            title="Edit Document">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('aeo.documents.destroy', $doc) }}"
                                                                            method="POST" class="d-inline">
                                                                            @csrf @method('DELETE')
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
                                                    @endforeach
                                                @else
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox"></i> No documents yet
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->keterangan)
                                                    <div class="alert alert-info py-2">
                                                        {{ $row->keterangan }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">No recommendations yet</span>
                                                @endif
                                            </td>
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
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
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

                        @if ($rows->hasPages())
                            <div class="mt-3">
                                {{ $rows->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
