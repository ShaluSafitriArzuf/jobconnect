@extends('layouts.app')

@section('title', 'Lamaran Saya')

@section('content')
    <h2 class="fw-bold mb-4">Lamaran Saya</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($applications->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Judul Pekerjaan</th>
                        <th>Perusahaan</th>
                        <th>Surat Lamaran</th>
                        <th>Status</th>
                        <th>Dikirim Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $app)
                        <tr>
                            <td>{{ $app->job->title ?? '-' }}</td>
                            <td>{{ $app->job->company->name ?? '-' }}</td>
                            <td>{{ Str::limit($app->cover_letter, 40) }}</td>
                            <td>
                                @if ($app->status === 'Accepted')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif ($app->status === 'Rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>{{ $app->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted">Belum ada lamaran yang dikirim.</p>
    @endif
@endsection
