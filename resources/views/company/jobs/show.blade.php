@extends('layouts.app')

@section('title', 'Detail Lowongan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">
                    <i class="bi bi-eye-fill me-2"></i>Detail Lowongan
                </h2>
                <a href="{{ route('company.jobs.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">
                        <i class="bi bi-briefcase me-2"></i>{{ $job->title }}
                    </h4>

                    <ul class="list-unstyled mb-4">
                        <li><i class="bi bi-building me-2"></i><strong>Perusahaan:</strong> {{ $job->company->name ?? '-' }}</li>
                        <li><i class="bi bi-geo-alt me-2"></i><strong>Lokasi:</strong> {{ $job->location }}</li>
                        <li><i class="bi bi-clock me-2"></i><strong>Jenis:</strong> {{ $job->job_type }}</li>
                        <li><i class="bi bi-cash me-2"></i><strong>Gaji:</strong> {{ $job->salary ?? 'Tidak disebutkan' }}</li>
                        <li><i class="bi bi-tags me-2"></i><strong>Kategori:</strong> {{ $job->category->name ?? '-' }}</li>
                        <li><i class="bi bi-calendar me-2"></i><strong>Deadline:</strong> {{ $job->deadline }}</li>
                        <li><i class="bi bi-toggle-on me-2"></i><strong>Status:</strong> {{ ucfirst($job->status) }}</li>
                    </ul>

                    <hr>

                    <h5 class="fw-bold mb-2"><i class="bi bi-card-text me-2"></i>Deskripsi</h5>
                    <p>{{ $job->description }}</p>

                    <h5 class="fw-bold mt-4 mb-2"><i class="bi bi-list-check me-2"></i>Syarat & Ketentuan</h5>
                    <p>{{ $job->requirements ?? '-' }}</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
