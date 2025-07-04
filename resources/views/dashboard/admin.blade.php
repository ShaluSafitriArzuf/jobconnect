@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard Admin
        </h1>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dashboardActions" 
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-gear-fill"></i> Menu
            </button>
            <ul class="dropdown-menu" aria-labelledby="dashboardActions">
                <li><a href="{{ route('admin.dashboard') }}">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a href="{{ route('admin.dashboard') }}">Reports</a></li>
            </ul>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="card border-0 shadow-sm bg-primary bg-opacity-10 mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="bi bi-person-check-fill display-6 text-primary"></i>
                </div>
                <div class="flex-grow-1 ms-4">
                    <h3 class="card-title">Selamat datang, {{ auth()->user()->name }}! 👑</h3>
                    <p class="card-text">Anda login sebagai Administrator. Kelola seluruh sistem dengan mudah.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Total Users -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-start-4 border-start-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-semibold">Total Pengguna</h6>
                            <h3 class="mb-0">{{ $totalUsers ?? 0 }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-people-fill display-6 text-success opacity-25"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-arrow-right me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Companies -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-start-4 border-start-info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-semibold">Total Perusahaan</h6>
                            <h3 class="mb-0">{{ $totalCompanies ?? 0 }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-building display-6 text-info opacity-25"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.companies.index') }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-arrow-right me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Jobs -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-start-4 border-start-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-semibold">Total Lowongan</h6>
                            <h3 class="mb-0">{{ $totalJobs ?? 0 }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-briefcase-fill display-6 text-warning opacity-25"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-arrow-right me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Applications -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-start-4 border-start-danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-semibold">Total Lamaran</h6>
                            <h3 class="mb-0">{{ $totalApplications ?? 0 }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-file-earmark-text-fill display-6 text-danger opacity-25"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-arrow-right me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions - Expanded to full width -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary w-100 text-start">
                                <i class="bi bi-person-plus me-2"></i>Tambah Pengguna
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.companies.create') }}" class="btn btn-outline-success w-100 text-start">
                                <i class="bi bi-building-add me-2"></i>Tambah Perusahaan
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-info w-100 text-start">
                                <i class="bi bi-tag me-2"></i>Tambah Kategori
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.jobs.create') }}" class="btn btn-outline-warning w-100 text-start">
                                <i class="bi bi-file-earmark-plus me-2"></i>Posting Lowongan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection