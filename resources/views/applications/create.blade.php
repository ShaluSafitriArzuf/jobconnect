@extends('layouts.app')

@section('title', 'Lamar Pekerjaan - ' . $job->title)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">
                    <i class="bi bi-send-fill me-2"></i>Lamar Pekerjaan
                    <span class="text-muted fs-5">({{ $job->title }})</span>
                </h2>
                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('applications.store', $job->id) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="cover_letter" class="form-label fw-bold">
                                <i class="bi bi-file-earmark-text me-1"></i>Surat Lamaran
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="cover_letter" id="cover_letter" rows="8" 
                                class="form-control @error('cover_letter') is-invalid @enderror" 
                                placeholder="Tuliskan surat lamaran Anda...">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Jelaskan mengapa Anda cocok untuk posisi ini (minimal 100 karakter).
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-send-fill me-1"></i> Kirim Lamaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('cover_letter');
        const charCount = document.getElementById('charCount');
        
        textarea.addEventListener('input', function() {
            const remaining = 100 - this.value.length;
            charCount.textContent = remaining > 0 ? 
                `Minimal ${remaining} karakter lagi` : 'Jumlah karakter cukup';
            charCount.className = remaining > 0 ? 'text-danger' : 'text-success';
        });
    });
</script>
@endpush