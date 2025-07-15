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
        <!-- Active Jobs -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-start-4 border-start-primary h-100">
                <div class="card-body">
                    <h6 class="text-muted fw-semibold">Lowongan Aktif</h6>
                    <h3 class="mb-0">{{ $activeJobs ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Applicants -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-start-4 border-start-info h-100">
                <div class="card-body">
                    <h6 class="text-muted fw-semibold">Total Pelamar</h6>
                    <h3 class="mb-0">{{ $totalApplicants ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- New Applicants -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-start-4 border-start-warning h-100">
                <div class="card-body">
                    <h6 class="text-muted fw-semibold">Pelamar Baru</h6>
                    <h3 class="mb-0">{{ $newApplicants ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
