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

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-between mt-4 align-items-center">
                <a href="{{ route('jobs.index') }}" class="btn btn-secondary">⬅ Kembali</a>

                {{-- Tombol "Lihat Pelamar" untuk Perusahaan --}}
                @if(auth()->check() && auth()->user()->role === 'company')
                    <a href="{{ route('applications.applicants', $job->id) }}" class="btn btn-primary">
                        📄 Lihat Pelamar
                    </a>
                @endif

                {{-- Tombol "Lamar Sekarang" untuk User --}}
                @auth
                    @if(auth()->user()->role === 'user')
                        <a href="{{ route('applications.create', $job->id) }}" class="btn btn-success">
                            ✅ Lamar Sekarang
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                        🔒 Login untuk melamar
                    </a>
                @endauth
            </div>
        </div>
    </div>
@endsection
