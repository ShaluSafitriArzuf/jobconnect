@extends('layouts.app')

@section('title', 'Edit Lowongan Pekerjaan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Edit Lowongan Pekerjaan
                </h2>
                <a href="{{ route('company.dashboard') }}" class="btn btn-outline-secondary">
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
                    <form action="{{ route('company.jobs.update', $job->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">
                                <i class="bi bi-briefcase me-1"></i>Judul Pekerjaan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $job->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="location" class="form-label fw-bold">
                                <i class="bi bi-geo-alt me-1"></i>Lokasi <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $job->location) }}" required>
                            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="salary" class="form-label fw-bold">
                                <i class="bi bi-cash me-1"></i>Gaji (opsional)
                            </label>
                            <input type="text" name="salary" id="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary', $job->salary) }}">
                            @error('salary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="job_type" class="form-label fw-bold">
                                <i class="bi bi-clock me-1"></i>Jenis Pekerjaan <span class="text-danger">*</span>
                            </label>
                            <select name="job_type" id="job_type" class="form-select @error('job_type') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Full-Time" {{ old('job_type', $job->job_type) == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                                <option value="Part-Time" {{ old('job_type', $job->job_type) == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                                <option value="Internship" {{ old('job_type', $job->job_type) == 'Internship' ? 'selected' : '' }}>Internship</option>
                            </select>
                            @error('job_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="shalu_category_id" class="form-label fw-bold">
                                <i class="bi bi-tags me-1"></i>Kategori <span class="text-danger">*</span>
                            </label>
                            <select name="shalu_category_id" id="shalu_category_id" class="form-select @error('shalu_category_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('shalu_category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('shalu_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="deadline" class="form-label fw-bold">
                                <i class="bi bi-calendar-date me-1"></i>Deadline <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="deadline" id="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline', $job->deadline) }}" required>
                            @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-card-text me-1"></i>Deskripsi Pekerjaan <span class="text-danger">*</span>
                            </label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="6" required>{{ old('description', $job->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="requirements" class="form-label fw-bold">
                                <i class="bi bi-list-check me-1"></i>Syarat & Ketentuan (opsional)
                            </label>
                            <textarea name="requirements" id="requirements" class="form-control @error('requirements') is-invalid @enderror" rows="4">{{ old('requirements', $job->requirements) }}</textarea>
                            @error('requirements')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">
                                <i class="bi bi-toggle-on me-1"></i>Status <span class="text-danger">*</span>
                            </label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $job->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status', $job->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save-fill me-1"></i> Perbarui
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
