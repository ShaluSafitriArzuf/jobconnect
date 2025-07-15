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
                    <form action="{{ route('user.applications.store', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="cover_letter" class="form-label fw-bold">
                                <i class="bi bi-chat-left-text me-1"></i>Pesan Pengantar / Motivasi Melamar <span class="text-danger">*</span>
                            </label>
                            <small class="text-muted d-block mb-2">Ceritakan mengapa kamu tertarik melamar pekerjaan ini, pengalaman yang relevan, atau motivasimu.</small>
                            <textarea name="cover_letter" id="cover_letter" rows="6"
                                class="form-control @error('cover_letter') is-invalid @enderror"
                                placeholder="Contoh: Saya sangat tertarik dengan posisi ini karena saya memiliki pengalaman dalam bidang yang sama selama 2 tahun..." required>{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cv" class="form-label fw-bold">
                                <i class="bi bi-paperclip me-1"></i>Upload CV <span class="text-danger">*</span>
                            </label>
                            <input type="file" name="cv" id="cv" class="form-control @error('cv') is-invalid @enderror" required>
                            @error('cv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="portfolio_link" class="form-label fw-bold">
                                <i class="bi bi-link-45deg me-1"></i>Link Portofolio (opsional)
                            </label>
                            <input type="url" name="portfolio_link" id="portfolio_link"
                                value="{{ old('portfolio_link') }}"
                                class="form-control" placeholder="https://behance.net/namamu">
                        </div>

                        <div class="mb-3">
                            <label for="linkedin_link" class="form-label fw-bold">
                                <i class="bi bi-linkedin me-1"></i>LinkedIn (opsional)
                            </label>
                            <input type="url" name="linkedin_link" id="linkedin_link"
                                value="{{ old('linkedin_link') }}"
                                class="form-control" placeholder="https://linkedin.com/in/namamu">
                        </div>

                        <div class="mb-3">
                            <label for="education" class="form-label fw-bold">
                                <i class="bi bi-mortarboard-fill me-1"></i>Riwayat Pendidikan
                            </label>
                            <input type="text" name="education" id="education"
                                value="{{ old('education') }}"
                                class="form-control" placeholder="Contoh: S1 Teknik Informatika - Universitas ABC" required>
                        </div>

                        <div class="mb-3">
                            <label for="experience" class="form-label fw-bold">
                                <i class="bi bi-briefcase-fill me-1"></i>Pengalaman Kerja
                            </label>
                            <textarea name="experience" id="experience" rows="4" class="form-control" placeholder="Contoh: 2 tahun sebagai Front-End Developer di PT XYZ" required>{{ old('experience') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="domicile" class="form-label fw-bold">
                                <i class="bi bi-geo-alt-fill me-1"></i>Domisili
                            </label>
                            <input type="text" name="domicile" id="domicile"
                                value="{{ old('domicile') }}"
                                class="form-control" placeholder="Contoh: Jakarta Selatan" required>
                        </div>

                        <div class="mb-3">
                            <label for="availability" class="form-label fw-bold">
                                <i class="bi bi-calendar-check-fill me-1"></i>Ketersediaan Mulai Bekerja
                            </label>
                            <select name="availability" id="availability" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="segera" {{ old('availability') == 'segera' ? 'selected' : '' }}>Segera</option>
                                <option value="1_minggu" {{ old('availability') == '1_minggu' ? 'selected' : '' }}>Dalam 1 Minggu</option>
                                <option value="1_bulan" {{ old('availability') == '1_bulan' ? 'selected' : '' }}>Dalam 1 Bulan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">
                                <i class="bi bi-telephone-fill me-1"></i>Nomor Telepon
                            </label>
                            <input type="text" name="phone" id="phone"
                                value="{{ old('phone') }}"
                                class="form-control" placeholder="0812xxxxxxx" required>
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
