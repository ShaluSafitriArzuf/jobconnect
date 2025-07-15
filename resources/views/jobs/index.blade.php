@extends('layouts.app')

@section('title', 'Lowongan Tersedia')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-briefcase-fill me-2"></i>Lowongan Tersedia
        </h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- FILTER --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body bg-light rounded">
            <form action="{{ route('jobs.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="search" class="form-label fw-semibold">Cari Lowongan</label>
                        <input type="text" name="search" id="search" class="form-control"
                               placeholder="Contoh: Web Developer..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="category" class="form-label fw-semibold">Kategori</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="job_type" class="form-label fw-semibold">Jenis Pekerjaan</label>
                        <select name="job_type" id="job_type" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="Full-Time" {{ request('job_type') == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                            <option value="Part-Time" {{ request('job_type') == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                            <option value="Internship" {{ request('job_type') == 'Internship' ? 'selected' : '' }}>Internship</option>
                            <option value="Contract" {{ request('job_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Freelance" {{ request('job_type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel-fill me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- JOB CARD SECTION --}}
    @if($jobs->count())
        <div class="row g-4">
            @foreach($jobs as $job)
                <div class="col-md-4">
                    <div class="card h-100 shadow job-card text-center border border-primary-subtle rounded-4">
                        <div class="card-body d-flex flex-column align-items-center p-4 bg-white">
                            {{-- Logo Perusahaan --}}
                            @if($job->company && $job->company->logo)
                                <img src="{{ asset('storage/' . $job->company->logo) }}"
                                     alt="Logo {{ $job->company->name }}"
                                     class="rounded-circle shadow-sm mb-3"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center mb-3"
                                     style="width: 80px; height: 80px;">
                                    <i class="bi bi-building text-muted fs-2"></i>
                                </div>
                            @endif

                            {{-- Info Utama --}}
                            <h5 class="fw-bold mb-1 text-primary">{{ $job->title }}</h5>
                            <small class="text-muted mb-2">
                                <i class="bi bi-building me-1"></i>{{ $job->company->name ?? '-' }}
                            </small>

                            {{-- Badge Detail --}}
                            <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $job->location }}
                                </span>
                                <span class="badge bg-info-subtle text-info rounded-pill px-3">
                                    <i class="bi bi-clock me-1"></i>{{ $job->job_type }}
                                </span>
                                @if($job->salary)
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3">
                                        <i class="bi bi-cash-coin me-1"></i>{{ $job->salary }}
                                    </span>
                                @endif
                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3">
                                    <i class="bi bi-calendar-event me-1"></i>{{ $job->deadline->format('d M Y') }}
                                </span>
                            </div>

                            {{-- Deskripsi --}}
                            <p class="text-muted small mb-3 px-2">
                                {{ Str::limit(strip_tags($job->description), 100) }}
                            </p>

                            {{-- Tombol --}}
                            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $jobs->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="card shadow-sm text-center border-0">
            <div class="card-body py-5">
                <i class="bi bi-briefcase fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada lowongan ditemukan</h5>
                <p class="text-muted">Silakan coba filter lainnya atau cek kembali nanti</p>
            </div>
        </div>
    @endif
</div>

<style>
    .job-card {
        transition: all 0.3s ease-in-out;
    }

    .job-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 123, 255, 0.1);
        border-color: #0d6efd3d;
    }

    .badge {
        font-size: 0.75rem;
    }

    .card-body.bg-white {
        border-radius: 1rem;
    }

    /* Optional: pagination styling tweak */
    .pagination .page-item .page-link {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }

    .pagination .page-item svg {
        width: 1rem;
        height: 1rem;
    }
</style>
@endsection
