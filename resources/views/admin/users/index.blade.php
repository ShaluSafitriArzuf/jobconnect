@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-people-fill me-2"></i>Kelola Pengguna
        </h2>
        
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari Pengguna</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari berdasarkan nama/email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="company" {{ request('role') == 'company' ? 'selected' : '' }}>Perusahaan</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>Belum Verifikasi</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="ps-4">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3">
                                            <span class="avatar-title bg-primary rounded-circle">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ 
                                        $user->role === 'admin' ? 'danger' : 
                                        ($user->role === 'company' ? 'info' : 'secondary') 
                                    }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="bi bi-check-circle me-1"></i> Terverifikasi
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning">
                                            <i class="bi bi-exclamation-triangle me-1"></i> Belum Verifikasi
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->translatedFormat('d F Y') }}</td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" data-bs-target="#userModal{{ $user->id }}"
                                                title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                        
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($user->role === 'company' && $user->company)
                                            <a href="{{ route('admin.companies.show', $user->company->id) }}" 
                                               class="btn btn-sm btn-outline-info" title="Lihat Perusahaan">
                                                <i class="bi bi-building"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-people display-5 text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada pengguna terdaftar</h5>
                                    <p class="text-muted">Mulai dengan menambahkan pengguna pertama</p>
                                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-lg me-1"></i> Tambah Pengguna
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($users->hasPages()) <!-- Sekarang tidak error karena $users adalah Paginator -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endif
</div>

<!-- Modal Detail User -->
@foreach($users as $user)
<div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="avatar-xl mb-3 mx-auto">
                            <span class="avatar-title bg-light text-primary rounded-circle">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                        <h5>{{ $user->name }}</h5>
                        <span class="badge bg-{{ 
                            $user->role === 'admin' ? 'danger' : 
                            ($user->role === 'company' ? 'info' : 'secondary') 
                        }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <h6>Informasi Dasar</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Email:</span>
                                    <span>{{ $user->email }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Status:</span>
                                    <span>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            <span class="badge bg-warning">Belum Verifikasi</span>
                                        @endif
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Tanggal Daftar:</span>
                                    <span>{{ $user->created_at->translatedFormat('l, d F Y H:i') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Terakhir Diupdate:</span>
                                    <span>{{ $user->updated_at->diffForHumans() }}</span>
                                </li>
                            </ul>
                        </div>
                        
                        @if($user->role === 'company' && $user->company)
                            <div class="mb-3">
                                <h6>Informasi Perusahaan</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Nama Perusahaan:</span>
                                        <span>{{ $user->company->name }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Lokasi:</span>
                                        <span>{{ $user->company->location }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total Lowongan:</span>
                                        <span>{{ $user->company->jobs_count ?? 0 }}</span>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection