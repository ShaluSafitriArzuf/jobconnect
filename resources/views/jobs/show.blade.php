@extends('layouts.app')

@section('title', 'Detail Lowongan')

@section('content')
    <h2 class="fw-bold mb-4">Detail Lowongan</h2>

    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title">{{ $job->title }}</h4>
            <p class="text-muted mb-1">
                <strong>Perusahaan:</strong> {{ $job->company->name ?? '-' }}
            </p>
            <p class="text-muted mb-1">
                <strong>Kategori:</strong> {{ $job->category->name ?? '-' }}
            </p>
            <p class="text-muted mb-1">
                <strong>Jenis Pekerjaan:</strong> {{ $job->job_type }}
            </p>
            <p class="text-muted mb-1">
                <strong>Lokasi:</strong> {{ $job->location }}
            </p>
            <p class="text-muted mb-1">
                <strong>Deadline:</strong> {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}
            </p>

            <hr>
            <p>{!! nl2br(e($job->description)) !!}</p>

            <a href="{{ route('jobs.index') }}" class="btn btn-secondary mt-3">⬅ Kembali</a>
        </div>
    </div>
@endsection
