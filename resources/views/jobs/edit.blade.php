@extends('layouts.app')

@section('title', 'Edit Lowongan')

@section('content')
    <h2 class="fw-bold mb-4">Edit Lowongan Kerja</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Ada kesalahan input:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jobs.update', $job->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Judul Pekerjaan</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $job->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="5" required>{{ old('description', $job->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $job->location) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Pekerjaan</label>
            <select name="job_type" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Full-Time" {{ $job->job_type === 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                <option value="Part-Time" {{ $job->job_type === 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                <option value="Internship" {{ $job->job_type === 'Internship' ? 'selected' : '' }}>Internship</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $job->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $job->deadline->format('Y-m-d')) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
