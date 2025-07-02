@extends('layouts.app')

@section('title', 'Daftar Lowongan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Daftar Lowongan Kerja</h2>
        @if (auth()->check() && auth()->user()->role === 'company')
            <a href="{{ route('jobs.create') }}" class="btn btn-primary">➕ Tambah Lowongan</a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($jobs->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Judul</th>
                        <th>Perusahaan</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Deadline</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->company->name ?? '-' }}</td>
                            <td>{{ $job->category->name ?? '-' }}</td>
                            <td>{{ $job->location }}</td>
                            <td>{{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-info btn-sm">🔍</a>

                                @if(auth()->check() && auth()->user()->role === 'company')
                                    <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-warning btn-sm">✏️</a>

                                    <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline-block;"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                    </form>

                                    {{-- Tombol Lihat Pelamar --}}
                                    <a href="{{ route('applications.applicants', $job->id) }}" class="btn btn-success btn-sm mt-1">
                                        👥 Pelamar
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted">Belum ada lowongan tersedia.</p>
    @endif
@endsection
