@extends('layouts.app')

@section('title', 'Buat Lowongan Baru')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">
                    <i class="bi bi-file-earmark-plus me-2"></i>Buat Lowongan Baru
                </h2>
                <a href="{{ route('company.jobs.index') }}" class="btn btn-outline-secondary">
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
                    <form action="{{ route('company.jobs.store') }}" method="POST">
                        @csrf
                        @if(auth()->user()->company)
                            <input type="hidden" name="shalu_company_id" value="{{ auth()->user()->company->id }}">
                        @else
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill"></i> 
                                Akun perusahaan Anda belum lengkap. Silakan lengkapi profil perusahaan terlebih dahulu.
                            </div>
                        @endif

                        <!-- Input Judul Lowongan -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">
                                <i class="bi bi-card-heading me-1"></i>Judul Lowongan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" id="title" 
                                class="form-control @error('title') is-invalid @enderror" 
                                placeholder="Contoh: Web Developer"
                                value="{{ old('title') }}" 
                                required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Deskripsi -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-file-text me-1"></i>Deskripsi Pekerjaan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="description" id="description" rows="8"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Deskripsikan pekerjaan secara detail..."
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <!-- Input Lokasi -->
                            <div class="col-md-6">
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
                            </div>
                            
                            <!-- Input Jenis Pekerjaan -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="job_type" class="form-label fw-bold">
                                        <i class="bi bi-clock me-1"></i>Jenis Pekerjaan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="job_type" id="job_type" 
                                        class="form-select @error('job_type') is-invalid @enderror" 
                                        required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Full-Time" {{ old('job_type') == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                                        <option value="Part-Time" {{ old('job_type') == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                                        <option value="Internship" {{ old('job_type') == 'Internship' ? 'selected' : '' }}>Internship</option>
                                        <option value="Contract" {{ old('job_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="Freelance" {{ old('job_type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                    </select>
                                    @error('job_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Input Kategori -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="shalu_category_id" class="form-label fw-bold">
                                        <i class="bi bi-tag me-1"></i>Kategori
                                        <span class="text-danger">*</span>
                                    </label>
                                    @if($categories->count() > 0)
                                        <select name="shalu_category_id" id="shalu_category_id" 
                                            class="form-select @error('shalu_category_id') is-invalid @enderror" 
                                            required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('shalu_category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <div class="alert alert-warning py-2">Tidak ada kategori tersedia</div>
                                    @endif
                                    @error('shalu_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Input Deadline -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="deadline" class="form-label fw-bold">
                                        <i class="bi bi-calendar-x me-1"></i>Deadline
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="deadline" id="deadline" 
                                        class="form-control @error('deadline') is-invalid @enderror" 
                                        value="{{ old('deadline') }}" 
                                        min="{{ date('Y-m-d') }}" 
                                        required>
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Input Gaji -->
                        <div class="mb-4">
                            <label for="salary" class="form-label fw-bold">
                                <i class="bi bi-cash-coin me-1"></i>Gaji
                            </label>
                            <input type="text" name="salary" id="salary" 
                                class="form-control @error('salary') is-invalid @enderror" 
                                placeholder="Contoh: Rp 5.000.000 - Rp 8.000.000"
                                value="{{ old('salary') }}">
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Persyaratan -->
                        <div class="mb-4">
                            <label for="requirements" class="form-label fw-bold">
                                <i class="bi bi-list-check me-1"></i>Persyaratan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="requirements" id="requirements" rows="5"
                                class="form-control @error('requirements') is-invalid @enderror"
                                placeholder="Tuliskan persyaratan untuk posisi ini..."
                                required>{{ old('requirements') }}</textarea>
                            @error('requirements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save-fill me-1"></i> Publikasikan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
