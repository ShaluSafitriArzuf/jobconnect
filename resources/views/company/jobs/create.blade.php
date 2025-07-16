@extends('layouts.app')

@section('title', 'Tambah Lowongan Kerja')

@section('content')
  <div class="container py-4">
    <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold mb-0">
        <i class="bi bi-briefcase-fill me-2"></i> Tambah Lowongan
      </h2>
      <a href="{{ route('company.jobs.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
      </a>
      </div>

      @if ($errors->any())
      <div class="alert alert-danger">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      <strong>Terjadi kesalahan:</strong>
      <ul class="mt-2 mb-0">
      @foreach ($errors->all() as $err)
      <li>{{ $err }}</li>
      @endforeach
      </ul>
      </div>
    @endif

      <div class="card shadow-sm">
      <div class="card-body p-4">
        <form action="{{ route('company.jobs.store') }}" method="POST">
        @csrf

        <!-- Judul Pekerjaan -->
        <div class="mb-3">
          <label for="title" class="form-label fw-bold">
          <i class="bi bi-card-text me-1"></i>Judul Pekerjaan<span class="text-danger">*</span>
          </label>
          <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
          placeholder="Contoh: Front-End Developer" value="{{ old('title') }}" required>
          @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <!-- Kategori -->
        <div class="mb-3">
          <label for="shalu_category_id" class="form-label fw-bold">
          <i class="bi bi-tag me-1"></i>Kategori<span class="text-danger">*</span>
          </label>
          <select name="shalu_category_id" id="shalu_category_id"
          class="form-select @error('shalu_category_id') is-invalid @enderror" required>
          <option value="">-- Pilih Kategori --</option>
          @foreach($categories as $cat)
        <option value="{{ $cat->id }}" @selected(old('shalu_category_id') == $cat->id)>{{ $cat->name }}</option>
      @endforeach
          </select>
          @error('shalu_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
          <label for="description" class="form-label fw-bold">
          <i class="bi bi-file-text me-1"></i>Deskripsi Pekerjaan<span class="text-danger">*</span>
          </label>
          <textarea name="description" id="description" rows="5"
          class="form-control @error('description') is-invalid @enderror"
          required>{{ old('description') }}</textarea>
          @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <!-- Persyaratan -->
        <div class="mb-3">
          <label for="requirements" class="form-label fw-bold">
          <i class="bi bi-list-check me-1"></i>Persyaratan dan Ketentuan
          </label>
          <textarea name="requirements" id="requirements" rows="4"
          class="form-control @error('requirements') is-invalid @enderror">{{ old('requirements') }}</textarea>
          @error('requirements')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
          <!-- Gaji -->
          <div class="mb-3 col-md-6">
          <label for="salary" class="form-label fw-bold">
            <i class="bi bi-currency-dollar me-1"></i>Gaji
          </label>
          <input type="text" name="salary" id="salary" class="form-control @error('salary') is-invalid @enderror"
            value="{{ old('salary') }}">
          @error('salary')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <!-- Lokasi -->
          <div class="mb-3 col-md-6">
          <label for="location" class="form-label fw-bold">
            <i class="bi bi-geo-alt me-1"></i>Lokasi<span class="text-danger">*</span>
          </label>
          <input type="text" name="location" id="location"
            class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" required>
          @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <!-- Tipe -->
          <div class="mb-3 col-md-6">
          <label for="job_type" class="form-label fw-bold">
            <i class="bi bi-clock-fill me-1"></i>Tipe Pekerjaan<span class="text-danger">*</span>
          </label>
          <select name="job_type" id="job_type" class="form-select @error('job_type') is-invalid @enderror"
            required>
            <option value="">-- Pilih --</option>
            @foreach(['Full-Time', 'Part-Time', 'Internship', 'Contract'] as $type)
        <option value="{{ $type }}" @selected(old('job_type') == $type)>{{ $type }}</option>
        @endforeach
          </select>
          @error('job_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <!-- Deadline -->
          <div class="mb-3 col-md-6">
          <label for="deadline" class="form-label fw-bold">
            <i class="bi bi-calendar-event-fill me-1"></i>Batas Waktu<span class="text-danger">*</span>
          </label>
          <input type="date" name="deadline" id="deadline"
            class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}" required>
          @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <button type="reset" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
          </button>
          <button type="submit" class="btn btn-primary">
          <i class="bi bi-save-fill me-1"></i> Simpan Lowongan
          </button>
        </div>

        </form>
      </div>
      </div>
    </div>
    </div>
  </div>
@endsection