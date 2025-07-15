@extends('layouts.app')

@section('title', 'Daftar Semua Lamaran')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-people-fill me-2"></i> Daftar Lamaran Masuk
    </h2>

    @if ($applications->count())
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Pelamar</th>
                                <th>Pekerjaan</th>
                                <th>Perusahaan</th>
                                <th>Status</th>
                                <th>Tanggal Lamar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $key => $application)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $application->user->name }}</td>
                                    <td>{{ $application->job->title ?? '-' }}</td>
                                    <td>{{ $application->job->company->name ?? '-' }}</td>
                                    <td>
                                        @if ($application->status === 'accepted')
                                            <span class="badge bg-success">Diterima</span>
                                        @elseif ($application->status === 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $application->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $applications->links() }}
        </div>
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill me-2"></i> Belum ada lamaran dari user mana pun.
        </div>
    @endif
</div>
@endsection
