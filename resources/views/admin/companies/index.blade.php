@extends('layouts.app')

@section('title', 'Daftar Perusahaan')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-buildings-fill me-2"></i>Daftar Perusahaan
        </h2>
        <div>
            <a href="{{ route('companies.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Perusahaan
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($companies->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-building display-5 text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada perusahaan terdaftar</h5>
                <p class="text-muted">Mulai dengan menambahkan perusahaan pertama Anda</p>
                <a href="{{ route('companies.create') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Perusahaan
                </a>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Nama Perusahaan</th>
                                <th>Lokasi</th>
                                <th>Jumlah Lowongan</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                                <tr>
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <span class="avatar-title bg-primary rounded-circle">
                                                    {{ strtoupper(substr($company->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $company->name }}</h6>
                                                <small class="text-muted">{{ Str::limit($company->description, 30) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $company->location }}</td>
                                    <td>{{ $company->jobs_count ?? 0 }}</td>
                                    <td class="pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('companies.edit', $company->id) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus perusahaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $companies->links() }}
        </div>
    @endif
</div>
@endsection