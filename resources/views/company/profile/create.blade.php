@extends('layouts.app')

@section('title', 'Lengkapi Profil Perusahaan')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-building-add me-2"></i>Lengkapi Profil Perusahaan Anda
    </h2>

    <form action="{{ route('company.profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Perusahaan</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="industry" class="form-label">Industri</label>
            <input type="text" name="industry" id="industry" class="form-control" value="{{ old('industry') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Perusahaan</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Lokasi</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo Perusahaan</label>
            <input type="file" name="logo" id="logo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Profil</button>
    </form>
</div>
@endsection
