@extends('layouts.app')

@section('title', 'Riwayat Lamaran Saya')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-list-check me-2"></i>Riwayat Lamaran Saya
        </h2>
        <a href="{{ route('jobs.index') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Lamar Pekerjaan Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($applications->count())
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Pekerjaan</th>
                                <th>Perusahaan</th>
                                <th>Status</th>
                                <th>Tanggal Lamar</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                <tr>
                                    <td class="ps-4 align-middle">
                                        <h6 class="mb-1">{{ $application->job->title ?? '-' }}</h6>
                                        <small class="text-muted">{{ $application->job->location ?? '-' }}</small>
                                    </td>
                                    <td class="align-middle">
                                        {{ $application->job->company->name ?? '-' }}
                                    </td>
                                    <td class="align-middle">
                                        @if ($application->status === 'accepted')
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                                <i class="bi bi-check-circle-fill me-1"></i> Diterima
                                            </span>
                                        @elseif ($application->status === 'rejected')
                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">
                                                <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">
                                                <i class="bi bi-hourglass-split me-1"></i> Dalam Review
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        {{ $application->created_at->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="pe-4 align-middle">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('jobs.show', $application->job->id) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Lihat Lowongan">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                data-bs-toggle="modal" data-bs-target="#applicationModal{{ $application->id }}"
                                                title="Lihat Detail">
                                                <i class="bi bi-file-earmark-text-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Application Detail Modal -->
                                <div class="modal fade" id="applicationModal{{ $application->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Lamaran - {{ $application->job->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Perusahaan</h6>
                                                    <p>{{ $application->job->company->name }}</p>
                                                </div>
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Status Lamaran</h6>
                                                    <p>
                                                        @if ($application->status === 'accepted')
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif ($application->status === 'rejected')
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">Dalam Review</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="mb-4">
                                                    <h6 class="fw-bold">Pesan Pengantar / Motivasi</h6>
                                                    <div class="p-3 bg-light rounded">
                                                        {!! nl2br(e($application->cover_letter)) !!}
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold">Tanggal Lamar</h6>
                                                    <p>{{ $application->created_at->translatedFormat('l, d F Y H:i') }}</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $applications->links() }}
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-file-earmark-text display-5 text-muted mb-3"></i>
                <h5 class="text-muted">Anda belum mengirim lamaran</h5>
                <p class="text-muted">Temukan lowongan yang sesuai dan kirim lamaran pertama Anda!</p>
                <a href="{{ route('jobs.index') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-search me-1"></i> Cari Lowongan
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
