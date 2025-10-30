@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-tachometer-alt text-primary"></i> Dashboard Overview
                </h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-building"></i> {{ $userDept }}
                    @if ($isAeoOrAdmin || $isInternalAudit || $isManagement)
                        <span class="badge bg-info ms-2">All Departments</span>
                    @else
                        <span class="badge bg-secondary ms-2">Department View</span>
                    @endif
                </p>
            </div>
            <div>
                <a href="{{ route('aeo.questions.index') }}" class="btn btn-primary">
                    <i class="fas fa-list"></i> View All Questions
                </a>
            </div>
        </div>

        <!-- Questions Statistics -->
        <!-- Main Summary Cards -->
        <div class="row mb-4">
            <!-- Summary: Internal Auditor -->
            <div class="col-xl-3 col-lg-6 mb-4">
                <div class="card border-0 shadow-lg h-100">
                    <div class="card-header bg-gradient-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-search"></i> Internal Auditor Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Total Questions</span>
                                <h4 class="mb-0 text-primary">{{ $totalQuestions }}</h4>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-clock text-warning"></i> Pending</span>
                                <span class="badge bg-warning text-dark fs-6">{{ $pendingInternalAudit }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-warning"
                                    style="width: {{ $totalQuestions > 0 ? ($pendingInternalAudit / $totalQuestions) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-check-circle text-success"></i> Approved</span>
                                <span class="badge bg-success fs-6">{{ $completedInternalAudit }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-success"
                                    style="width: {{ $totalQuestions > 0 ? ($completedInternalAudit / $totalQuestions) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-times-circle text-danger"></i> Rejected</span>
                                <span class="badge bg-danger fs-6">{{ $rejectedInternalAudit }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-danger"
                                    style="width: {{ $totalQuestions > 0 ? ($rejectedInternalAudit / $totalQuestions) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary: AEO Manager Validation -->
            <div class="col-xl-3 col-lg-6 mb-4">
                <div class="card border-0 shadow-lg h-100">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-shield"></i> AEO Mgr Validation
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Total Questions</span>
                                <h4 class="mb-0 text-primary">{{ $totalQuestions }}</h4>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-clock text-warning"></i> Pending Validation</span>
                                <span class="badge bg-warning text-dark fs-6">{{ $pendingAeoManagerQuestions }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-warning"
                                    style="width: {{ $totalQuestions > 0 ? ($pendingAeoManagerQuestions / $totalQuestions) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-check-circle text-success"></i> Validated</span>
                                <span class="badge bg-success fs-6">{{ $completedAeoManagerQuestions }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-success"
                                    style="width: {{ $totalQuestions > 0 ? ($completedAeoManagerQuestions / $totalQuestions) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="text-center pt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Based on document validation status
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary: Approval 1 -->
            <div class="col-xl-3 col-lg-6 mb-4">
                <div class="card border-0 shadow-lg h-100">
                    <div class="card-header bg-gradient-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-check"></i> Approval 1 Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Total Questions</span>
                                <h4 class="mb-0 text-primary">{{ $totalQuestions }}</h4>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-clock text-warning"></i> Pending Approval</span>
                                <span class="badge bg-warning text-dark fs-6">{{ $pendingApproval1 }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-warning"
                                    style="width: {{ $totalQuestions > 0 ? ($pendingApproval1 / $totalQuestions) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-check-circle text-success"></i> Approved</span>
                                <span class="badge bg-success fs-6">{{ $completedApproval1 }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-success"
                                    style="width: {{ $totalQuestions > 0 ? ($completedApproval1 / $totalQuestions) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="text-center pt-3">
                            <small class="text-muted">
                                <i class="fas fa-user"></i> Management 1 / Admin
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary: Approval 2 -->
            <div class="col-xl-3 col-lg-6 mb-4">
                <div class="card border-0 shadow-lg h-100">
                    <div class="card-header bg-gradient-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-check-double"></i> Approval 2 Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Total Questions</span>
                                <h4 class="mb-0 text-primary">{{ $totalQuestions }}</h4>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-clock text-warning"></i> Pending Approval</span>
                                <span class="badge bg-warning text-dark fs-6">{{ $pendingApproval2 }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-warning"
                                    style="width: {{ $totalQuestions > 0 ? ($pendingApproval2 / $totalQuestions) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-check-circle text-success"></i> Approved</span>
                                <span class="badge bg-success fs-6">{{ $completedApproval2 }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-success"
                                    style="width: {{ $totalQuestions > 0 ? ($completedApproval2 / $totalQuestions) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="text-center pt-3">
                            <small class="text-muted">
                                <i class="fas fa-user"></i> Management 2 / Admin
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('aeo.questions.index') }}" class="btn btn-outline-primary btn-block">
                                    <i class="fas fa-list"></i> View All Questions
                                </a>
                            </div>
                            @if (!$isInternalAudit && !$isManagement)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('aeo.questions.create') }}"
                                        class="btn btn-outline-success btn-block">
                                        <i class="fas fa-plus"></i> Add New Question
                                    </a>
                                </div>
                            @endif
                            @if ($isAeoOrAdmin)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('aeo.questions.import.form') }}"
                                        class="btn btn-outline-info btn-block">
                                        <i class="fas fa-file-import"></i> Import Questions
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-info {
            background: linear-gradient(87deg, #11cdef 0, #1171ef 100%) !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(87deg, #fb6340 0, #fbb140 100%) !important;
        }

        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }

        .card-header h5 {
            font-size: 1rem;
            font-weight: 600;
        }

        .progress {
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .badge.fs-6 {
            font-size: 1rem !important;
            padding: 0.5rem 0.75rem;
            font-weight: 600;
        }

        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1.5rem 4rem rgba(0, 0, 0, .2) !important;
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        .btn-outline-primary:hover,
        .btn-outline-success:hover,
        .btn-outline-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
        }
    </style>
@endsection
