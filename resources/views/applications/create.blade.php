@extends('layouts.app')

@section('title', 'Lamar Pekerjaan')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Lamar Pekerjaan: {{ $job->title }}</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('applications.store', $job->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="cover_letter" class="form-label">Surat Lamaran</label>
                    <textarea name="cover_letter" id="cover_letter" rows="5" class="form-control">{{ old('cover_letter') }}</textarea>
                    @error('cover_letter')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
