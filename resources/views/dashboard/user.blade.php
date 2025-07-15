@extends('layouts.app')

@section('title', 'Dashboard Pengguna')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="fw-bold text-primary">
            <i class="bi bi-person-circle me-2"></i>Dashboard Pengguna
        </h1>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userActions"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-gear-fill"></i> Menu
            </button>
            <ul class="dropdown-menu" aria-labelledby="userActions">
                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                    <i class="bi bi-person me-2"></i>Profil Saya
                </a></li>
            </ul>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="card border-0 shadow-lg bg-light mb-5">
        <div class="card-body d-flex align-items-center">
            <i class="bi bi-person-badge display-4 text-info me-4"></i>
            <div>
                <h3 class="fw-bold mb-1">Selamat datang, {{ auth()->user()->name }}! 🙋‍♂️</h3>
                <p class="mb-0">Temukan pekerjaan impian dan kelola lamaran Anda dengan mudah.</p>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <!-- Lamaran Aktif -->
        <div class="col-md-4">
            <div class="card h-100 border-start border-5 border-primary shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Lamaran Aktif</h6>
                    <h3 class="fw-bold">{{ $activeApplications ?? 0 }}</h3>
                    <a href="{{ route('user.applications.index') }}" class="btn btn-outline-primary mt-3">Lihat Semua</a>
                </div>
            </div>
        </div>

        <!-- Lowongan Tersedia -->
        <div class="col-md-4">
            <div class="card h-100 border-start border-5 border-success shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Lowongan Tersedia</h6>
                    <h3 class="fw-bold">{{ $availableJobs ?? 0 }}</h3>
                    <a href="{{ route('jobs.index') }}" class="btn btn-outline-success mt-3">Cari Lowongan</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekomendasi -->
    <div class="card shadow mb-5 border-0">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary"><i class="bi bi-stars me-2"></i>Rekomendasi Untuk Anda</h5>
            <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
        </div>
        <div class="card-body">
            @php
                $filteredJobs = $recommendedJobs->where('deadline', '>', now());
            @endphp

            @if($filteredJobs->count())
                <div class="row g-4">
                    @foreach($filteredJobs as $job)
                        <div class="col-md-4">
                            <div class="card h-100 text-center shadow-sm border-1 border-light rounded-4">
                                <div class="card-body">
                                    @if($job->company && $job->company->logo)
                                        <img src="{{ asset('storage/' . $job->company->logo) }}"
                                             class="rounded-circle mb-3"
                                             style="width: 80px; height: 80px; object-fit: cover;"
                                             alt="{{ $job->company->name }}">
                                    @else
                                        <div class="rounded-circle bg-light text-dark d-flex align-items-center justify-content-center mx-auto mb-3"
                                             style="width: 80px; height: 80px; font-size: 24px;">
                                            {{ strtoupper(substr($job->company->name ?? '?', 0, 1)) }}
                                        </div>
                                    @endif

                                    <h5 class="fw-bold text-primary">{{ $job->title }}</h5>
                                    <p class="text-muted mb-1"><i class="bi bi-building me-1"></i> {{ $job->company->name }}</p>

                                    <div class="d-flex flex-wrap justify-content-center gap-2 my-2">
                                        <span class="badge bg-primary-subtle text-primary">
                                            <i class="bi bi-geo-alt me-1"></i> {{ $job->location }}
                                        </span>
                                        <span class="badge bg-info-subtle text-info">
                                            <i class="bi bi-clock me-1"></i> {{ $job->job_type }}
                                        </span>
                                        @if($job->deadline)
                                            <span class="badge bg-warning-subtle text-warning">
                                                <i class="bi bi-calendar me-1"></i> {{ $job->deadline->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>

                                    <p class="small text-muted mt-2">
                                        {{ Str::limit(strip_tags($job->description), 90) }}
                                    </p>

                                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-primary w-100 rounded-pill mt-3">
                                        <i class="bi bi-eye me-1"></i> Lihat Detail
                                    </a>
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

    <!-- Lamaran Saya -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary"><i class="bi bi-file-earmark-person me-2"></i>Lamaran Saya</h5>
        </div>
        <div class="card-body p-0">
            @if($userApplications && $userApplications->count())
                <div class="list-group list-group-flush">
                    @foreach($userApplications as $application)
                        <div class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                            <div>
                                @if($application->job)
                                    <h6 class="mb-1">{{ $application->job->title }}</h6>
                                    <small class="text-muted">Status:
                                        <span class="badge bg-{{
                                            $application->status == 'pending' ? 'warning' :
                                            ($application->status == 'accepted' ? 'success' : 'danger')
                                        }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </small>
                                @else
                                    <h6 class="mb-1 text-danger">[Lowongan sudah dihapus]</h6>
                                    <small class="text-muted">
                                        Status:
                                        <span class="badge bg-secondary">Unknown</span>
                                    </small>
                                @endif
                            </div>
                            @if($application->job)
                                <a href="{{ route('jobs.show', $application->job->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-person-x display-6 text-muted mb-3"></i>
                    <p class="text-muted">Anda belum memiliki lamaran saat ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
