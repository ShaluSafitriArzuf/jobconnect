@extends('layouts.app')

@section('title', 'Dashboard Perusahaan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">
            <i class="bi bi-building me-2"></i>Dashboard Perusahaan
        </h1>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="companyActions" 
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-gear-fill"></i> Menu
            </button>
            <ul class="dropdown-menu" aria-labelledby="companyActions">
                <li><a class="dropdown-item" href="{{ route('company.profile') }}"><i class="bi bi-building me-2"></i>Profil Perusahaan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('company.settings') }}"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
            </ul>
        </div>
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
        <!-- Active Jobs -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-start-4 border-start-primary h-100">
                <div class="card-body">
                    <h6 class="text-muted fw-semibold">Lowongan Aktif</h6>
                    <h3 class="mb-0">{{ $activeJobs ?? 0 }}</h3>
                    <div class="mt-3">
                        <a href="{{ route('company.jobs.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-arrow-right me-1"></i> Lihat Semua
                        </a>
                    </div>
                </div>
            </div>
        </div>

       <!-- Total Applicants -->
<div class="col-xl-3 col-md-6">
    <div class="card border-start border-start-4 border-start-info h-100">
        <div class="card-body">
            <h6 class="text-muted fw-semibold">Total Pelamar</h6>
            <a href="{{ route('company.applications.index') }}" class="text-decoration-none">
                <h3 class="mb-0 text-primary">{{ $totalApplicants ?? 0 }}</h3>
            </a>
        </div>
    </div>
</div>


        <!-- Quick Actions -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-start-4 border-start-success h-100">
                <div class="card-body">
                    <h6 class="fw-semibold text-success mb-3">Aksi Cepat</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('company.jobs.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-lg me-1"></i> Buat Lowongan
                        </a>
                        <a href="{{ route('company.jobs.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-list-ul me-1"></i> Lowongan Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lowongan Saya -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-briefcase-fill me-2"></i>Lowongan Saya</h5>
                <a href="{{ route('company.jobs.index') }}" class="btn btn-sm btn-outline-secondary">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            @if($jobs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th>Lokasi</th>
                                <th>Total Pelamar</th>
                                <th>Diterima</th>
                                <th>Ditolak</th>
                                <th>Pending</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $job)
                                <tr>
                                    <td>
                                        <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none fw-semibold">
                                            {{ $job->title }}
                                        </a>
                                    </td>
                                    <td>{{ $job->location }}</td>
                                    <td>{{ $job->applicants_count }}</td>
                                    <td>{{ $job->accepted_count }}</td>
                                    <td>{{ $job->rejected_count }}</td>
                                    <td>{{ $job->pending_count }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('applications.applicants', $job->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-people-fill me-1"></i> Pelamar
                                        </a>
                                        <a href="{{ route('company.jobs.edit', $job->id) }}" 
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-briefcase display-6"></i>
                    <p class="mb-0">Belum ada lowongan yang dibuat.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
