@extends('layouts.app')

@section('title', 'Daftar Pelamar - ' . $job->title)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-people-fill me-2"></i>Daftar Pelamar
            <span class="text-muted fs-5">({{ $job->title }})</span>
        </h2>
        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($job->applications->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-people display-5 text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada pelamar untuk lowongan ini</h5>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama Pelamar</th>
                                <th>Email</th>
                                <th>Surat Lamaran</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($job->applications as $application)
                                <tr>
                                    <td class="ps-4 align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <span class="avatar-title bg-primary rounded-circle">
                                                    {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $application->user->name }}</h6>
                                                <small class="text-muted">{{ $application->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <a href="mailto:{{ $application->user->email }}">{{ $application->user->email }}</a>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" 
                                            data-bs-target="#coverLetterModal{{ $application->id }}">
                                            Lihat Surat
                                        </button>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge rounded-pill 
                                            @if($application->status == 'accepted') bg-success
                                            @elseif($application->status == 'rejected') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td class="pe-4 align-middle">
                                        <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group input-group-sm">
                                                <select name="status" class="form-select form-select-sm">
                                                    <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                                <button class="btn btn-primary" type="submit" title="Update Status">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Cover Letter Modal -->
                                <div class="modal fade" id="coverLetterModal{{ $application->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Surat Lamaran - {{ $application->user->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="p-3 bg-light rounded">
                                                    {!! nl2br(e($application->cover_letter)) !!}
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
    @endif
</div>
@endsection