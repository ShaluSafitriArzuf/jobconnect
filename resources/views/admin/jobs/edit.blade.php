@extends('layouts.app')

@section('title', 'Edit Lowongan - ' . $job->title)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Edit Lowongan
                    <span class="text-muted fs-5">({{ $job->title }})</span>
                </h2>
                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-secondary">
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
                    <form action="{{ route('jobs.update', $job->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">
                                <i class="bi bi-card-heading me-1"></i>Judul Lowongan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" id="title" 
                                class="form-control @error('title') is-invalid @enderror" 
                                value="{{ old('title', $job->title) }}" 
                                required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-file-text me-1"></i>Deskripsi Pekerjaan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="description" id="description" rows="8"
                                class="form-control @error('description') is-invalid @enderror"
                                required>{{ old('description', $job->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="location" class="form-label fw-bold">
                                        <i class="bi bi-geo-alt me-1"></i>Lokasi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="location" id="location" 
                                        class="form-control @error('location') is-invalid @enderror" 
                                        value="{{ old('location', $job->location) }}" 
                                        required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
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
                                        <option value="Full-Time" {{ old('job_type', $job->job_type) == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                                        <option value="Part-Time" {{ old('job_type', $job->job_type) == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                                        <option value="Internship" {{ old('job_type', $job->job_type) == 'Internship' ? 'selected' : '' }}>Internship</option>
                                        <option value="Contract" {{ old('job_type', $job->job_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="Freelance" {{ old('job_type', $job->job_type) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                    </select>
                                    @error('job_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="shalu_category_id" class="form-label fw-bold">
                                        <i class="bi bi-tag me-1"></i>Kategori
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="shalu_category_id" id="shalu_category_id" 
                                        class="form-select @error('shalu_category_id') is-invalid @enderror" 
                                        required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('shalu_category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shalu_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="deadline" class="form-label fw-bold">
                                        <i class="bi bi-calendar-x me-1"></i>Deadline
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="deadline" id="deadline" 
                                        class="form-control @error('deadline') is-invalid @enderror" 
                                        value="{{ old('deadline', $job->deadline->format('Y-m-d')) }}" 
                                        min="{{ date('Y-m-d') }}" 
                                        required>
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-check-circle-fill me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection