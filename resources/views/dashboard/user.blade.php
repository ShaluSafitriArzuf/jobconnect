@extends('layouts.app')

@section('title', 'Dashboard Pengguna')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">
            <i class="bi bi-person-circle me-2"></i>Dashboard Pengguna
        </h1>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userActions" 
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-gear-fill"></i> Menu
            </button>
            <ul class="dropdown-menu" aria-labelledby="userActions">
                <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('user.settings') }}"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
            </ul>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="card border-0 shadow-sm bg-info bg-opacity-10 mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="bi bi-person-badge display-6 text-info"></i>
                </div>
                <div class="flex-grow-1 ms-4">
                    <h3 class="card-title">Selamat datang, {{ auth()->user()->name }}! 🙋‍♂️</h3>
                    <p class="card-text">Temukan pekerjaan impian dan kelola lamaran Anda dengan mudah.</p>
                    @if(auth()->user()->profile_complete)
                        <span class="badge bg-info bg-opacity-25 text-info">
                            <i class="bi bi-check-circle me-1"></i> Profil Lengkap
                        </span>
                    @else
                        <span class="badge bg-warning bg-opacity-25 text-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i> Lengkapi Profil
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Active Applications -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-start border-start-4 border-start-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-semibold">Lamaran Aktif</h6>
                            <h3 class="mb-0">{{ $activeApplications ?? 0 }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-file-earmark-text display-6 text-primary opacity-25"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('user.applications.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-arrow-right me-1"></i> Lihat Semua
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Jobs -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-start border-start-4 border-start-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-semibold">Lowongan Tersedia</h6>
                            <h3 class="mb-0">{{ $availableJobs ?? 0 }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-briefcase display-6 text-success opacity-25"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-arrow-right me-1"></i> Cari Lowongan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-start border-start-4 border-start-warning h-100">
                <div class="card-body">
                    <h6 class="fw-semibold text-warning mb-3">Aksi Cepat</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('jobs.index') }}" class="btn btn-warning">
                            <i class="bi bi-search me-1"></i> Cari Pekerjaan
                        </a>
                        <a href="{{ route('user.profile') }}" class="btn btn-outline-primary">
                            <i class="bi bi-person-lines-fill me-1"></i> Profil Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommended Jobs -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-stars me-2"></i>Rekomendasi Untuk Anda</h5>
                <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-outline-secondary">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($recommendedJobs && $recommendedJobs->count() > 0)
                <div class="row g-4">
                    @foreach($recommendedJobs as $job)
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        {{ $job->category->name ?? 'Umum' }}
                                    </span>
                                    <small class="text-muted">
                                        {{ $job->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <h5 class="card-title">{{ $job->title }}</h5>
                                <p class="card-text text-muted">
                                    {{ Str::limit($job->description, 120) }}
                                </p>
                                <div class="d-flex align-items-center mt-4">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-dark rounded-circle">
                                                {{ strtoupper(substr($job->company->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $job->company->name }}</h6>
                                        <small class="text-muted">{{ $job->location }}</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-primary">
                                            Lamar <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-emoji-frown display-6 text-muted mb-3"></i>
                    <p class="text-muted">Belum ada rekomendasi untuk Anda saat ini</p>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Cari Lowongan
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection