@extends('layouts.app')

@section('title', 'Dashboard Perusahaan')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold mb-0">
                <i class="bi bi-building me-2"></i>Dashboard Perusahaan
            </h1>
        </div>

        <!-- Welcome Card -->
        <div class="card border-0 shadow-sm bg-success bg-opacity-10 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-building display-6 text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-4">
                        <h3 class="card-title">Halo, {{ auth()->user()->name }}! 🏢</h3>
                        <p class="card-text">Kelola lowongan dan pantau pelamar pekerjaan di perusahaan Anda.</p>
                        @if($company)
                            <span class="badge bg-success bg-opacity-25 text-success">
                                <i class="bi bi-check-circle me-1"></i> {{ $company->name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-4 mb-4">
            <!-- Lowongan Aktif -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('company.jobs.index') }}" class="text-decoration-none text-dark">
                    <div class="card border-start border-start-4 border-start-primary h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted fw-semibold">Lowongan Aktif</h6>
                            <h3 class="mb-0">{{ $activeJobs ?? 0 }}</h3>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Total Pelamar -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-start-4 border-start-info h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted fw-semibold">Total Pelamar</h6>
                        <h3 class="mb-0">{{ $totalApplicants ?? 0 }}</h3>
                    </div>
                </div>
            </div>



        </div>

        <!-- Pelamar Terbaru -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Pelamar </h5>
            </div>
            <div class="card-body p-0">
                @if($recentApplicants && $recentApplicants->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($recentApplicants as $applicant)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $applicant->user->name }}</strong> -
                                        <a href="{{ route('applications.applicants', $applicant->job->id) }}"
                                            class="text-decoration-none">
                                            {{ $applicant->job->title }}
                                        </a>
                                    </div>
                                    <span class="badge bg-{{
                            $applicant->status == 'pending' ? 'warning' :
                            ($applicant->status == 'accepted' ? 'success' : 'danger')
                                                    }}">
                                        {{ ucfirst($applicant->status) }}
                                    </span>
                                </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-person-x display-6"></i>
                        <p class="mb-0">Belum ada pelamar terbaru</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Lowongan Saya -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0"><i class="bi bi-briefcase-fill me-2"></i>Lowongan Anda</h5>
            </div>
            <div class="card-body p-0">
                @if($companyJobs && $companyJobs->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($companyJobs as $job)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $job->title }}</strong><br>
                                    <small class="text-muted">{{ $job->location }} &middot;
                                        {{ $job->created_at->diffForHumans() }}</small>
                                </div>
                                <a href="{{ route('company.jobs.show', $job->id) }}" class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-briefcase display-6"></i>
                        <p class="mb-0">Belum ada lowongan yang dibuat</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection