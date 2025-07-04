@extends('layouts.app')

@section('title', 'Tambah Perusahaan Baru')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">
                    <i class="bi bi-building me-2"></i>Tambah Perusahaan Baru
                </h2>
                <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Terjadi kesalahan!</strong> Silakan periksa form berikut:
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('companies.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">
                                <i class="bi bi-building me-1"></i>Nama Perusahaan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                placeholder="Contoh: PT. JobConnect Indonesia"
                                value="{{ old('name') }}" 
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="location" class="form-label fw-bold">
                                <i class="bi bi-geo-alt me-1"></i>Lokasi
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="location" id="location" 
                                class="form-control @error('location') is-invalid @enderror" 
                                placeholder="Contoh: Jakarta Pusat"
                                value="{{ old('location') }}" 
                                required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-file-text me-1"></i>Deskripsi Perusahaan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="description" id="description" rows="5"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Deskripsikan perusahaan Anda..."
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimal 50 karakter</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save-fill me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection