@extends('layouts.app')

@section('title', $job->title . ' - Detail Lowongan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">
                    <i class="bi bi-briefcase me-2"></i>{{ $job->title }}
                </h2>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar-sm me-3">
                                    <span class="avatar-title bg-light text-dark rounded-circle">
                                        {{ strtoupper(substr($job->company->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $job->company->name ?? 'Perusahaan Tidak Diketahui' }}</h5>
                                    <small class="text-muted">{{ $job->company->location ?? '' }}</small>
                                </div>
                            </div>
                            
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @if($job->category)
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    <i class="bi bi-tag me-1"></i> {{ $job->category->name }}
                                </span>
                                @endif
                                
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="bi bi-clock me-1"></i> {{ $job->job_type }}
                                </span>
                                
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-geo-alt me-1"></i> {{ $job->location }}
                                </span>
                                
                                @if($job->deadline)
                                <span class="badge bg-warning bg-opacity-10 text-warning">
                                    <i class="bi bi-calendar-x me-1"></i> {{ $job->deadline->format('d M Y') }}
                                </span>
                                @endif
                                
                                @if($job->salary)
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    <i class="bi bi-cash-coin me-1"></i> {{ $job->salary }}
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <small class="text-muted d-block">
                                Diposting {{ $job->created_at->diffForHumans() }}
                            </small>
                            @if($job->deadline && $job->deadline->isPast())
                                <span class="badge bg-danger">Ditutup</span>
                            @else
                                <span class="badge bg-success">Masih Dibuka</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h5 class="fw-bold"><i class="bi bi-file-text me-2"></i>Deskripsi Pekerjaan</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    @if($job->requirements)
                    <div class="mb-4">
                        <h5 class="fw-bold"><i class="bi bi-list-check me-2"></i>Persyaratan</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                    @endif

                    @if($job->salary)
                    <div class="mb-4">
                        <h5 class="fw-bold"><i class="bi bi-cash-coin me-2"></i>Gaji</h5>
                        <div class="p-3 bg-light rounded">
                            {{ $job->salary }}
                        </div>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            @if($job->deadline && $job->deadline->isFuture())
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i> 
                                    Berakhir dalam {{ $job->deadline->diffForHumans() }}
                                </small>
                            @endif
                        </div>
                        
                        <div class="d-flex gap-2">
                            @auth
                                @if(auth()->user()->role === 'company' && auth()->user()->id == $job->company->user_id)
                                    <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>
                                    <a href="{{ route('applications.applicants', $job->id) }}" class="btn btn-primary">
                                        <i class="bi bi-people me-1"></i> Lihat Pelamar
                                    </a>
                                @elseif(auth()->user()->role === 'user')
                                    @if($hasApplied)
                                        <button class="btn btn-success" disabled>
                                            <i class="bi bi-check-circle me-1"></i> Sudah Dilamar
                                        </button>
                                    @else
                                        <a href="{{ route('applications.create', $job->id) }}" class="btn btn-success">
                                            <i class="bi bi-send me-1"></i> Lamar Sekarang
                                        </a>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Melamar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection