@extends('layouts.app')

@section('title', 'Daftar Lowongan Kerja')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-briefcase-fill me-2"></i>Daftar Lowongan Kerja
        </h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.jobs.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari Lowongan</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari berdasarkan judul..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="job_type" class="form-label">Jenis Pekerjaan</label>
                        <select name="job_type" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="Full-Time" {{ request('job_type') == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                            <option value="Part-Time" {{ request('job_type') == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                            <option value="Internship" {{ request('job_type') == 'Internship' ? 'selected' : '' }}>Internship</option>
                            <option value="Contract" {{ request('job_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($jobs->count())
        <div class="row g-4">
            @foreach($jobs as $job)
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $job->category->name ?? 'Umum' }}
                                </span>
                                <small class="text-muted">
                                    {{ $job->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <h4 class="card-title">{{ $job->title }}</h4>

                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-building text-muted me-2"></i>
                                <span>{{ $job->company->name ?? 'Perusahaan Tidak Diketahui' }}</span>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    <i class="bi bi-geo-alt me-1"></i> {{ $job->location }}
                                </span>
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="bi bi-clock me-1"></i> {{ $job->job_type }}
                                </span>
                                @if($job->salary)
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="bi bi-cash-coin me-1"></i> {{ $job->salary }}
                                    </span>
                                @endif
                                <span class="badge bg-warning bg-opacity-10 text-warning">
                                    <i class="bi bi-calendar-x me-1"></i> {{ $job->deadline->format('d M Y') }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> Lihat Detail
                                </a>
                                <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $jobs->appends(request()->query())->links() }}
        </div>

    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-briefcase display-5 text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada lowongan tersedia</h5>
                <p class="text-muted">Coba gunakan filter lain atau periksa kembali nanti</p>
            </div>
        </div>
    @endif

</div>
@endsection
