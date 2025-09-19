@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-file-alt"></i> Dokumen AEO (Dept: {{ auth()->user()->dept }})
                        </h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('aeo.documents.import.form') }}" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Import Excel
                            </a>
                            <a href="{{ route('aeo.documents.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Upload Dokumen
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <form method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" name="search" value="{{ request('search') }}"
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
                                    @forelse ($documents as $doc)
                                        <tr>
                                            <td>{{ $doc->question->subcriteria }}</td>
                                            <td style="max-width:320px">{{ $doc->question->question }}</td>
                                            <td>{{ $doc->nama_dokumen }}</td>
                                            <td>{{ $doc->no_sop_wi_std_form_other }}</td>
                                            <td>
                                                @if ($doc->files && count($doc->files) > 0)
                                                    @foreach ($doc->files ?? [] as $f)
                                                        <div class="mb-1">
                                                            <a href="{{ Storage::url($f) }}" target="_blank"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download"></i> {{ basename($f) }}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">No files</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('aeo.documents.edit', $doc) }}"
                                                        class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('aeo.documents.destroy', $doc) }}"
                                                        method="POST" style="display:inline-block">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Yakin ingin menghapus dokumen ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                Belum ada dokumen yang diupload
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
@endsection
